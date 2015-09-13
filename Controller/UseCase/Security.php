<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'SecurityView.php'); 

class Security extends GenericController {
private $securityView; 

	public function __construct() {
		$this->securityView = new SecurityView(); 
	}	

	/** @BlockList({'noblock'}) */
	public function notFoundView($arg){
		$this->securityView->notFoundView(); 
	}

	/** @BlockList({'noblock'}) */
	public function blockView($arg){
		$this->securityView->block(); 
	}


}