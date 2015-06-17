<?php  
namespace DAO\CustomDAOs; 

use DAO\CustomDAOs; 


class DAOProfessor extends DAOUsuario{
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element ){
		//Verificando se cpf e e-mail já foram cadastrados: 
		if(parent::emailExists($element->getEmail()))
			return "Esse email já foi cadastrado"; 
		if(parent::cpfExists($element->getCpf()))
			return "Esse CPF já foi cadastrado"; 

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
	}
	
	public function delete( $pk ){
		
	}
	
	public function select ( $pk ){
		
	}
	
	public function update ($element){
		
	}
}