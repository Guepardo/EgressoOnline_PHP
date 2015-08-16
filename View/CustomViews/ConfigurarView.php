<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class ConfigurarView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function configurarView(){
		parent::getTemplateByAction('confNotificacoes'); 
		parent::show(); 
	}
}