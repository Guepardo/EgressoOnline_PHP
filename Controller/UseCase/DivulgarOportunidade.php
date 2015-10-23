<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'Util'.DS.'Mail.php');
require_once(PATH.'Util'.DS.'FileWriter.php'); 
/**
 * Classe que implementa o caso de uso 'Divulgar Oportunidades de emprego'
 */
class DivulgarOportunidade extends GenericController {
	private $dataValidator; 

	public function __construct() {
		$this->dataValidator  = new DataValidator(); 
	}	

	/**
	 *  Cadastrar uma oportunidade de emprego
	 *
	 * @param      <array>  $arg    Recebe um array contendo os dados para cadastro de uma oportunidade de emprego. As chaves que devem ser alimentadas nesse array são: cidade_id (int), complemento (string), pais_id (id), telefone (string), email (string), site (string), info_adicionais (string), empresa (string), salario (real), graduacao_id (int) e area_profissional_id (int). 
	 * @return     <JSON> formato da saída {status : boolean, msg : string } 
	 */
	/** @BlockList({'visitante'}) */
	public function emprego($arg){
		//Criar a validaçao dos campos posteriormente; 
		Lumine::import("Oportunidade"); 
		Lumine::import("OpEmprego"); 
		Lumine::import("Localidade"); 
		Lumine::import("Cidade"); 
		
		$this->dataValidator->set("Empresa",$arg['empresa'])->max_length(150); 
		$this->dataValidator->set("Salário",$arg['salario'])->is_integer(); 
		$this->dataValidator->set("Telefone",$arg['telefone'])->max_length(15); 
		$this->dataValidator->set("E-mail",$arg['email'])->max_length(150)->is_email(); 
		$this->dataValidator->set("Site",$arg['site'])->max_length(500); 
		$this->dataValidator->set("Complemento",$arg['complemento'])->max_length(500);
		$this->dataValidator->set("Informações Adicionais",$arg['info_adicionais'])->max_length(5000); 

		$array = $this->dataValidator->get_errors();
		parent::verifyErros($array);

		$localidade = new Localidade(); 
		$cidade = new Cidade(); 

		$cidade->get('des', $arg['cidade_id']); 

		$localidade->complemento = $arg['complemento']; 
		$localidade->paisId      = $arg['pais_id']; 
		$localidade->cidadeId    = $cidade->id; 
		$localidade->insert(); 

		$oportunidade = new Oportunidade(); 

		$oportunidade->usuarioId = $_SESSION['user_id'];  
		$oportunidade->localidadeId = $localidade->id; 
		$oportunidade->telefone = $arg['telefone']; 
		$oportunidade->email = $arg['email']; 
		$oportunidade->site = $arg['site']; 
		$oportunidade->infoAdicionais = $arg['info_adicionais'];
		$oportunidade->dataDivulgacao = date("Y-m-d H:i:s");
		$oportunidade->insert(); 

		$opEmprego = new OpEmprego(); 

		$opEmprego->empresa = $arg['empresa']; 
		$opEmprego->salario = $arg['salario']; 
		$opEmprego->tituloAcademicoId = $arg['graduacao_id']; 
		$opEmprego->atuacaoProfissionalId = $arg['area_profissional_id']; 
		$opEmprego->oportunidadeId = $oportunidade->id; 
		$opEmprego->insert(); 

		echo(json_encode(array('status' => true ) )); 

		self::notificacaoEmprego($oportunidade->id);
	}

	/**
	 * Cadastrar uma oportunidade de pós-graduação
	 *
	 * @param      <array>  $arg    Recebe um array conteido os dados para cadastro de uma oportunidade de pós-graduação. As cheves que deve ser aliementadas nesse array são: cidade_id (int), complemento (string), telefone (string), email (string), site (string), titulo  (string), data_inscr_inicio (date), data_inscr_fim (date), titulo_academico_id (int) e area (string). 
	 * @return     <JSON> formato da saída {status : boolean, msg : string } 
	 */
	/** @BlockList({'visitante'}) */
	public function posGraduacao($arg){
		//Criar a validaçao dos campos posteriormente; 
		Lumine::import("Oportunidade"); 
		Lumine::import("OpPosGraduacao"); 
		Lumine::import("Localidade"); 
		Lumine::import("Cidade"); 

		// 'titulo' => string 'asdfasdf' (length=8)
	 //  'titulo_academico_id' => string '2' (length=1)
	 //  'area' => string 'asdfasdf' (length=8)
	 //  'telefone' => string '(23) 4444-4444' (length=14)
	 //  'email' => string 'bsinet@hotmail.com' (length=18)
	 //  'site' => string 'asdfasdfasdf.asdfasdf asdfasdf' (length=30)
	 //  'pais_id' => string '33' (length=2)
	 //  'cidade_id' => string 'JORDÃO' (length=7)
	 //  'complemento' => string '' (length=0)
	 //  'data_inscr_inicio' => string '2015-10-22' (length=10)
	 //  'data_inscr_fim' => string '2015-10-08' (length=10)
	 //  'info_adicionais' => string 'asdfasdf' (length=8)
		//  
		$this->dataValidator->set("Título",$arg['titulo'])->max_length(140); 
		$this->dataValidator->set("Área",$arg['area'])->max_length(150);
		$this->dataValidator->set("Telefone",$arg['telefone'])->max_length(15); 
		$this->dataValidator->set("E-mail",$arg['email'])->max_length(150)->is_email(); 
		$this->dataValidator->set("Site",$arg['site'])->max_length(500); 
		$this->dataValidator->set("Complemento",$arg['complemento'])->max_length(500); 
		$this->dataValidator->set("Informações Adicionais",$arg['info_adicionais'])->max_length(5000); 

		$array = $this->dataValidator->get_errors();
		parent::verifyErros($array);

		$localidade = new Localidade(); 
		$cidade = new Cidade(); 

		$cidade->get('des', $arg['cidade_id']); 

		$localidade->complemento = $arg['complemento']; 
		$localidade->paisId      = $arg['pais_id']; 
		$localidade->cidadeId    = $cidade->id; 
		$localidade->insert(); 

		$oportunidade = new Oportunidade(); 

		$oportunidade->usuarioId = $_SESSION['user_id'];  
		$oportunidade->localidadeId = $localidade->id; 
		$oportunidade->telefone = $arg['telefone']; 
		$oportunidade->email    = $arg['email']; 
		$oportunidade->site = $arg['site']; 
		$oportunidade->infoAdicionais = $arg['info_adicionais'];
		$oportunidade->dataDivulgacao = date("Y-m-d H:i:s");
		$oportunidade->insert(); 

		$pos = new OpPosGraduacao(); 

		$pos->titulo = $arg['titulo']; 
		$pos->dataInscrInicio = $arg['data_inscr_inicio']; 
		$pos->dataInscrFim = $arg['data_inscr_fim']; 
		$pos->tituloAcademicoId = $arg['titulo_academico_id']; 
		$pos->oportunidadeId = $oportunidade->id;  
		$pos->area = $arg['area']; 
		$pos->insert(); 

		echo(json_encode(array('status' => true ) )); 
		
		self::notificacaoPos($oportunidade->id); 
	}

