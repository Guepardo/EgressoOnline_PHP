<?php
namespace Security; 

class SecurityFilter{

	public function __construct(){ 
	}

	public function isAuthenticated(){
		//Conteúdo de 'status_login': 
		// true == logado no sistema; 
		// false == não está logado, mas fnalizou uma sessão. 
		// isset == false, usuário não logado e nem finalizou sessão. 

		if( isset($_SESSION['status_login'] ) )
			return $_SESSION['status_login']; 
		else
			return false; 
	}

	public  function filteringRequest(){
		//To do: 
		// 1 Verificar se o usuário está logado no sistema; 
		// 2 Verificar se a ação solicitada está dentro das permitidas para usuários não logados; 
		// 3 Caso contrário ao item 2, o sistema deve redirecionar o usuário para a página de login; 

		//Just a test: 
		if( isset( $_SESSION['contador'])){
			$_SESSION['contador']++; 
		}else{
			$_SESSION['contador'] = 0; 
		}

		echo 'Quantidade de hits: '. $_SESSION['contador']; 
		//test done; 

		if( self::isAuthenticated() ) return; 

		$_REQUEST['usecase'] = 'humanos'; 
		$_REQUEST['action'] = 'login'; 
 
	}
}