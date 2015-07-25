<?php
namespace Controller\UseCase; 

use Controller\GenericController; 
use View\CustomViews\TelaPrincipalView; 


class TelaPrincipal extends GenericController {
	private $telaPrincipalView; 

	public function __construct() {
		$this->telaPrincipalView = new TelaPrincipalView(); 
	}

	public function principalView(){
		$this->telaPrincipalView->principalView(); 
	}
}