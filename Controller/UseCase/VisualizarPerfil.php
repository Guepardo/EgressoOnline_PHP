<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'VisualizarPerfilView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

/**
 * Classe que implementa o caso de uso visualizar perfil
 */
class VisualizarPerfil extends GenericController {
private $visualizarPerfilView; 

	
	public function __construct() {
		$this->visualizarPerfilView = new VisualizarPerfilView(); 
	}	

	/**
	 * Fachada para o método perfilUserView da classe visualizarPerfilView. 
	 *
	 * @param      <array>  $arg   Ver a entrada deste array na especificação do método da classe visualizarPerfilView.
	 * @return     <void> 
	 */
	/** @BlockList({'visitante'}) */
	public function perfilUserView($arg){
		$id = (int) $arg['id']; 
		$this->visualizarPerfilView->perfilUserView($id); 
	}

	/**
	 * Fachada para o método perfilTurmaView da classe visualizarPerfilView. 
	 *
	 * @param      <array>  $arg   Ver a entrada deste array na especificação do método da classe visualizarPerfilView.
	 * @return     <void> 
	 */
	/** @BlockList({'visitante'}) */
	public function perfilTurmaView($arg){
		$this->visualizarPerfilView->perfilTurmaView($arg); 
	}
}