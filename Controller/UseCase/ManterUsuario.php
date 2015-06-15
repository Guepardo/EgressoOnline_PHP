<?php 
namespace Controller\UseCase; 

use Controller\GenericController; 
use View\CustomViews\ManterUsuarioView; 
use Util\BDConnectionFactory; 

class ManterUsuario extends GenericController{
	private $manterUsuarioView; 

	public function __construct(){
		$this->manterUsuarioView = new ManterUsuarioView(); 
	}

	public function cadastroProfessor(){
		$this->manterUsuarioView->cadastroProfessorView(); 
	}

	public function alterarDados(){
		$this->manterUsuarioView->alterarDadosView(); 
	}
}