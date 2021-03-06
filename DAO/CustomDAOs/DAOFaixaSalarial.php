<?php 
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 
use Model\FaixaSalarial; 

class DAOFaixaSalarial extends DAOBehavior{
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element ){
	}

	public function delete( $pk ){
	}
	
	public function select ( $pk ){
	}
	
	public function update ($element){
	}

	public function getDescriptionById($id){
		$sql = "SELECT faixa_salarial.desc FROM faixa_salarial WHERE faixa_salarial.idfaixa_salarial = $id"; 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		 $description = $consulta['desc']; 
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

	public function selectAll(){
		$sql = "SELECT * FROM faixa_salarial"; 
		$array = array(); 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		array_push($array, new FaixaSalarial((int) $consulta['idfaixa_salarial'], $consulta['desc'])); 
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
}