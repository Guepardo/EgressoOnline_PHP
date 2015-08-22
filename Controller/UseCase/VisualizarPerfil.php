<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'VisualizarPerfilView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class VisualizarPerfil extends GenericController {
private $visualizarPerfilView; 

	public function __construct() {
		$this->visualizarPerfilView = new VisualizarPerfilView(); 
	}	

	public function perfilUserView(){
		$this->visualizarPerfilView->perfilUserView(); 
	}

	public function perfilTurmaView(){
		$this->visualizarPerfilView->perfilTurmaView(); 
	}
}