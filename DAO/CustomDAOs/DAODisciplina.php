<?php  
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 
use Model\Disciplina;

class DAODisciplina extends DAOBehavior{

	public function __construct(){
		parent::__construct(); 
	}

	public function selectAll(){
		$sql = "SELECT * FROM disciplina"; 
		$array = array(); 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
				array_push($array, new Disciplina((int) $consulta['iddisciplina'], $consulta['descri'])); 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Erro no banco de dados"; 
		else
			return $array; 
	}
	
	public function getIdByName($arg){
		$sql = "SELECT * FROM disciplina WHERE descri = '$arg' "; 

		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
				$disciplina =  $consulta['iddisciplina']; 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Erro no banco de dados"; 
		else
			return $disciplina; 
	}

	public function getNameById($id){
		$sql = "SELECT descri FROM disciplina WHERE iddisciplina = $id "; 

		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
				$name =  $consulta['descri']; 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Erro no banco de dados"; 
		else
			return $name; 
	}
	
	public function insert( $element ){} 
	public function delete( $pk ){}
	public function select ( $pk ){}
	public function update ($element){}
}