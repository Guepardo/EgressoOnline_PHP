<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'BuscarView.php'); 

/**
 * Classe que implementa o caso de uso Buscar por perfis de turmas e alunos. 
 */
class Buscar extends GenericController {
	private $buscarView; 

	public function __construct() {
		$this->buscarView = new BuscarView(); 
	}	
	/**
	 * Fachada para o método buscarView da classe BuscarView. 
	 *
	 * @param      <array>  $arg   Ver a entrada deste array na especificação do método da classe BuscarView.
	 * @return     <void> 
	 */
	/** @BlockList({'visitante'}) */
	public function buscaView($arg){
		$this->buscarView->buscaView($arg); 
	}

}