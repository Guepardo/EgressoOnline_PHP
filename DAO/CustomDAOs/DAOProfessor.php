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

	public function addDisciplinaById($idProf , $idDisci, $ano){
		$sql = "INSERT INTO disciplina_has_professor (iddisciplina_fk, idusuario_fk, ano_lecionou) VALUES ($idDisci, $idProf, $ano)"; 
		try{
			mysqli_query(parent::$connection,$sql);
		}catch( \Exception $e){}

		return mysqli_error(parent::$connection); 
	}
	
	public function hasDisciplinas($idProf){
		$sql = "SELECT * FROM disciplina_has_professor WHERE  idusuario_fk = $idProf "; 
		$array = array(); 

		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
				array_push($array, array("iddisciplina_fk" => $consulta['iddisciplina_fk'], "ano_lecionou" => $consulta['ano_lecionou'])); 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return false; 
		else
			return $array; 
	}

	public function unlinkDisciplina($idUsuario, $idDisciplina){
		$sql = "DELETE FROM disciplina_has_professor WHERE iddisciplina_fk = $idDisciplina AND idusuario_fk = $idUsuario"; 

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