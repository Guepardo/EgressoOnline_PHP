<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class VisualizarPerfilView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function perfilUserView(){
		parent::getTemplateByAction('perfil'); 
		parent::show(); 
	}

	public function perfilTurmaView(){
		parent::getTemplateByAction('perfilTurma'); 
		parent::show(); 
	}
}