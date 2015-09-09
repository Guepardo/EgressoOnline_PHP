<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'Util'.DS.'Mail.php'); 

class DivulgarOportunidade extends GenericController {

	public function __construct() {
		
	}	

	public function emprego($arg){
		//Criar a validaçao dos campos posteriormente; 
		
		Lumine::import("Oportunidade"); 
		Lumine::import("OpEmprego"); 
		Lumine::import("Localidade"); 
		Lumine::import("Cidade"); 


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

		die(json_encode(array('status' => true ) )); 
	}

	public function posGraduacao($arg){
		//Criar a validaçao dos campos posteriormente; 

		Lumine::import("Oportunidade"); 
		Lumine::import("OpPosGraduacao"); 
		Lumine::import("Localidade"); 
		Lumine::import("Cidade"); 


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

		die(json_encode(array('status' => true ) )); 
	}

	//$id do registo da notificação recem cadastrada: 
	public function notificacaoPos($id){
		$id = (int) $id['id']; 

 		Lumine::import("Oportunidade"); 
 		Lumine::import("OpPosGraduacao");

 		Lumine::import("Usuario"); 
 		Lumine::import("notificacao"); 

 		$op = new Oportunidade(); 
 		$opPos = new OpPosGraduacao(); 

 		$op->join($opPos)->where("id = $id")->find(); 
 		$op->fetch(true); 

 		$usuario     = new Usuario(); 
 		$notificacao = new Notificacao(); 

 		$usuario->join($notificacao)->find(); 
  		
  		//Guardando os emails com o interesse relacionado. 
  		$emailList = array(); 

  		$mail = new Mail(); 

 		while($usuario->fetch()){
 			if($usuario->tituloAcademicoId == $op->tituloAcademicoId)
 				array_push($emailList, array('nome' => $usuario->nome, 'email' => $usuario->email));  
 		}

 		foreach($emailList as $a){
 			$mail->sendEmail("Uma vaga de pós-graduação do seu interesse foi divulgada.", $a['email'],"EgressoOnline UEG - Vaga de pós-graduação", $a['nome']); 
 		}
	}

}