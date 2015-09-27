<?php 
require_once(PATH.'Controller'.DS.'GenericController.php'); 

/**
 * Classes que compreende os serviços via Ajax 
 */
class AjaxServices extends GenericController{
	public function __construct(){

	}

	/**
	 *  Esta função retorna um array de estados {id, descricao} 
	 *
	 * @param      <array>  $arg    (inserir um valor int na chave 'country'); 
	 * @return     <array>  retorna um array de estados.
	 */
	/** @BlockList({'visitante'}) */
	public function getStates( $arg ){	
		$daoRegiao = new DAORegiao(); 
		$result = $daoRegiao->selectAllStages(utf8_decode(trim($arg['country']))); 	
		$array = array(); 
		foreach( $result as $regiao )
			array_push($array, utf8_encode(strtoupper($regiao->getDescricao())));  
		die(json_encode($array));
	}

	/** @BlockList({'visitante'}) */
	public function getCities( $arg ){	
		Lumine::import('Cidade'); 
		$cidade = new Cidade(); 

		$cidade->where('estado_id = ' .$arg['state'])->find();
		$array = array(); 
		
		while( $cidade->fetch() )
			array_push($array, utf8_encode(strtoupper($cidade->des)));  
		die(json_encode($array));
	}

	// public function getEgressoLocation(){
	// 	$idEgresso  = $_SESSION['id_user']; 
	// 	$idLocation = ( new DAOEgresso()   )->getIdLocation($idEgresso);

	// 	$daoLocalidade = new DAOLocalidade(); 
	// 	$location = $daoLocalidade->select($idLocation); 

	// 	if( is_string($location) ) return; //Tu-do: ver o que vou fazer aqui para informar o erro; 

	// 	$countryName = utf8_encode(strtoupper($daoLocalidade->getNameCountry($location->getPais()))); 
	// 	$cityName    = utf8_encode(strtoupper($daoLocalidade->getNameCity($location->getCidade()))); 

	// 	$array = array( "cidade" => $cityName, "pais" => $countryName ); 

	// 	die(json_encode($array));   
	// }

	
}