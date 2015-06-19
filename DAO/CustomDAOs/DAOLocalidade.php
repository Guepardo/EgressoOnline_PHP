<?php  
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 

use Model\Localidade; 

class DAOLocalidade extends DAOBehavior{
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element='' ){
		//TODO: Ver o caso de quando o argumento de fato for um objeto localidade. 

		//Inserindo localidade para o egresso (VAZIA)
		$sql = "INSERT INTO LOCALIDADE (complemento) VALUES ('')"; 
		try{
			mysqli_query(parent::$connection,$sql);
			$idLocalidade = mysqli_insert_id(parent::$connection); 
		}catch( \Exception $e){}

		if( empty(mysqli_error(parent::$connection)) )
			return $idLocalidade;  
		else
			return mysqli_error(parent::$connection); 
	}

	public function select ( $pk ){
		$sql = "SELECT * FROM LOCALIDADE WHERE  idlocalidade = $pk"; 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		$localidade = new Localidade((int) $consulta['idlocalidade'], $consulta['complemento'], (int) $consulta['idcidade_fk'], (int) $consulta['idpais_fk']); 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Nada encontrado com essa id"; 
		else
			return $localidade; 
	}


	public function delete( $pk ){}
	public function update ($element){}
}