<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 

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

}