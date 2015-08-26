<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'VisualizarPerfilView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class VisualizarPerfil extends GenericController {
private $visualizarPerfilView; 

	public function __construct() {
		$this->visualizarPerfilView = new VisualizarPerfilView(); 
	}	

	public function perfilUserView($arg){
		$id = (int) $arg['id']; 
		$this->visualizarPerfilView->perfilUserView($id); 
	}

	public function perfilTurmaView($arg){
		$id = (int) $arg['id']; 
		$this->visualizarPerfilView->perfilTurmaView($id); 
	}
}