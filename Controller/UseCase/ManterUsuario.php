<?php 
namespace Controller\UseCase; 

use Controller\GenericController; 
use View\CustomViews\ManterUsuarioView; 
use Util\BDConnectionFactory; 
use Util\KeyFactory; 
use DAO\CustomDAOs\DAOProfessor; 
use DAO\CustomDAOs\DAOEgresso; 
use Model\Professor; 
use Model\Egresso; 

class ManterUsuario extends GenericController{
	private $manterUsuarioView; 
	private $daoProfessor; 

	public function __construct(){
		$this->manterUsuarioView = new ManterUsuarioView(); 
		$this->daoProfessor = new DAOProfessor(); 
	}

	public function cadastroProfessorView(){
		$this->manterUsuarioView->cadastroProfessorView(); 
	}

	public function cadastroEgressoView(){
		$this->manterUsuarioView->cadastroEgressoView(); 
	}

	public function cadastroProfessor($arg){
		//1: Montar a requisição num objeto
		//2: Validar os dados; 
		//2: Enviar para o dão; 
		//3: dizer se tudo ocorreu tudo bem ou não.

		$professor = new Professor(0, $arg['nome'], $arg['e-mail'], KeyFactory::randomKey(16), $arg['genero'], $arg['cpf'],0); 

		$this->daoProfessor->insert($professor); 
	}

	public function cadastroEgresso($arg){
		$daoEgresso = new DAOEgresso(); 

		$egresso = new Egresso(0, $arg['nome'], $arg['e-mail'], KeyFactory::randomKey(16), $arg['genero'], $arg['cpf'], $arg['ano_conclusao'], $arg['ano_ingresso']); 
		
		$daoEgresso->insert($egresso); 
	}

	public function alterarDados(){
		$this->manterUsuarioView->alterarDadosView(); 
	}
}