<?php  
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 

class DAOManterUsuario extends DAOBehavior{
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element ){
		var_dump($element); 
		$sql = "INSERT INTO USUARIO (nome, cpf, e-mail, senha, idgenero_fk) VALUES ( '".$element->getNome()."', '".$element->getCpf()."', '".$element->getEmail()."', '".$element->getSenha()."', ".$element->getGenero()." )"; 
		die($sql); 

		$result = mysqli_query(parent::$connection,'select * from cidade');
		while($consulta = mysqli_fetch_array($result)) { 
		   print "Coluna1: $consulta[1] - Coluna2: $consulta[2]<br>"; 
		} 
	}
	
	public function delete( $pk ){
		
	}
	
	public function select ( $pk ){
		
	}
	
	public function update ($element){
		
	}
}