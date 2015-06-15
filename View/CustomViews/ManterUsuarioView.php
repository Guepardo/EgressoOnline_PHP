<?php 
namespace View\CustomViews; 

use View\GenericView; 

class ManterUsuarioView extends GenericView{
	public function __construct(){
		parent::__construct($this); 
	}

	public function cadastroProfessorView(){
		parent::getTemplateByAction("cadastroProfessor"); 
		parent::show(); 
	}

	public function alterarDadosView(){
		parent::getTemplateByAction("alterarDados"); 
		parent::show(); 
	}
}