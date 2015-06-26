<?php 
namespace Model; 

class FaixaSalarial{
	private $id, $descricao; 

	public function __construct($id, $descricao){
		$this->id = $id; 
		$this->descricao = $descricao; 
	}

	public function getId (){
		return $this->id; 
	}

	public function getDescricao (){
		return $this->descricao; 
	}
}