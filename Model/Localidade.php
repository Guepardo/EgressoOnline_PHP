<?php 
namespace Model; 

class Localidade{
	private $id; 
	private $complemento; 
	private $cidade; 
	private $pais; 

	public function __construct($id='', $complemento='', $cidade='', $pais=''){
		$this->id = $id; 
		$this->complemento = $complemento; 
		$this->cidade = $cidade; 
		$this->pais = $pais; 
	}

	public function getId(){
		return $this->id;
	}

	public function getComplemento(){
		return $this->complemento;
	}

	public function getCidade(){
		return $this->cidade;
	}

	public function getPais(){
		return $this->pais;
	}
}