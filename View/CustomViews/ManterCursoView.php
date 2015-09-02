<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class ManterCursoView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function configurarView(){
		parent::getTemplateByAction('confNotificacoes'); 
		parent::show(); 
	}

	public function transferirView(){
		parent::getTemplateByAction('transferir'); 
		Lumine::import("Professor"); 
		Lumine::import("Usuario"); 

		$professor = new Professor(); 
		$usuario = new Usuario(); 

		$usuario->join($professor)->where("is_coordenador =  0")->limit(500)->find(); 

		while($usuario->fetch()){
			parent::$templator->setVariable('professor.foto', $usuario->foto ); 
			parent::$templator->setVariable('professor.nome', $usuario->nome ); 
			parent::$templator->setVariable('professor.email', $usuario->email ); 
			parent::$templator->setVariable('professor.id', $usuario->id ); 

			parent::$templator->addBlock('row'); 
		}

		parent::show(); 
	}

	public function novaAreaView(){
		parent::getTemplateByAction('novaAreaAtuacao'); 
		Lumine::import("AtuacaoProfissional"); 
		$atuacao = new AtuacaoProfissional(); 

		$atuacao->find(); 
		while($atuacao->fetch()){
			parent::$templator->setVariable('nome',Convert::toUTF_8($atuacao->des)); 
			parent::$templator->setVariable('id', $atuacao->id);
			parent::$templator->addBlock('row'); 
		}
		parent::show(); 
	}

	public function novaDisciplinaView(){
		parent::getTemplateByAction('novaDisciplina'); 
		Lumine::import("Disciplina"); 
		$disciplina = new Disciplina(); 

		$disciplina->find(); 
		while($disciplina->fetch()){
			parent::$templator->setVariable('nome',Convert::toUTF_8($disciplina->des)); 
			parent::$templator->setVariable('id', $disciplina->id);
			parent::$templator->addBlock('row'); 
		}
		parent::show(); 
	}
}