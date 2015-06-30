<?php 
namespace Model; 

class Regiao{
	private $id, $desc; 

	public function __construct( $id, $desc){
		$this->id = $id; 
		$this->desc = $desc; 
	}

	public function getId(){
		return $this->id; 
	}

	public function getDescricao(){
		return $this->desc; 
	}
}