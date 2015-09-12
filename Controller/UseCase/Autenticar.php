<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'AutenticarView.php'); 

require_once(PATH.'Util'.DS.'KeyFactory.php'); 
require_once(PATH.'Util'.DS.'Mail.php'); 

class Autenticar extends GenericController {
	private $autenticarView; 

	public function __construct() {
		$this->autenticarView = new AutenticarView(); 
	}	

	/** @BlockList({'noblock'}) */
	public function loginView(){
		$this->autenticarView->loginView(); 
	}

	/** @BlockList({'noblock'}) */
	public function alterarSenhaView(){
		$this->autenticarView->alterarSenhaView(); 
	}

	/** @BlockList({'noblock'}) */
	public function login($arg){
		$isCoordenador = false; 
		$isProfessor   = false;
		$isEgresso     = false; 
		$isVisitante   = true; 

		Lumine::import("Usuario"); 
		$usuario = new Usuario(); 

		$usuario->where("cpf = '". $arg["cpf"]. "' and senha = '". $arg["senha"]."'")->find(); 
		$usuario->fetch(true); 

		$status = is_string($usuario->id); 

		if($status){
			$isVisitante   = false; 
			$_SESSION['user_id'] = (int) $usuario->id; 
			Lumine::import("Egresso");

			$egresso = new Egresso(); 
			$egresso->where("usuario_id = ". $usuario->id )->find(); 
			$egresso->fetch(true); 

			$isEgresso = ($egresso->usuarioId !=  null ); 

			if( !$isEgresso ){ 

			Lumine::import("Professor"); 
				$professor = new Professor(); 
				$professor->where("usuario_id = ". $usuario->id )->find(); 
				$professor->fetch(true); 

				$isCoordenador = $professor->isCoordenador; 
				if($professor->isCoordenador)
					$isCoordenador = true; 
				else
					$isProfessor = true; 
			}
		}
		
		$_SESSION['user'] = array('egresso' => $isEgresso, 'professor' => $isProfessor, 'coordenador' => $isCoordenador, 'visitante' => $isVisitante); 

		$this->autenticarView->sendAjax( array( "status" => $status)); 
	}

	/** @BlockList({'noblock'}) */
	public function alterarSenha($arg){
		$codigo = $arg['codigo']; 
		$senha  = $arg['senha']; 

		Lumine::import('Usuario');
		$usuario = new Usuario(); 

		$total = $usuario->get('codigo', $codigo); 
		
		if(strcmp($codigo,"") == 0)
			$this->autenticarView->sendAjax(array("status" => true, 'msg' => 'Esse código não exite.' ) ); 

		if($total > 0 ){
			$usuario->senha = $senha; 
			$usuario->codigo = ""; 
			$usuario->update(); 
		}else{
			$this->autenticarView->sendAjax(array("status" => true, 'msg' => 'Esse código não exite.' ) ); 
		}

		$this->autenticarView->sendAjax(array("status" => true, 'msg' => 'Senha alterada com sucesso.') ); 
	}

	/** @BlockList({'noblock'}) */
	public function gerarCodigo($arg){
		Lumine::import("Usuario"); 
		$usuario = new Usuario(); 
		$key     = new KeyFactory(); 
		$total = $usuario->get('email',$arg['email']); 

		$codigo = $key->randomKey(16); 

		if($total > 0){
			$usuario->codigo = $codigo; 
			$usuario->update(); 
		}

		//$mail = Mail(); 
		//Mandar email aqui embaixo: 
		$this->autenticarView->sendAjax(array("status" => true ) ); 
	}

	/** @BlockList({'noblock'}) */
	public function logout(){
		session_destroy();
		$this->autenticarView->loginView(); 
	}

}