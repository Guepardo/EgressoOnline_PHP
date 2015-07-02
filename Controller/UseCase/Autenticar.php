<?php
namespace Controller\UseCase; 

use Controller\GenericController; 
use View\CustomViews\AutenticarView; 
use DAO\CustomDAOs\DAOUsuario; 
use DAO\CustomDAOs\DAOEgresso; 
use DAO\CustomDAOs\DAOProfessor; 

class Autenticar extends GenericController {
	private $autenticarView; 

	public function __construct() {
		$this->autenticarView = new AutenticarView(); 
	}	

	public function loginView(){
		$this->autenticarView->loginView(); 
	}

	public function login($arg){
		$daoUsuario   = new DAOUsuario(); 
		$daoEgresso   = new DAOEgresso(); 
		$daoProfessor = new DAOProfessor(); 

		$usuario =  $daoUsuario->selectByCpfPassword($arg['cpf'], $arg['password']); 
		$status = !is_string($usuario); 

		if($status){
			$_SESSION['id_user'] = (int) $usuario->getId(); 
			$_SESSION['egresso'] = ($daoEgresso->isEgresso($_SESSION['id_user'])) ? true : false ; 
		}

		$this->autenticarView->sendAjax( array( "status" => $status ) ); 
	}

}