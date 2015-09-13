<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class SecurityView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function notFoundView(){
		parent::getTemplateByAction('404'); 	
		parent::show(); 
	}


	public function blockView(){
		parent::getTemplateByAction('negado'); 	
		parent::show(); 
	}

}