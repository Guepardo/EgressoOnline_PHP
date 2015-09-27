<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'VisualizarOportunidadeView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

/**
 * Classe que implementa o caso de uso visualizar oportunidades.
 */
class VisualizarOportunidade extends GenericController {
	private $visuOportunidadeVew; 
	public function __construct() {
		$this->visuOportunidadeView = new VisualizarOportunidadeView(); 
	}	

	/**
	 * Fachada para o método oportunidadesView da classe VisualizarOportunidadeView. 
	 *
	 * @param      <void> 
	 * @return     <void> 
	 */
	/** @BlockList({'visitante'}) */
	public function oportunidadesView(){
		$this->visuOportunidadeView->oportunidadesView(); 
	}
	
	/**
	 * Returna um JSON bem formado com os dados de uma oportunidade de emprego. 
	 *
	 * @param      <array>  $arg    Recebe um array com a chave id (int). O id deve ser da oportunidade de emprego que foi cadastrada. 
	 * @return     <JSON>   {'telefone' : string, 'email' : string, 'site' : string, 'info_adicionais' : string, 'pais' : string, 'cidade' : string, 'compelento' : string, 'empresa' : string, 'salario' : real, 'titulo_academico' : string, 'atuacao_profissional' : string, 'data_divulgacao' : datetime }
	 */
	/** @BlockList({'visitante'}) */
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


	/**
	 * Returna um JSON bem formado com os dados de uma oportunidade de pós-graduação. 
	 *
	 * @param      <array>  $arg    Recebe um array com a chave id (int). O id deve ser da oportunidade de pós-graduação que foi cadastrada. 
	 * @return     <JSON>   {'telefone' : string, 'email' : string, 'site' : string, 'info_adicionais' : string, 'pais' : string, 'estado' : string,'cidade' : string, 'complemento' : string, 'titulo' : string, 'area' : string, 'data_inscri_inicio' : int, 'data_inscr_fim' : int, 'titulo_academico' : string, 'data_divulgacao' : datetime }
	 */
	/** @BlockList({'visitante'}) */
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