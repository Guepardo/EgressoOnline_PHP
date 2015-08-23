<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class VisualizarOportunidade extends GenericController {

	public function __construct() {
		
	}	

	public function emprego($arg){
		//Criar a validaçao dos campos posteriormente; 
		$id = (int) $arg['id'];

		Lumine::import("Oportunidade"); 
		Lumine::import("OpEmprego"); 
		Lumine::import("Localidade"); 
		Lumine::import("Cidade"); 
		Lumine::import("Estado"); 
		Lumine::import("Pais"); 
		Lumine::import("TituloAcademico"); 
		Lumine::import("AtuacaoProfissional"); 

		$oportunidade = new Oportunidade(); 
		$opEmprego    = new OpEmprego(); 

		$oportunidade->join($opEmprego)->where("id = $id")->find(); 
		$oportunidade->fetch(true); 

		$localidade = new Localidade(); 
		$localidade->get($oportunidade->localidadeId); 

		$cidade = new Cidade(); 
		$cidade->get($localidade->cidadeId); 

		$pais = new Pais();
		$pais->get($localidade->paisId); 

		$estado = new Estado(); 
		if($localidade->cidadeId != null ){
			$estado->get($cidade->estadoId); 
		}

		$titulo = new TituloAcademico(); 
		$titulo->get($oportunidade->tituloAcademicoId); 

		$atuacao = new AtuacaoProfissional(); 
		$atuacao->get($oportunidade->atuacaoProfissionalId); 

		$array = array( 'telefone' =>  $oportunidade->telefone, 'email' => Convert::toUTF_8($oportunidade->email), 'site' => Convert::toUTF_8($oportunidade->site), 'info_adicionais' => Convert::toUTF_8($oportunidade->infoAdicionais), 'pais' => Convert::toUTF_8($pais->des) , 'estado' => Convert::toUTF_8($estado->des) , 'cidade' => Convert::toUTF_8($cidade->des) , 'complemento' => Convert::toUTF_8($localidade->complemento) , 'empresa' => Convert::toUTF_8($oportunidade->empresa) , 'salario' => (int) $oportunidade->salario , 'titulo_academico' => Convert::toUTF_8($titulo->des) , 'atuacao_profissional' => Convert::toUTF_8($atuacao->des), 'data_divulgacao' => $oportunidade->dataDivulgacao ); 

		die(json_encode($array)); 
	}

	public function posGraduacao($arg){
		//Criar a validaçao dos campos posteriormente; 
		$id = (int) $arg['id'];

		Lumine::import("Oportunidade"); 
		Lumine::import("OpPosGraduacao"); 
		Lumine::import("Localidade"); 
		Lumine::import("Cidade"); 
		Lumine::import("Estado"); 
		Lumine::import("Pais"); 
		Lumine::import("TituloAcademico"); 

		$oportunidade = new Oportunidade(); 
		$opPos = new OpPosGraduacao(); 

		$oportunidade->join($opPos,'LEFT')->where("id = $id")->find(); 
		$oportunidade->fetch(true); 

		$localidade = new Localidade(); 
		$localidade->get($oportunidade->localidadeId); 

		$cidade = new Cidade(); 
		$cidade->get($localidade->cidadeId); 

		$pais = new Pais();
		$pais->get($localidade->paisId); 

		$estado = new Estado(); 
		if($localidade->cidadeId != null ){
			$estado->get($cidade->estadoId); 
		}

		$opPos->get('oportunidadeId', $id); 
		$titulo = new TituloAcademico(); 
		$titulo->get($opPos->tituloAcademicoId); 

		$array = array( 'telefone' =>  $oportunidade->telefone, 'email' => Convert::toUTF_8($oportunidade->email), 'site' => Convert::toUTF_8($oportunidade->site), 'info_adicionais' => Convert::toUTF_8($oportunidade->infoAdicionais), 'pais' => Convert::toUTF_8($pais->des) , 'estado' => Convert::toUTF_8($estado->des) , 'cidade' => Convert::toUTF_8($cidade->des) , 'complemento' => Convert::toUTF_8($localidade->complemento) , 'titulo' => Convert::toUTF_8($opPos->titulo) , 'area' => Convert::toUTF_8($opPos->area), 'data_inscr_inicio' => Convert::toUTF_8($opPos->dataInscrInicio), 'data_inscr_fim' => Convert::toUTF_8($opPos->dataInscrFim) , 'titulo_academico' => Convert::toUTF_8($titulo->des), 'data_divulgacao' => $oportunidade->dataDivulgacao ); 

		die(json_encode($array)); 

	}

}