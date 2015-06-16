<?php  
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 

class DAOProfessor extends DAOBehavior{
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element ){
		$sql = "INSERT INTO USUARIO (nome, cpf, e_mail, senha, idgenero_fk) VALUES ( '".$element->getNome()."', '".$element->getCpf()."', '".$element->getEmail()."', '".$element->getSenha()."', ".$element->getGenero()." )"; 
		try{
			mysqli_query(parent::$connection,$sql);
			$id = mysqli_insert_id(parent::$connection); 
		}catch( \Exception $e){}

		$sql = "INSERT INTO PROFESSOR (idusuario_fk, is_coordenador) VALUES (". $id .",". $element->isCoordenador().")"; 
		try{
		mysqli_query(parent::$connection,$sql);
		}catch( \Exception $e){}

		return mysqli_error(parent::$connection); 
		/*
		while($consulta = mysqli_fetch_array($result)) { 
		   print "Coluna1: $consulta[1] - Coluna2: $consulta[2]<br>"; 
		} 
		*/
	}
	
	public function delete( $pk ){
		
	}
	
	public function select ( $pk ){
		
	}
	
	public function update ($element){
		
	}
}