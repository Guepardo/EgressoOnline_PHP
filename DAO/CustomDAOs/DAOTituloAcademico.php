<?php 
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 
use Model\TituloAcademico; 

class DAOTituloAcademico extends DAOBehavior{
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

	public function selectAll(){
		$sql = "SELECT * FROM titulo_academico"; 
		$array = array(); 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		array_push($array, new TituloAcademico((int) $consulta['idtitulo_academico'], $consulta['desc'])); 
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