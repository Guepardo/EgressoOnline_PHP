<?php  
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 

class DAOEgresso extends DAOBehavior{
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element ){
		var_dump($element); 
		$sql = "INSERT INTO USUARIO (nome, cpf, e_mail, senha, idgenero_fk) VALUES ( '".$element->getNome()."', '".$element->getCpf()."', '".$element->getEmail()."', '".$element->getSenha()."', ".$element->getGenero()." )"; 
		mysqli_query(parent::$connection,$sql);
		$id = mysqli_insert_id(parent::$connection); 
		echo $sql; 

		$sql = "INSERT INTO EGRESSO (idusuario_fk, ano_ingresso, ano_conclusao, is_dado_publico) VALUES (". $id .",". $element->getAnoIngresso().",".$element->getAnoConclusao().",". $element->isDadoPublico() .")"; 
		mysqli_query(parent::$connection,$sql);
		echo $sql; 
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