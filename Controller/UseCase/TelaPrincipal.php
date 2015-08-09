<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'TelaPrincipalView.php'); 


class TelaPrincipal extends GenericController {
	private $telaPrincipalView; 

	public function __construct() {
		$this->telaPrincipalView = new TelaPrincipalView(); 
	}

	public function principalView(){
		$this->telaPrincipalView->principalView(); 
	}
}