	/**
	 * Adiciona a oportunidade de pós-graduação recém cadastrada na lista de envio de notificações via e-mail. 
	 *
	 * @param      <int>  $id     Id da pós-graduação recém cadastrada no banco de dados. 
	 * @return     <void>
	 */
	/** @BlockList({'visitante'}) */
	public function notificacaoPos($id){

		Lumine::import("Oportunidade"); 
		Lumine::import("OpPosGraduacao");

		Lumine::import("Usuario"); 
		Lumine::import("Notificacao");
		Lumine::import("EmailEnviar"); 

		$op = new Oportunidade(); 
		$opPos = new OpPosGraduacao(); 

		$op->join($opPos)->where("id = $id")->find(); 
		$op->fetch(true); 

		$usuario     = new Usuario(); 
		$notificacao = new Notificacao(); 

		$usuario->join($notificacao)->find(); 

  		//Guardando os emails com o interesse relacionado. 
		$idList = array(); 

		$mail = new Mail(); 

		while($usuario->fetch()){
			if($usuario->tituloAcademicoId == $op->tituloAcademicoId)
				array_push($idList,$usuario->usuarioId);  
		}

		foreach($idList as $a){
 			//$mail->sendEmail("Uma vaga de pós-graduação do seu interesse foi divulgada.", $a['email'],"EgressoOnline UEG - Vaga de pós-graduação", $a['nome']); 
 			$email = new EmailEnviar(); 
 			$email->usuarioId   = $a; 
 			$email->tipoEmailId =  2; //Oportunidade;
 			$email->insert();  
		}
	}

	/**
	 * Adiciona o oprotunidade de emprego recém cadastra na lista de envio de notificações via e-mail. 
	 *
	 * @param      <int>  $id     Id da pós-graduação recém cadastrada no banco de dados. 
	 * @return     <void>
	 */ 
	/** @BlockList({'visitante'}) */
	public function notificacaoEmprego($id){

		Lumine::import("Oportunidade"); 
		Lumine::import("OpEmprego");
		Lumine::import("EmailEnviar");
		
		Lumine::import("Usuario"); 
		Lumine::import("Notificacao"); 
		Lumine::import("NotificacaoHasAtuacaoProfissional"); 

		$op 	   = new Oportunidade(); 
		$opEmprego = new OpEmprego(); 

		$op->join($opEmprego)->where("id = $id")->find(); 
		$op->fetch(true); 


		if($op->atuacaoProfissionalId == null )
 			die("não é um emprego"); //Não é um emprego; 

 		$usuario     = new Usuario(); 
 		$notificacao = new Notificacao(); 

 		$usuario->find(); 

  		//Guardando os emails com o interesse relacionado. 
 		$idList = array(); 
 		$mail 	   = new Mail(); 

 		while($usuario->fetch()){
 			$notificacao = new Notificacao(); 
 			$total = $notificacao->get($usuario->id); 

 			if($total < 0)
 				continue; 

 			$idNotificacao = $notificacao->id; 

 			$associativa = new NotificacaoHasAtuacaoProfissional(); 
 			$total = $associativa->get($idNotificacao); 

 			if($total < 0 )
 				continue; 

 			do{
 				if($associativa->atuacaoProfissionalId == $op->atuacaoProfissionalId)
 					array_push($idList, $usuario->id);  

 			}while($associativa->fetch()); 
 		}

 		foreach($idList as $a){
 			//$mail->sendEmail("Uma vaga de emprego do seu interesse foi divulgada.", $a['email'],"EgressoOnline UEG - Vaga de pós-graduação", $a['nome']); 
 			$email = new EmailEnviar(); 
 			$email->usuarioId   = $a; 
 			$email->tipoEmailId =  2; //Oportunidade;
 			$email->insert();  
 		}
 	}

 }