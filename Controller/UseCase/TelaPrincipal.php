<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'TelaPrincipalView.php'); 
require_once(PATH.'DAO'.DS.'CustomDAOs'.DS.'DAOFeed.php'); 


class TelaPrincipal extends GenericController {
	private $telaPrincipalView; 

	public function __construct() {
		$this->telaPrincipalView = new TelaPrincipalView(); 
	}

	public function principalView(){
		$this->telaPrincipalView->principalView(); 
	}

	public function feed1($arg){
		Lumine::import("Postagem"); 
		Lumine::import("UsuarioHasPostagem");
		Lumine::import("Oportunidade"); 
		//Taxa fixa de mensagem que serão enviadas por vez: 
		$taxa = 3; 

		//Pegando localidador da patinação: 
		$last = $arg['last']; 

		//indica se 
		//recuperando Id do usuário corrent: 
		$userId = $_SESSION['user_id']; 

		if(!strcmp($last,'false')){
			//recuperando a data de interação mais recente com o sistema. 
			$postagem = new Postagem(); 
			$postagem->select("MAX(data_envio) as maior")->find(); 
			$lastPostagem = $postagem->allToArray()[0]["maior"]; 

			$op = new Oportunidade(); 
			$op->select("MAX(data_divulgacao) as maior")->find(); 
			$lastOp = $op->allToArray()[0]["maior"]; 

			if( strtotime($lastPostagem) > strtotime($lastOp) )
				$last 	= $lastPostagem;
			else
				$last = $lastOp;  
		}
		echo($last); 
		$postagem = new Postagem(); 
		$postagem->order("data_envio DESC")->where("data_envio < '$last'")->limit($taxa)->find(); 

		$resultPostagem = $postagem->allToArray(); 
		//pegando posgatens de divulgação de op entre as datas da última postagem. 
		$resultOp; 

		if(count($resultPostagem) != 0 ){
			$lastDatePostagem  = $resultPostagem[count($resultPostagem)-1]['dataEnvio'];
			$firstDatePostegem = $resultPostagem[0]['dataEnvio']; 

			$op = new Oportunidade(); 
			$op->order("data_divulgacao DESC")->where("(data_divulgacao > '$firstDatePostegem') and (data_divulgacao < '$lastDatePostagem')")->find(); 
			$resultOp = $op->allToArray(); 
		}else{
			//assumir que não há mais mensagem e fazer requisições apenas das oportunidades de emrpego. 
			$op = new Oportunidade(); 
			$op->order("data_divulgacao DESC")->where("data_divulgacao < '$last'")->limit($taxa)->find(); 
			$resultOp = $op->allToArray();
		}

		var_dump($resultOp); 
		var_dump($resultPostagem); 
	}

	public function feed($arg){
		$limit = 10; 

		$daoFeed = new DAOFeed(); 

		$result = $daoFeed->feed('2015-08-22 11:55:12',$limit); 
		
		if(!is_array($result) || count($result) == 0 )
			$this->telaPrincipalView->sendAjax(array('status' => false , 'msg' => 'Não há mais mansagens')); 

		//Procurar oportunidades e mensagens a partir do id data; 
		Lumine::import("Postagem"); 
		Lumine::import("Oportunidade"); 
		Lumine::import("UsuarioHasPostagem"); 
		Lumine::import("Usuario"); 

		do{
			$array = array(); 
			foreach($result as $temp ){
				$post = new Postagem(); 
				$op   = new Oportunidade(); 

				$tam = $post->get('id', (int) $temp[0]);

				//é uma mensagem: 
				if( $tam > 0 && (strcmp($post->dataEnvio, $temp[1] ) == 0 ) ){
					$usuario = new Usuario(); 
					$associativa = new UsuarioHasPostagem(); 
					$usuario->get('id',$post->usuarioId); 

					//obtendo destinatário; 
					$tam = $associativa->get('usuario_id', $_SESSION['user_id']); 

					//Se a mensagem é uma mensagem direta: 
					if($tam > 0 && $associativa->postagemId == $post->id){
						$usuario->get('id', $post->usuarioId); 
						array_push($array, array('remetente' => $usuario->nome, 'data_envio' => $post->dataEnvio , 'msg' => $post->mensagem , 'publica' => false)); 
					}
					
					//mensagem do pública: 
					//
				}
			}
		}while( count($array) < $limit); 

	}
}