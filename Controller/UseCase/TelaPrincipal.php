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

	public function feed($arg){
		Lumine::import("Postagem"); 
		Lumine::import("UsuarioHasPostagem");
		Lumine::import("Oportunidade"); 

		//Pegando localidador da patinação: 
		$begin = (int) $arg['begin']; 
		$end   = (int) $arg['end']; 
		
		//recuperando Id do usuário corrent: 
		$userId = $_SESSION['user_id']; 
		
		//Apanas para testes 
		$dataAtual = date("Y-m-d H:i:s"); 

		$associativa = new UsuarioHasPostagem(); 
		$postagem = new Postagem(); 
		$oportunidade = new Oportunidade(); 

		$postagem->where("data_envio = ")->find(); 
		$oportunidade->find(); 

		die(json_encode( $oportunidade->allToArray())); 
		die(json_encode($postagem->allToArray())); 
	}
}