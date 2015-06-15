<?php 
namespace Controller\UseCase; 

use Controller\GenericController; 
use View\CustomViews\ManterUsuarioView; 
use Util\BDConnectionFactory; 
use Util\KeyFactory; 
use DAO\CustomDAOs\DAOManterUsuario; 
use Model\Professor; 

class ManterUsuario extends GenericController{
	private $manterUsuarioView; 
	private $daoManterUsuario; 

	public function __construct(){
		$this->manterUsuarioView = new ManterUsuarioView(); 
		$this->daoManterUsuario = new DAOManterUsuario(); 
	}

	public function cadastroProfessorView(){
		$this->manterUsuarioView->cadastroProfessorView(); 
	}

	public function cadastroProfessor($arg){
		//1: Montar a requisição num objeto
		//2: Validar os dados; 
		//2: Enviar para o dão; 
		//3: dizer se tudo ocorreu tudo bem ou não.

		$professor = new Professor(0, $arg['nome'], $arg['e-mail'], KeyFactory::randomKey(16), $arg['genero'], $arg['cpf'],true); 

		$this->daoManterUsuario->insert($professor); 
	}

	public function alterarDados(){
		$this->manterUsuarioView->alterarDadosView(); 
	}
}