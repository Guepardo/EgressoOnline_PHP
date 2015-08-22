<?php 
require_once(PATH.'DAO'.DS.'DAOBehavior.php'); 

class DAOFeed extends DAOBehavior{
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

	public function feed($date, $limit){
		$sql = "select * from (select data_envio as date, id from postagem union select data_divulgacao as date, id from oportunidade) as result where ( result.date < '$date') order by result.date DESC limit $limit"; 
		$array = array(); 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		array_push($array, array( $consulta['id'], $consulta['date'])); 	
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return false; 
		else if (count($array) == 0 )
			return false; 
		else
			return $array;
	}
}