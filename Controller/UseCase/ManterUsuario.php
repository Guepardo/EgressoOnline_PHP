<?php 
namespace Controller\UseCase; 

use Controller\GenericController; 
use View\CustomViews\ManterUsuarioView; 

use Util\BDConnectionFactory; 
use Util\KeyFactory; 
use Util\DataValidator; 

use DAO\CustomDAOs\DAOProfessor; 
use DAO\CustomDAOs\DAOEgresso; 

use Model\Professor; 
use Model\Egresso; 

class ManterUsuario extends GenericController{
	private $manterUsuarioView; 
	private $dataValidator; 
	private $daoProfessor; 

	public function __construct(){
		$this->manterUsuarioView = new ManterUsuarioView(); 
		$this->daoProfessor = new DAOProfessor(); 
		$this->dataValidator = new DataValidator(); 
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
		$professor = new Professor(0, $arg['nome'], $arg['e_mail'], KeyFactory::randomKey(16), $arg['genero'], $arg['cpf'],0); 
		//Validacao: 

		$this->dataValidator->set("Nome", $professor->getNome())->is_required()->min_length(5)->max_length(140); 
		$this->dataValidator->set("Email", $professor->getEmail())->is_required()->is_email()->min_length(10)->max_length(140);
		$this->dataValidator->set("Cpf", str_replace(array(".","-"),"",$professor->getCpf()))->is_required()->is_cpf(); 
		$this->dataValidator->set("Gênero", $professor->getGenero())->is_required();  

		$array = $this->dataValidator->get_errors();

		if(!empty($array)){
			$array['status'] = false; 
			$this->manterUsuarioView->sendAjax($array); 
		}

		$result = $this->daoProfessor->insert($professor);

		if(empty($result))
			$this->manterUsuarioView->sendAjax(array('status' => true)); 
		else
			$this->manterUsuarioView->sendAjax(array('status' => false, 'Error' => array ($result))); 
	}

	public function cadastroEgresso($arg){
		$daoEgresso = new DAOEgresso(); 

		$egresso = new Egresso(0, $arg['nome'], $arg['e_mail'], KeyFactory::randomKey(16), $arg['genero'], $arg['cpf'], $arg['ano_conclusao'], $arg['ano_ingresso']);

		//Validacao: 
		$this->dataValidator->set("Nome", $egresso->getNome())->is_required()->min_length(5)->max_length(140);
		$this->dataValidator->set("Email", $egresso->getEmail())->is_required()->is_email()->min_length(10)->max_length(140); 
		$this->dataValidator->set("Cpf", str_replace(array(".","-"),"",$egresso->getCpf()))->is_required()->is_cpf(); 
		$this->dataValidator->set("Ano_Conclusão", $egresso->getAnoConclusao())->is_required()->max_value(3000)->min_value( ((int) $egresso->getAnoIngresso()) + 3);  
		$this->dataValidator->set("Ano_Ingresso", $egresso->getAnoIngresso())->is_required()->max_value(3000)->min_value(1900); 

		$array = $this->dataValidator->get_errors();

		if(!empty($array)){
			$array['status'] = false; 
			$this->manterUsuarioView->sendAjax($array); 
		}

		$result = $daoEgresso->insert($egresso); 

		if(empty($result))
			$this->manterUsuarioView->sendAjax(array('status' => true)); 
		else
			$this->manterUsuarioView->sendAjax(array('status' => false, 'Error' => array ($result))); 

		
	}

	public function alterarDados(){
		$this->manterUsuarioView->alterarDadosView(); 
	}
}