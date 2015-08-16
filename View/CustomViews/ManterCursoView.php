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