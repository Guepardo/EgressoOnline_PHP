<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'TelaPrincipalView.php'); 
require_once(PATH.'DAO'.DS.'CustomDAOs'.DS.'DAOFeed.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 


class TelaPrincipal extends GenericController {
	private $telaPrincipalView; 

	public function __construct() {
		$this->telaPrincipalView = new TelaPrincipalView(); 
	}

	public function principalView(){
		$this->telaPrincipalView->principalView(); 
	}

	

	public function feed($arg){
		$limit = 10; 

		$daoFeed = new DAOFeed(); 

		if( empty($arg['date']) )
			$arg['date'] = date("Y-m-d H:i:s"); 

		$result = $daoFeed->feed((string) $arg['date'],$limit); 
		
		if(!is_array($result) || count($result) == 0 )
			$this->telaPrincipalView->sendAjax(array('status' => false , 'msg' => 'Não há mais mansagens')); 
		
		//Procurar oportunidades e mensagens a partir do id data; 
		Lumine::import("Postagem"); 
		Lumine::import("Oportunidade"); 
		Lumine::import("UsuarioHasPostagem"); 
		Lumine::import("Usuario"); 

		Lumine::import("OpPosGraduacao"); 
		Lumine::import("OpEmprego"); 

		$array = array(); 


		do{
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
					$tam = $associativa->get('usuarioId', $_SESSION['user_id']); 

					$usuario->get('id', $post->usuarioId); 
					//Se a mensagem é uma mensagem direta: 
					if($tam > 0 && $associativa->postagemId == $post->id)
						array_push($array, array('foto' => $usuario->foto, 'id' => $post->id, 'remetente' => Convert::toUTF_8($usuario->nome), 'data_envio' => $post->dataEnvio , 'msg' => Convert::toUTF_8($post->mensagem) , 'publica' => false, 'post' => true));  
					else
						array_push($array, array('foto' => $usuario->foto, 'id' => $post->id, 'remetente' => Convert::toUTF_8($usuario->nome), 'data_envio' => $post->dataEnvio , 'msg' => Convert::toUTF_8($post->mensagem) , 'publica' => true, 'post' => true)); 
				}

				$tam = $op->get('id', (int) $temp[0]); 

				if( $tam > 0 && (strcmp($op->dataDivulgacao, $temp[1]) == 0 ) ){
					$associativa = new OpPosGraduacao(); 
					$total = 0; 
					$total = $associativa->get('oportunidadeId', (int) $op->id);

					array_push($array, array('graduacao' => ($total > 0 ),'info_adicionais' => Convert::toUTF_8($op->infoAdicionais) ,'id' => $post->id, 'post' => false, 'data_envio' => $op->dataDivulgacao)); 
				}
			}

			$result = $daoFeed->feed($result[count($result)-1][1],1); 

			if(!$result)
				break; 

		}while( count($array) < $limit && count($result) >= 0 ); 

		$this->telaPrincipalView->sendAjax($array); 
	}
}