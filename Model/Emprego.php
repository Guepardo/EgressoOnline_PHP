<?php 
namespace Model; 

class Emprego{
	private $id; 
	private $nomeEmpresa; 
	private $faixaSalarial; 
	private $atuacaoProfissional; 
	private $localidade; 

	public function __construct($id='', $nomeEmpresa='', $faixaSalarial='', $atuacaoProfissional='',$localidade=''){
		$this->id = $id; 
		$this->nomeEmpresa = $nomeEmpresa; 
		$this->faixaSalarial = $faixaSalarial; 
		$this->atuacaoProfissional = $atuacaoProfissional; 
		$this->localidade = $localidade; 
	}

	public function getId (){
		return $this->id; 
	}

	public function getNomeEmpresa(){
		return $this->nomeEmpresa; 
	}

	public function getFaixaSalarial(){
		return $this->faixaSalarial; 
	}

	public function getAtuacaoProfissional(){
		return $this->atuacaoProfissional; 
	}

	public function getLocalidade(){
		return $this->localidade; 
	}

	public function setLocalidade($localidade){
		$this->localidade = $localidade; 
	}

	public function setFaixaSalarial($faixaSalarial){
		$this->faixaSalarial = $faixaSalarial; 
	}

	public function setAtuacaoProfissional($atuacaoProfissional){
		$this->atuacaoProfissional = $atuacaoProfissional; 
	}

	
}