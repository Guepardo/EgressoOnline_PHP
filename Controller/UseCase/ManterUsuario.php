<?php 
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'ManterUsuarioView.php'); 

require_once(PATH.'Util'.DS.'KeyFactory.php'); 
require_once(PATH.'Util'.DS.'DataValidator.php'); 
require_once(PATH.'Util'.DS.'Mail.php'); 
require_once(PATH.'Util'.DS.'FileWriter.php'); 

class ManterUsuario extends GenericController{
	private $manterUsuarioView; 
	private $dataValidator; 

	public function __construct(){
		$this->manterUsuarioView = new ManterUsuarioView(); 
		$this->dataValidator     = new DataValidator(); 
	}

	public function cadastroProfessorView(){
		$this->manterUsuarioView->cadastroProfessorView(); 
	}

	public function gerenciarCpView(){
		$this->manterUsuarioView->gerenciarCpView(); 
	}

	public function cadastroEgressoView(){
		$this->manterUsuarioView->cadastroEgressoView(); 
	}

	public function addDisciplinasView(){
		$this->manterUsuarioView->addDisciplinaView(); 
	}	

	public function alterarDadosView(){
		//Muda a tela de acordo com o usuario. 
		if( $_SESSION['egresso'] )
			$this->manterUsuarioView->alterarDadosView(); 
		else
			$this->manterUsuarioView->alterarDadosProfessorView();
	}

	public function alterarSenhaView(){
		$this->manterUsuarioView->alterarSenhaView(); 
	}

	public function delDisciplina($arg){
		//roteiro: 
		//Pegar o id do usuário que está logado no memento
		//pegar o id da matéria que desvinculada do usuário. 
		Lumine::import("ProfessorHasDisciplina"); 
		$associativa = new ProfessorHasDisciplina(); 

		//Ver se esses dados estão vazios mais tarde. 
		$idUsuario = $_SESSION['user_id'];
		$idAssociativa = $arg['associativa_id']; 

		$associativa->where("professor_usuario_id = $idUsuario and id = $idAssociativa ")->find(); 
		$associativa->fetch(true); 
		$associativa->delete(); 

		$this->manterUsuarioView->sendAjax(array('status' => true ) );
	}

	public function addDisciplina($arg){
		$this->dataValidator->set("Ano que lecionou", $arg['ano_lecionou'])->is_required()->max_value(3000)->min_value(1900); 

		//Se aconteceu alguma coisa, retorne a mensagem de erro. 
		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 

		Lumine::import("ProfessorHasDisciplina"); 
		$associativa = new ProfessorHasDisciplina(); 
		
		$associativa->disciplinaId = (int) $arg['disciplina_id']; 
		$associativa->anoLecionou = (int)	$arg['ano_lecionou']; 
		$associativa->professorUsuarioId = (int)$_SESSION['user_id']; 
		$associativa->insert(); 

		$this->manterUsuarioView->sendAjax(array('status' => true ) ); 
	}
	
	public function cadastroProfessor($arg){
		//1: Montar a requisição num objeto
		//2: Validar os dados; 
		//2: Enviar para o dão; 
		//3: dizer se tudo ocorreu tudo bem ou não.

		$mail = new Mail(); 
		$passwordToSend = KeyFactory::randomKey(16);


		//Validacao: 
		$this->dataValidator->set("Nome", $arg['nome'])->is_required()->min_length(5)->max_length(140); 
		$this->dataValidator->set("Email", $arg['e_mail'])->is_required()->is_email()->min_length(10)->max_length(140);
		$this->dataValidator->set("Cpf", str_replace(array(".","-"),"",$arg['cpf']))->is_required()->is_cpf(); 
		$this->dataValidator->set("Gênero", $arg['genero_id'])->is_required();  

		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 
		
		Lumine::import("Usuario");
		//validando de há cpf ou email na base de dados. 
		$temp = new Usuario(); 
		$qtdEmail = $temp->get("email", $arg['e_mail']); 
		$qtdCpf   = $temp->get("cpf", $arg['cpf']); 
		
		if($qtdCpf > 0 || $qtdEmail > 0 )
			$this->manterUsuarioView->sendAjax(array('status' => false ) );

		
		Lumine::import("Professor"); 
		Lumine::import("Notificacao"); 
		
		$usuario = new Usuario(); 

		$usuario->nome = $arg['nome']; 
		$usuario->email  = $arg['e_mail']; ;
		$usuario->senha  = md5($passwordToSend);
		$usuario->generoId  = $arg['genero_id'];
		$usuario->cpf  = $arg['cpf'];
		$usuario->foto = 'midia/default.png'; //Adicionando a mídia padrão; 
		$usuario->insert(); 

		$notificacao  = new Notificacao(); 
		$notificacao->usuarioId = $usuario->id; 
		$notificacao->insert(); 

		$professor = new Professor(); 

		$professor->usuarioId = $usuario->id; 
		$professor->isCoordenador = false; 
		$professor->insert(); 

		//$mail->sendEmail("Seu login: ". $usuario->cpf." <br />Sua senha: ". $passwordToSend, $usuario->email,"EgressoOnline UEG - Informe de cadastro", $usuario->nome); 

		$this->manterUsuarioView->sendAjax(array('status' => true ) ); 
	}

