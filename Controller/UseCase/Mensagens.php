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

	public function MensagemDireta($arg){

		if((int) $arg['id'] == $_SESSION['user_id'])
			die(json_encode(array( 'status' => false, 'msg' => 'Não é permitido enviar mensagem direta para si mesmo.' ) )); 

		Lumine::import("Postagem"); 
		Lumine::import("UsuarioHasPostagem"); 

		$post  = new Postagem(); 
		$associativa = new UsuarioHasPostagem(); 

		$post->mensagem = $arg['mensagem']; 
		$post->usuarioId = $_SESSION['user_id']; 
		$post->dataEnvio = date("Y-m-d H:i:s");  
		$post->insert(); 

		$associativa->postagemId = $post->id; 
		$associativa->usuarioId = (int) $arg['id']; 

		$associativa->insert(); 

		die(json_encode(array('status' => true ) ) ); 
	}

}