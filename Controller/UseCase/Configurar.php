<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'ConfigurarView.php'); 

class Configurar extends GenericController {
	private $configurarView; 

	public function __construct() {
		$this->configurarView = new ConfigurarView(); 
	}	

	public function configurarView(){
		$this->configurarView->configurarView(); 
	}

}