	public function cadastroEgresso($arg){
		$mail = new Mail(); 
		$passwordToSend = KeyFactory::randomKey(16);

		//Validacao: 
		$this->dataValidator->set("Nome", $arg['nome'])->is_required()->min_length(5)->max_length(140);
		$this->dataValidator->set("Email", $arg['e_mail'])->is_required()->is_email()->min_length(10)->max_length(140); 
		$this->dataValidator->set("Cpf", str_replace(array(".","-"),"",$arg['cpf']))->is_required()->is_cpf(); 
		$this->dataValidator->set("Ano_Conclusão", $arg['ano_conclusao'])->is_required()->max_value(3000)->min_value( ((int) $arg['ano_ingresso']) + 3);  
		$this->dataValidator->set("Ano_Ingresso", $arg['ano_ingresso'])->is_required()->max_value(3000)->min_value(1900); 

		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 
		
		Lumine::import("Usuario"); 
		//validando de há cpf ou email na base de dados. 
		$temp = new Usuario(); 
		$qtdEmail = $temp->get("email", $arg['e_mail']); 
		$qtdCpf   = $temp->get("cpf", $arg['cpf']); 
		
		if($qtdCpf > 0 || $qtdEmail > 0 )
			$this->manterUsuarioView->sendAjax(array('status' => false, 'msg' => 'Cpf ou Email já foi cadastrado no sistema.') );

		Lumine::import("Egresso"); 
		Lumine::import("Localidade"); 
		Lumine::import("Emprego"); 
        Lumine::import("Notificacao"); 
        Lumine::import("Turma"); 

		$usuario = new Usuario(); 

		$usuario->nome      = $arg['nome']; 
		$usuario->email     = $arg['e_mail']; ;
		$usuario->senha     = md5($passwordToSend);
		$usuario->generoId  = $arg['genero_id'];
		$usuario->cpf       = $arg['cpf'];
		$usuario->foto = 'midia/default.png'; //Adicionando a mídia padrão; 
		$usuario->insert(); 

		$notificacao  = new Notificacao(); 
		$notificacao->usuarioId = $usuario->id; 
		$notificacao->insert(); 

		$localidade   = new Localidade(); 
		$localidade->insert(); 

		$emprego      = new Emprego(); 
		$localEmprego = new Localidade(); 
		$localEmprego->insert(); 

		//$emprego->atuacaoProfissionalId = 1; 
		//$emprego->faixaSalarialId = 1; 
		$emprego->localidadeId = $localEmprego->id; 
		$emprego->insert();

		//Verificando se a turma existe; 
		$idTurma; 

		$turma   = new Turma(); 
		$turma->get('ano', (int) $arg['ano_conclusao']); 

		if($turma->id != null )
			$idTurma = $turma->id; 
		else
			$idTurma = self::criarNovaTurma($arg['ano_conclusao']); 

		$egresso = new Egresso(); 

		$egresso->anoIngresso   = $arg['ano_ingresso']; 
		$egresso->anoConclusao  = $arg['ano_conclusao']; 
		$egresso->isDadoPublico = false; 
		$egresso->empregoId     = $emprego->id; 
		$egresso->estadoCivilId = 1; 
		$egresso->localidadeId  = $localidade->id; 
		$egresso->usuarioId     = $usuario->id; 
		$egresso->turmaId       = $idTurma; 
		$egresso->insert(); 

		//$mail->sendEmail("Seu login: ". $arg['cpf']." <br />Sua senha: ". $passwordToSend, $arg['e_mail'],"EgressoOnline UEG - Informe de cadastro", $arg['nome']); 
		
		$this->manterUsuarioView->sendAjax(array('status' => true ) ); 
	}

