<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'BuscarView.php'); 


class Buscar extends GenericController {
	private $buscarView; 

	public function __construct() {
		$this->buscarView = new BuscarView(); 
	}	

	public function buscaView($arg){
		$this->buscarView->buscaView($arg); 
	}

}