<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'AutenticarView.php'); 

class Autenticar extends GenericController {
	private $autenticarView; 

	public function __construct() {
		$this->autenticarView = new AutenticarView(); 
	}	

	public function loginView(){
		$this->autenticarView->loginView(); 
	}

	public function login($arg){

		Lumine::import("Usuario"); 
		$usuario = new Usuario(); 

		$usuario->where("cpf = '". $arg["cpf"]. "' and senha = '". $arg["senha"]."'")->find(); 
		$usuario->fetch(true); 

		$status = is_string($usuario->id); 

		if($status){
			$_SESSION['user_id'] = (int) $usuario->id; 
			Lumine::import("Egresso");

			$egresso = new Egresso(); 
			$egresso->where("usuario_id = ". $usuario->id )->find(); 
			$egresso->fetch(true); 

			$_SESSION['egresso'] = ($egresso->usuarioId !=  null ); 
			
			$_SESSION['coordenador'] = false;
			if( !$_SESSION['egresso'] ){ 

			Lumine::import("Professor"); 
				$professor = new Professor(); 
				$professor->where("usuario_id = ". $usuario->id )->find(); 
				$professor->fetch(true); 

				$_SESSION['coordenador'] = $professor->isCoordenador; 
			}
		}
			
		$this->autenticarView->sendAjax( array( "status" => $status ) ); 
	}

}