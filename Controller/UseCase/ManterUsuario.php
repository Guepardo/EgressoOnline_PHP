<?php 
namespace Controller\UseCase; 

use Controller\GenericController; 
use View\CustomViews\ManterUsuarioView; 

use Util\BDConnectionFactory; 
use Util\KeyFactory; 
use Util\DataValidator; 
use Util\Mail; 

use DAO\CustomDAOs\DAOProfessor; 
use DAO\CustomDAOs\DAOEgresso; 
use DAO\CustomDAOs\DAOUsuario; 

use Model\Professor; 
use Model\Egresso; 
use Model\Usuario; 

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

	public function alterarDadosView(){
		$this->manterUsuarioView->alterarDadosView(); 
	}

	public function alterarSenhaView(){
		$this->manterUsuarioView->alterarSenhaView(); 
	}

	public function alterarDadosProfessorView(){
		$this->manterUsuarioView->alterarDadosProfessorView();
	}

	public function cadastroProfessor($arg){
		//1: Montar a requisição num objeto
		//2: Validar os dados; 
		//2: Enviar para o dão; 
		//3: dizer se tudo ocorreu tudo bem ou não.
		$mail = new Mail(); 
		$passwordToSend = KeyFactory::randomKey(16);

		//echo $passwordToSend; ENVIAR A SENHA POR E-MAIL AQUI.

		$professor = new Professor(0, $arg['nome'], $arg['e_mail'], md5($passwordToSend), $arg['genero'], $arg['cpf'],0); 
		//Validacao: 
		$this->dataValidator->set("Nome", $professor->getNome())->is_required()->min_length(5)->max_length(140); 
		$this->dataValidator->set("Email", $professor->getEmail())->is_required()->is_email()->min_length(10)->max_length(140);
		$this->dataValidator->set("Cpf", str_replace(array(".","-"),"",$professor->getCpf()))->is_required()->is_cpf(); 
		$this->dataValidator->set("Gênero", $professor->getGenero())->is_required();  

		$array = $this->dataValidator->get_errors();

		self::verifyErros($array); 

		$result = $this->daoProfessor->insert($professor);
		$mail->sendEmail("Seu login: ". $professor->getCpf()." <br /> Sua senha: ". $passwordToSend, $professor->getEmail(),"EgressoOnline UEG - Informe de cadastro", $professor->getNome()); 
		self::verifyErrosBd($array); 
	}

	public function cadastroEgresso($arg){
		$daoEgresso = new DAOEgresso(); 

		$passwordToSend = KeyFactory::randomKey(16);
		$egresso = new Egresso(0, $arg['nome'], $arg['e_mail'], md5($passwordToSend), $arg['genero'], $arg['cpf'], $arg['ano_conclusao'], $arg['ano_ingresso']);

		//Validacao: 
		$this->dataValidator->set("Nome", $egresso->getNome())->is_required()->min_length(5)->max_length(140);
		$this->dataValidator->set("Email", $egresso->getEmail())->is_required()->is_email()->min_length(10)->max_length(140); 
		$this->dataValidator->set("Cpf", str_replace(array(".","-"),"",$egresso->getCpf()))->is_required()->is_cpf(); 
		$this->dataValidator->set("Ano_Conclusão", $egresso->getAnoConclusao())->is_required()->max_value(3000)->min_value( ((int) $egresso->getAnoIngresso()) + 3);  
		$this->dataValidator->set("Ano_Ingresso", $egresso->getAnoIngresso())->is_required()->max_value(3000)->min_value(1900); 

		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 
		$result = $daoEgresso->insert($egresso); 
		self::verifyErrosBd($result); 
	}

	public function alterarSenha($arg){
		$daoUsuario = new DAOUsuario(); 

		$usuario = new Usuario(); 
		$usuario->setId($_SESSION['id_user']); 
		$usuario->setSenha($arg['senha']);

		//Validacao: 
		$this->dataValidator->set("Senha", $arg['novaSenha'])->is_required()->is_equals($arg['confirmacao']); 

		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 
		$result = $daoUsuario->alterarSenha($usuario, $arg['novaSenha']); 
		self::verifyErrosBd($result); 
	}

	public function alterarDadosProfessor($arg){
		$daoUsuario = new DAOUsuario(); 

		$usuario = new Usuario($_SESSION['id_user'], $arg['nome'], $arg['e_mail']); 

		//Validacao: 
		$this->dataValidator->set("Nome", $usuario->getNome())->is_required()->min_length(5)->max_length(140); 
		$this->dataValidator->set("Email", $usuario->getEmail())->is_required()->is_email()->min_length(10)->max_length(140);

		$array = $this->dataValidator->get_errors();
		self::verifyErros($array); 
		$result = $daoUsuario->update($usuario); 
		self::verifyErrosBd($result); 
	}

	private function verifyErros($array){
		if(!empty($array)){
			$array['status'] = false; 
			$this->manterUsuarioView->sendAjax($array); 
		}
	}

	private function verifyErrosBd($result){
		if(empty($result))
			$this->manterUsuarioView->sendAjax(array('status' => true)); 
		else
			$this->manterUsuarioView->sendAjax(array('status' => false, 'Error' => array ($result))); 
	}

}