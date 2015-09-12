<?php 
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'ManterUsuarioView.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'TelaPrincipalView.php'); 

require_once(PATH.'Util'.DS.'KeyFactory.php'); 
require_once(PATH.'Util'.DS.'DataValidator.php'); 
require_once(PATH.'Util'.DS.'Mail.php'); 
require_once(PATH.'Util'.DS.'FileWriter.php'); 
require_once(PATH.'Util'.DS.'Image.php');

class ManterUsuario extends GenericController{
	private $manterUsuarioView; 
	private $dataValidator; 

	public function __construct(){
		$this->manterUsuarioView = new ManterUsuarioView(); 
		$this->dataValidator     = new DataValidator(); 
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function cadastroProfessorView(){
		$this->manterUsuarioView->cadastroProfessorView(); 
	}

	public function alterarFotoView(){
		$this->manterUsuarioView->alterarFotoView(); 
	}

	/** @BlockList({'visitante'}) */
	public function gerenciarCpView(){
		$this->manterUsuarioView->gerenciarCpView(); 
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function cadastroEgressoView(){
		$this->manterUsuarioView->cadastroEgressoView(); 
	}

	/** @BlockList({'visitante'}) */
	public function addDisciplinasView(){
		$this->manterUsuarioView->addDisciplinaView(); 
	}	

	/** @BlockList({'visitante'}) */
	public function alterarDadosView(){
		//Muda a tela de acordo com o usuario. 
		if( $_SESSION['user']['egresso'] )
			$this->manterUsuarioView->alterarDadosView(); 
		else
			$this->manterUsuarioView->alterarDadosProfessorView();
	}

	/** @BlockList({'visitante'}) */
	public function alterarSenhaView(){
		$this->manterUsuarioView->alterarSenhaView(); 
	}

	/** @BlockList({'visitante'}) */
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

	/** @BlockList({'visitante'}) */
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
	
	/** @BlockList({'visitante','professor','egresso'}) */
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
		$usuario->foto = 'Midia\default.png'; //Adicionando a mídia padrão; 
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

	/** @BlockList({'visitante','professor','egresso'}) */
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
		Lumine::import("EgressoHasRedeSocial"); 

		$usuario = new Usuario(); 

		$usuario->nome      = $arg['nome']; 
		$usuario->email     = $arg['e_mail']; ;
		$usuario->senha     = md5($passwordToSend);
		$usuario->generoId  = $arg['genero_id'];
		$usuario->cpf       = $arg['cpf'];
		$usuario->foto = 'Midia/default.png'; //Adicionando a mídia padrão; 
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
		$egresso->isDadoPublico = true; 
		$egresso->empregoId     = $emprego->id; 
		$egresso->estadoCivilId = 1; 
		$egresso->localidadeId  = $localidade->id; 
		$egresso->usuarioId     = $usuario->id; 
		$egresso->turmaId       = $idTurma; 
		$egresso->insert(); 

		//Adicionando as Redes Sociais para o egresso. 
		for( $a = 1 ; $a <= 3 ; $a++ ){
			$rede = new EgressoHasRedeSocial(); 
			$rede->usuarioId = $egresso->usuarioId; 
			$rede->redeSocialId = $a;// Os valores aqui são a sequência no banco de dados da tabela de Redes Sociais. 
			$rede->insert(); 
		}

		//$mail->sendEmail("Seu login: ". $arg['cpf']." <br />Sua senha: ". $passwordToSend, $arg['e_mail'],"EgressoOnline UEG - Informe de cadastro", $arg['nome']); 
		
		$this->manterUsuarioView->sendAjax(array('status' => true ) ); 
	}
	/** @BlockList({'visitante'}) */
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

	/** @BlockList({'visitante','egresso'}) */
	public function alterarDadosProfessor($arg){
		//Validacao: 
		$this->dataValidator->set("Nome", $arg['nome'])->is_required()->min_length(5)->max_length(140); 
		$this->dataValidator->set("Email", $arg['e_mail'])->is_required()->is_email()->min_length(10)->max_length(140);

		Lumine::import("Usuario"); 
		$temp = new Usuario(); 

		$qtdEmail = $temp->get('email', $arg['e_mail']); 


		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 
		
		$usuario = new Usuario(); 
		$usuario->get($_SESSION['user_id']); 

		if( ($qtdEmail > 0) && (strcmp($usuario->email, $arg['e_mail'] ) != 0) )
			$this->manterUsuarioView->sendAjax(array('status' => false, 'msg' => "Esse e-mail já foi cadastrado no sistema" ) ); 

		$usuario->nome = $arg['nome']; 
		$usuario->email = $arg['e_mail']; 
		$usuario->update(); 

		$this->manterUsuarioView->sendAjax(array('status' => true ) ); 		
	}

	//Alterar dados para egresso. 
	/** @BlockList({'visitante','professor','coordenador'}) */
	public function alterarDados($arg){	
		//Validacao: 
		$this->dataValidator->set("Nome", $arg['nome'])->is_required()->min_length(5)->max_length(140);
		$this->dataValidator->set("Email", $arg['email'])->is_required()->is_email()->min_length(10)->max_length(140); 

		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 
		
		Lumine::import("Usuario"); 
		//validando email na base de dados. 
		$temp     = new Usuario(); 
		$qtdEmail = $temp->get("email", $arg['email']); 

		Lumine::import("Egresso"); 

		Lumine::import("Localidade"); 
		Lumine::import("Emprego"); 
		Lumine::import("EgressoHasRedeSocial"); 
		Lumine::import("Cidade");

		$usuario = new Usuario(); 
		$usuario->get($_SESSION['user_id']); 

		if( ($qtdEmail > 0) && (strcmp($usuario->email, $arg['email'] ) != 0) )
			$this->manterUsuarioView->sendAjax(array('status' => false, 'msg' => "O seu novo endereço de e-mail já foi cadastrado no sistema." ) ); 
	    //aqui. 
	    //
		$egresso = new Egresso(); 
		$egresso->get('usuarioId', $_SESSION['user_id']); 

		$emprego = new Emprego(); 
		$emprego->get($egresso->empregoId); 

		$localidadeEgresso = new Localidade(); 
		$localidadeEgresso->get($egresso->localidadeId); 

		$localidadeEmprego = new Localidade(); 
		$localidadeEmprego->get($emprego->localidadeId); 
		
		//Adicionando os daos modificados: 
		$usuario->nome = $arg['nome']; 
		$usuario->email =$arg['email']; 
		$usuario->update();

		$egresso->estadoCivilId 	= $arg['estado_civil_id']; 
		$egresso->telefone 			= $arg['telefone']; 
		$egresso->qtdFilhos 		= $arg['qtd_filhos']; 
		$egresso->endereco 			= $arg['endereco']; 
		$egresso->isDadoPublico  	= !empty($arg['is_dado_publico']); 
		$egresso->alterouDado       = 1; //diz que o usuário já alterou os dados ao menos uma vez. 
		$egresso->update(); 
		
		if((int) $arg['egresso_pais_id'] == 33 ){

			if(empty($arg['egresso_cidade_id']))
				$this->manterUsuarioView->sendAjax(array('status' => false, 'msg' => "Selecione um estado e uma cidade para a sua localização." ) ); 

			$cidade = new Cidade(); 
			$cidade->get('des', $arg['egresso_cidade_id']); 
			$localidadeEgresso->paisId      = (int) $arg['egresso_pais_id']; 
			$localidadeEgresso->cidadeId    = $cidade->id ; 
			$localidadeEgresso->complemento = null;
		}else{
			$localidadeEgresso->paisId      = (int) $arg['egresso_pais_id'];  
			$localidadeEgresso->cidadeId    = null ; 
			$localidadeEgresso->complemento = $arg['egresso_complemento'];
		}

		$localidadeEgresso->update(); 
		
		
		if(!empty($arg['has_emprego'])){
			if((int) $arg['emprego_pais_id'] == 33 ){

				if(empty($arg['emprego_cidade_id']))
					$this->manterUsuarioView->sendAjax(array('status' => false, 'msg' => "Selecione um estado e uma cidade para a sua localização do seu trabalho." ) ); 

				$cidade = new Cidade(); 
				$cidade->get('des', $arg['emprego_cidade_id']); 
				$localidadeEmprego->paisId      = (int) $arg['emprego_pais_id']; 
				$localidadeEmprego->cidadeId    = $cidade->id; 
				$localidadeEmprego->complemento = null; 
			}else{
				$localidadeEmprego->paisId      = (int) $arg['emprego_pais_id']; 
				$localidadeEmprego->cidadeId    = null; 
				$localidadeEmprego->complemento = $arg['emprego_complemento']; 
			}

			$localidadeEmprego->update(); 

			if(!empty($arg['is_area_ti']))
				$emprego->atuacaoProfissionalId = $arg['atuacao_profissional_id']; 

			$emprego->faixaSalarialId       = $arg['faixa_salarial_id']; 
			$emprego->nomeEmpresa       	= $arg['empresa_nome']; 
			$emprego->publico 				= !empty($arg['is_publica']); 
			$emprego->areaTi  				= !empty($arg['is_area_ti']);
		}

		$emprego->hasEmprego  			= !empty($arg['has_emprego']);
		$emprego->update(); 

		$rede = new EgressoHasRedeSocial(); 
		$rede->where("usuario_id = ". $_SESSION['user_id']." and rede_social_id = ". 1)->find(); 
		$rede->fetch(true); 
		$rede->linkAcesso = $arg['twitter']; 
		$rede->update(); 

		$rede = new EgressoHasRedeSocial(); 
		$rede->where("usuario_id = ". $_SESSION['user_id']." and rede_social_id = ". 2)->find(); 
		$rede->fetch(true); 
		$rede->linkAcesso = $arg['linkedin']; 
		$rede->update(); 

		$rede = new EgressoHasRedeSocial(); 
		$rede->where("usuario_id = ". $_SESSION['user_id']." and rede_social_id = ". 3)->find(); 
		$rede->fetch(true); 
		$rede->linkAcesso = $arg['facebook']; 
		$rede->update(); 
		
		$this->manterUsuarioView->sendAjax(array('status' => true ) );	
	}

	/** @BlockList({'visitante'}) */
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

	/** @BlockList({'visitante'}) */
	public function deletarCurso($arg){
		Lumine::import("Curso"); 
		$curso = new Curso(); 
		$curso->get((int) $arg['id']); 	
		$curso->delete();  

		$this->manterUsuarioView->sendAjax(array('status' => true ) ); 
	}

	/** @BlockList({'visitante'}) */
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

	/** @BlockList({'visitante'}) */
	public function alterarFoto($arg){
		//Criando instância para página principal
		$principal = new TelaPrincipalView();

		$m = new Image(); 
		$result = $m->saveCropAvatar('file',$arg['x'],$arg['y'],$arg['x2'],$arg['y2']); 
		Lumine::import("Usuario"); 

		$usuario = new Usuario(); 
		$total = $usuario->get($_SESSION['user_id']); 

		if($total < 0){
			die("error");
		}
		if(is_int($result)){
			$msg = array('nopost_msg' => 'Erro: '.$m->errors[$result] ); 
			$this->manterUsuarioView->alterarFotoView($msg);
			exit; 
		}

		$lastImage = $usuario->foto; 

		if(strcmp($lastImage,'Midia/default.png') != 0)
			unlink(PATH.$lastImage); 

		$usuario->foto = 'Midia'.DS.$result; 
		$usuario->update(); 

		//Passando mensagem interna para a outra tela 
		$msg = array('nopost_msg' => "Sua foto de perfil foi modificada com sucesso."); 
		$principal->principalView($msg); 
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
		$turma->foto = 'Midia//default_turma.png'; 
		$turma->insert(); 
		return $turma->id; 
	}

}