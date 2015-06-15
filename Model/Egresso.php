<?php 
namespace Model; 

use Model\Usuario;

class Egresso extends Usuario{
	private $telefone; 
	private $anoConclusao; 
	private $anoIngresso; 
	private $endereco; 
	private $dadoPublico; 

	//Construtor que será usado para alteração de dados; 
	public function __construct($id, $nome, $email, $senha, $genero, $cpf, $anoConclusao, $anoIngresso, $telefone="", $endereco="", $dadoPublico=0){
		parent::__construct($id, $nome, $email, $senha, $genero, $cpf); 
		$this->telefone = $telefone;
		$this->anoIngresso = $anoIngresso; 
		$this->anoConclusao= $anoConclusao; 
		$this->endereco = $endereco; 
		$this->dadoPublico = $dadoPublico; 
	}


	public function getAnoConclusao(){
		return $this->anoConclusao; 
	}

	public function getAnoIngresso(){
		return $this->anoIngresso; 
	}

	public function isDadoPublico(){
		return $this->dadoPublico; 
	}
}