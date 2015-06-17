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

}