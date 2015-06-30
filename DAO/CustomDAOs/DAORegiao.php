<?php 
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 
use Model\Regiao; 

class DAORegiao extends DAOBehavior{
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

	public function selectAllCountries(){
		$sql = "SELECT * FROM pais"; 
		$array = array(); 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		array_push($array, new Regiao((int) $consulta['idpais'], $consulta['desc'])); 
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

	public function selectAllStages( $country){
		$sql = "SELECT * FROM estado WHERE estado.idpais_fk = ( SELECT idpais FROM pais WHERE pais.desc = '$country')"; 
		$array = array(); 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		array_push($array, new Regiao((int) $consulta['idestado'], $consulta['desc'])); 	
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

	public function selectAllCities( $state){
		$sql = "SELECT * FROM cidade WHERE cidade.idestado_fk = ( SELECT idestado FROM estado WHERE estado.desc = '$state')"; 
		$array = array(); 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		array_push($array, new Regiao((int) $consulta['idcidade'], $consulta['desc'])); 	
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