<?php 
namespace Controller\UseCase; 

use Controller\GenericController; 

use DAO\CustomDAOs\DAORegiao; 
use DAO\CustomDAOs\DAOEgresso; 
use DAO\CustomDAOs\DAOLocalidade; 


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

	public function getEgressoLocation(){
		$idEgresso  = $_SESSION['id_user']; 
		$idLocation = ( new DAOEgresso()   )->getIdLocation($idEgresso);

		$daoLocalidade = new DAOLocalidade(); 
		$location = $daoLocalidade->select($idLocation); 

		if( is_string($location) ) return; //Tu-do: ver o que vou fazer aqui para informar o erro; 

		$countryName = utf8_encode(strtoupper($daoLocalidade->getNameCountry($location->getPais()))); 
		$cityName    = utf8_encode(strtoupper($daoLocalidade->getNameCity($location->getCidade()))); 

		$array = array( "cidade" => $cityName, "pais" => $countryName ); 

		die(json_encode($array));   
	}

	
}