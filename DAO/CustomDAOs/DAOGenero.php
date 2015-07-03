<?php 
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 

class DAOGenero extends DAOBehavior{
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

	public function getIdByName( $name ){
		$sql = "SELECT genero.idgenero FROM genero WHERE genero.desc = '$name' "; 
		 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		$id = (int) $consulta['idgenero']; 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Erro no banco de dados"; 
		else
			return $id; 
	}
}