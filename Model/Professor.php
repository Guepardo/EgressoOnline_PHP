<?php
namespace Model; 

use Model\Usuario; 

class Professor extends Usuario{
	private $coordenador; 
	private $disciplinas; 
	
	public function __construct($id, $nome, $email, $senha, $sexo, $cpf, $coordenador){
		parent::__construct($id, $nome, $email, $senha, $sexo, $cpf); 
		$this->coordenador = $coordenador; 
	}

	public function is_coordenador(){
		return $this->coordenador; 
	}

	public function getDisciplinas(){
		return $this->disciplinas; 
	}
}