	public function alterarSenha($arg){
		//Validacao: 

		$this->dataValidator->set("Senha", $arg['nova_senha'])->is_required()->is_equals($arg['confirmacao']); 

		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 
		
		Lumine::import("Usuario"); 
		$usuario = new Usuario(); 
		$usuario->get($_SESSION['user_id']); 

		if(strcmp($usuario->senha, $arg['senha']) == 0){
			$usuario->senha = $arg['nova_senha']; 
			$usuario->update(); 
			$this->manterUsuarioView->sendAjax(array('status' => true ) ); 
		}

		$this->manterUsuarioView->sendAjax(array('status' => false ) ); 
	}

	public function alterarDadosProfessor($arg){
		//Validacao: 
		$this->dataValidator->set("Nome", $arg['nome'])->is_required()->min_length(5)->max_length(140); 
		$this->dataValidator->set("Email", $arg['e_mail'])->is_required()->is_email()->min_length(10)->max_length(140);

		Lumine::import("Usuario"); 
		$temp = new Usuario(); 

		$qtdEmail = $temp->get('email', $arg['e_mail']); 


		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 
		
		Lumine::import("Usuario"); 
		$usuario = new Usuario(); 
		$usuario->get($_SESSION['user_id']); 

		if( ($qtdEmail > 0) && (strcmp($usuario->email, $arg['e_mail'] ) != 0) )
			$this->manterUsuarioView->sendAjax(array('status' => false ) ); 

		$usuario->nome = $arg['nome']; 
		$usuario->email = $arg['e_mail']; 
		$usuario->update(); 

		$this->manterUsuarioView->sendAjax(array('status' => true ) ); 		
	}

	public function  cadastroCurso($arg){
		//Espero um dia ter tempo para implementar a validação dos dados que estão 
		//entrado :v

		Lumine::import("Curso"); 
		$curso = new Curso(); 

		$curso->instituicao       = $arg['instituicao']; 
		$curso->areaNome          = $arg['nome_area']; 
		$curso->anoConclusao      = $arg['ano_conclusao']; 
		$curso->usuarioId         = (int) $_SESSION['user_id'];  
		$curso->tituloAcademicoId = $arg['titulo_academico_id']; 

		$curso->insert(); 

		$this->manterUsuarioView->sendAjax(array('status' => true ) );  
	}

	public function deletarCurso($arg){
		Lumine::import("Curso"); 
		$curso = new Curso(); 
		$curso->get((int) $arg['id']); 	
		$curso->delete();  

		$this->manterUsuarioView->sendAjax(array('status' => true ) ); 
	}

	public function alterarCurso($arg){
		Lumine::import("Curso"); 
		$curso = new Curso(); 
		
		$curso->get((int) $arg['id']); 
		$curso->instituicao       = $arg['instituicao']; 
		$curso->areaNome          = $arg['nome_area']; 
		$curso->anoConclusao      = $arg['ano_conclusao']; 
		$curso->tituloAcademicoId = (int) $arg['titulo_academico_id']; 

		$curso->update(); 

		$this->manterUsuarioView->sendAjax(array('status' => true ) );  
	}
	private function verifyErros($array){
		if(!empty($array)){
			$array['status'] = false; 
			$this->manterUsuarioView->sendAjax($array); 
		}
	}

	private function criarNovaTurma($anoConclusao){
		Lumine::import("Turma"); 
		$turma = new Turma(); 
		$turma->ano = (int) $anoConclusao; 
		$turma->insert(); 
		return $turma->id; 
	}

}