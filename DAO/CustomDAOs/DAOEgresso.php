<?php  
namespace DAO\CustomDAOs; 

use DAO\CustomDAOs\DAOUsuario; 

class DAOEgresso extends DAOUsuario {
	
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element ){
		//Verificando se cpf e e-mail já foram cadastrados: 
		if(parent::emailExists($element->getEmail()))
			return "Esse email já foi cadastrado"; 
		if(parent::cpfExists($element->getCpf()))
			return "Esse CPF já foi cadastrado"; 

		//Ordem nas inserções: 
		//Criar usuario, egresso, localidade e emprego 

		//Inserindo usuario
		$sql = "INSERT INTO USUARIO (nome, cpf, e_mail, senha, idgenero_fk) VALUES ( '".$element->getNome()."', '".$element->getCpf()."', '".$element->getEmail()."', '".$element->getSenha()."', ".$element->getGenero()." )"; 
		try{
			mysqli_query(parent::$connection,$sql);
			$idusuario = mysqli_insert_id(parent::$connection); 
		}catch( \Exception $e){}

		//Inserindo localidade para o egresso (VAZIA)
		$sql = "INSERT INTO LOCALIDADE (complemento) VALUES ('')"; 
		try{
			mysqli_query(parent::$connection,$sql);
			$idlocalidadeEgresso = mysqli_insert_id(parent::$connection); 
		}catch( \Exception $e){}

		//Inserindo localidade para o emprego (VAZIA)
		$sql = "INSERT INTO LOCALIDADE (complemento) VALUES ('')"; 
		try{
			mysqli_query(parent::$connection,$sql);
			$idlocalidadeEmprego = mysqli_insert_id(parent::$connection); 
		}catch( \Exception $e){}

		//Inserindo emprego (VAZIA)
		$sql = "INSERT INTO LOCALIDADE (complemento) VALUES ('')"; 
		try{
			mysqli_query(parent::$connection,$sql);
			$idemprego = mysqli_insert_id(parent::$connection); 
		}catch( \Exception $e){}



		//Inserindo Egresso
		$sql = "INSERT INTO EGRESSO (idusuario_fk, ano_ingresso, ano_conclusao, is_dado_publico, idlocalidade_fk, idemprego_fk) VALUES (". $idusuario .",". $element->getAnoIngresso().",".$element->getAnoConclusao().",". $element->isDadoPublico() .")"; 
		try{
			mysqli_query(parent::$connection,$sql);
		}catch( \Exception $e){}

		return mysqli_error(parent::$connection); 
	}
	
	public function delete( $pk ){
		
	}
	
	public function select ( $pk ){
		/*
		while($consulta = mysqli_fetch_array($result)) { 
		   print "Coluna1: $consulta[1] - Coluna2: $consulta[2]<br>"; 
		} 
		*/
	}
	
	public function update ($element){
		
	}
}