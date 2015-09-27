<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'SecurityView.php'); 

/**
 * É uma classe de controle para lançar telas de bloqueio e de páginas não encotradas quando for necessário. 
 */
class Security extends GenericController {
private $securityView; 

	public function __construct() {
		$this->securityView = new SecurityView(); 
	}	

	/**
	 * Fachada para o método notFoundView da classe SecurityView. 
	 *
	 * @param      <array>  $arg   Ver a entrada deste array na especificação do método da classe SecurityView.
	 * @return     <void> 
	 */
	/** @BlockList({'noblock'}) */
	public function notFoundView($arg){
		$this->securityView->notFoundView(); 
	}

	/**
	 * Fachada para o método blockView da classe SecurityView. 
	 *
	 * @param      <array>  $arg   Ver a entrada deste array na especificação do método da classe SecurityView.
	 * @return     <void> 
	 */
	/** @BlockList({'noblock'}) */
	public function blockView($arg){
		$this->securityView->blockView(); 
	}


}