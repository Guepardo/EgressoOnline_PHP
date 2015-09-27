<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 

/**
 * Esta classe implementa o caso de uso postar mensagens. 
 */
class Mensagens extends GenericController {
	public function __construct() {
	}	

	/**
	 * Envia uma mensagem em passa. Ou seja, a mensagem enviada por aqui é visível por todos os usuários do sistema. 
	 *
	 * @param      <array>  $arg   Recebe um array com a chave post (string)
	 * @return     <JSON> {status : boolean, msg : string }
	 */
	/** @BlockList({'visitante'}) */
	public function mensagemMassa($arg){
		Lumine::import("Postagem"); 
		$post = new Postagem(); 

		self::msgLengthAllow($arg['post']); 

		$post->mensagem = $arg['post']; 
		$post->dataEnvio = date("Y-m-d H:i:s");  
		$post->usuarioId = $_SESSION['user_id'];  
		$post->insert(); 

		die(json_encode(array( 'status' => true ) )); 
	}

	/**
	 * Envia uma mensagem direta de um usuário para outro. 
	 *
	 * @param      <array>  $arg   Recebe um array com as chaves mensagem (string) e id (int). a chave id deve ser a chave primária que representa o usuário que irá receber a mensagem. 
	 * @return     <JSON> {status : boolean , msg : string}
	 */
	/** @BlockList({'visitante'}) */
	public function MensagemDireta($arg){

		if((int) $arg['id'] == $_SESSION['user_id'])
			die(json_encode(array( 'status' => false, 'msg' => 'Não é permitido enviar mensagem direta para si mesmo.' ) )); 
		
		self::msgLengthAllow($arg['mensagem']);

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

	
	private function msgLengthAllow($msg){
		$length = strlen($msg); 
		$result = 0; 

		if($length <= 3)
			$result =  1; 
		if( $length > 400)
			$result =  2; 

		switch($result){
			case 1: 
			die(json_encode(array( 'status' => false, 'msg' => 'Parece que sua mensagem é peguena demais. Tente escrever mais do que 3 caracteres.' ) )); 
			case 2: 
			die(json_encode(array( 'status' => false, 'msg' => 'Parece que sua mensagem é grande demais. Tente escrever menos do que 400 caracteres. ' ) )); 
		}
	}
}