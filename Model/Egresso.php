<?php 
namespace Model; 

use Model\Usuario;

class Egresso extends Usuario{
	private $telefone; 
	private $anoConclusao; 
	private $anoIngresso; 
	private $endereco; 
	private $dadoPublico; 
	private $localidade; 
	private $qtdFilhos; 
	private $emprego; 

	//Construtor que será usado para alteração de dados; 
	public function __construct($id, $nome, $email, $senha, $genero, $cpf, $anoConclusao=0, $anoIngresso=0, $telefone="", $endereco="", $dadoPublico=0){
		parent::__construct($id, $nome, $email, $senha, $genero, $cpf); 
		$this->telefone = $telefone;
		$this->anoIngresso = $anoIngresso; 
		$this->anoConclusao= $anoConclusao; 
		$this->endereco = $endereco; 
		$this->dadoPublico = $dadoPublico; 
	}

	public function setLocalidade($localidade){
		$this->localidade = $localidade; 
	}

	public function setQtdFilhos($qtdFilhos){
		$this->$qtdFilhos = $qtdFilhos; 
	}

	public function getQtdFilhos(){
		return $this->qtdFilhos; 
	}

	public function setEmprego($emprego){
		$this->emprego = $emprego; 
	}

	public function setTelefone ($telefone){
		$this->telefone = $telefone; 
	}

	public function getTelefone(){
		return $this->telefone; 
	}
	
	public function setAnoIngresso ($anoIngresso){
		$this->anoIngresso = $anoIngresso; 
	}

	public function setAnoConclusao($anoConclusao){
		$this->anoConclusao = $anoConclusao; 
	}

	public function setEndereco($endereco){
		$this->endereco = $endereco;
	}

	public function setDadoPublico($dadoPublico){
		$this->dadoPublico = $dadoPublico; 
	}

	public function getEmprego(){
		return $this->emprego; 
	}

	public function getLocalidade(){
		return $this->localidade; 
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