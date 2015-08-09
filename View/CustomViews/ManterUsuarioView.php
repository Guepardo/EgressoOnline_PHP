<?php 
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class ManterUsuarioView extends GenericView{
	public function __construct(){
		parent::__construct($this); 
	}

	public function cadastroProfessorView(){
		parent::getTemplateByAction("cadastroProfessor"); 
		parent::show(); 
	}

	public function cadastroEgressoView(){
		parent::getTemplateByAction("cadastroEgresso"); 
		parent::show(); 
	}

	public function addDisciplinaView(){
		parent::getTemplateByAction("adicionarDisciplinas");
		Lumine::import("Professor"); 
		Lumine::import("ProfessorHasDisciplina"); 
		Lumine::import("Disciplina"); 

		$professor = new Professor(); 
		$associativa = new ProfessorHasDisciplina(); 
		$disciplina = new Disciplina(); 

		//Adicionando as matérias do bd no dropdown
		$disciplina->find(); 

		while( $disciplina->fetch() ){
			parent::$templator->setVariable('disciplina.descri', utf8_encode($disciplina->des)); 
			parent::$templator->setVariable('disciplina.id', $disciplina->id);  
			parent::$templator->addBlock('disciplinas'); 
		}

		$associativa->where("professor_usuario_id = ". $_SESSION['user_id'])->find(); 

		while( $associativa->fetch() ){
			$disciplina = new Disciplina(); 
			$disciplina->get($associativa->disciplinaId); 

			parent::$templator->setVariable('disciplina.name', utf8_encode($disciplina->des)); 
			parent::$templator->setVariable('associativa.id', $associativa->id); 
			parent::$templator->setVariable('disciplina.ano_lecionou',$associativa->anoLecionou);
			parent::$templator->addBlock('table'); 
		}


			parent::show(); 
	}

	public function alterarDadosView(){
		parent::getTemplateByAction("alterarDados"); 
		parent::show(); 
	}

	public function alterarSenhaView(){
		parent::getTemplateByAction("alterarSenha"); 
		parent::show(); 
	}

	public function alterarDadosProfessorView(){
		parent::getTemplateByAction("alterarDadosProfessor"); 
		Lumine::import("Usuario"); 
		Lumine::import("Professor"); 

		$professor = new Professor(); 
		$usuario = new Usuario(); 

		$professor->join($usuario)->where(" usuario_id = ". $_SESSION['user_id'])->find(); 
		$professor->fetch(true); 

		parent::$templator->setVariable("usuario.email", $professor->email); 
		parent::$templator->setVariable("usuario.nome", $professor->nome);

		parent::show(); 
	}
}