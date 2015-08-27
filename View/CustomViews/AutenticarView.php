<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class AutenticarView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function loginView(){
		parent::getTemplateByAction('login'); 
		parent::show(); 
	}

	public function alterarSenhaView(){
		parent::getTemplateByAction("alterarSenha"); 
		parent::show(); 
	}
}