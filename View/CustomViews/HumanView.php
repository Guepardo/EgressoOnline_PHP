<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class HumanView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function cadastroView(){
		parent::getTemplateByAction('cadastro');
		parent::show(); 
	}
	
	public function loginView(){
		parent::getTemplateByAction('login'); 
		parent::show(); 
	}
}