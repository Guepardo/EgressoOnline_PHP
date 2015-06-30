<?php 
namespace Controller\UseCase; 

use Controller\GenericController; 
use DAO\CustomDAOs\DAORegiao; 


class AjaxServices extends GenericController{
	public function __construct(){

	}

	public function getStates( $arg ){	
		$daoRegiao = new DAORegiao(); 
		$result = $daoRegiao->selectAllStages(utf8_decode(trim($arg['country']))); 	
		$array = array(); 
		foreach( $result as $regiao )
			array_push($array, utf8_encode(strtoupper($regiao->getDescricao())));  
		die(json_encode($array));
	}

	public function getCities( $arg ){	
		$daoRegiao = new DAORegiao(); 
		$result = $daoRegiao->selectAllCities(utf8_decode(trim($arg['state']))); 	
		$array = array(); 
		foreach( $result as $regiao )
			array_push($array, utf8_encode(strtoupper($regiao->getDescricao())));  
		die(json_encode($array));
	}
}