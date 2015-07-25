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
		$sql = "SELECT * FROM LOCALIDADE WHERE idlocalidade = $pk"; 
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

	//retorna -1 em caso de erro
	public function getNameCountry( $pk ){
		$sql = "SELECT pais.desc FROM PAIS WHERE idpais = $pk"; 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		$name = $consulta['desc']; 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return -1; 
		else
			return $name; 
	}

	//retorna -1 em caso de erro
	public function getNameCity( $pk ){
		$sql = "SELECT cidade.desc FROM CIDADE WHERE idcidade = $pk"; 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		$name = $consulta['desc']; 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return -1; 
		else
			return $name; 
	}

	//retorna -1 em caso de erro
	public function getStageByCity( $pk ){
		$sql = "SELECT estado.desc FROM estado WHERE (SELECT idestado_fk FROM cidade WHERE idcidade = $pk) = idestado"; 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		$name = $consulta['desc']; 
			} 			
		}catch( \Exception $e){}
		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return -1; 
		else
			return $name; 
	}
	public function delete( $pk ){}
	public function update ($element){}
}