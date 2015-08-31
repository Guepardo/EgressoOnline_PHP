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

		if(empty($date))
			return false;

		$sql = "SELECT * FROM (SELECT data_envio AS date, id FROM postagem UNION SELECT data_divulgacao AS date, id FROM oportunidade) AS result WHERE ( result.date < '". (string) $date."') ORDER BY result.date DESC limit ".$limit; 
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