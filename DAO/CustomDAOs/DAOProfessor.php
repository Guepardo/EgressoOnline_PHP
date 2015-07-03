<?php  
namespace DAO\CustomDAOs; 

use DAO\CustomDAOs; 
use DAO\CustomDAOs\DAOUsuario; 

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
	
		//Inserindo usuario
		$idUsuario = parent::insert($element);
		if( !is_int($idUsuario) )
			return $idUsuario; 

		$sql = "INSERT INTO PROFESSOR (idusuario_fk, is_coordenador) VALUES (". $idUsuario .",". $element->isCoordenador().")"; 
		try{
		mysqli_query(parent::$connection,$sql);
		}catch( \Exception $e){}

		return mysqli_error(parent::$connection); 
	}
	
	public function isProfessor( $pk){
		$sql = "SELECT COUNT(*) FROM PROFESSOR WHERE  idusuario_fk = $pk"; 

		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		 $description = (int) $consulta['COUNT(*)']; 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Erro no banco de dados"; 
		else
			return $description; 
	}

	public function delete( $pk ){
		
	}
	
	public function select ( $pk ){
		
	}
	
	public function update ($element){
		
	}
}