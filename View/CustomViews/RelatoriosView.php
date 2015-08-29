<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class RelatoriosView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function relatorioView(){
		parent::getTemplateByAction('relatorios'); 
		parent::show(); 
	}
}