<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'RelatoriosView.php'); 


class Relatorios extends GenericController {
	private $relatoriosView; 

	public function __construct() {
		$this->relatoriosView = new RelatoriosView(); 
	}	

	public function relatorioView(){
		$this->relatoriosView->relatorioView(); 
	}

	
}