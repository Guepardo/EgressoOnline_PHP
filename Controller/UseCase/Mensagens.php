<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 

class Mensagens extends GenericController {


	public function __construct() {
	}	

	public function mensagemMassa($arg){
		Lumine::import("Postagem"); 
		$post = new Postagem(); 

		$post->mensagem = $arg['post']; 
		$post->dataEnvio = date("Y-m-d H:i:s");  
		$post->usuarioId = $_SESSION['user_id'];  
		$post->insert(); 

		die(json_encode(array( 'status' => true ) )); 
	}

}