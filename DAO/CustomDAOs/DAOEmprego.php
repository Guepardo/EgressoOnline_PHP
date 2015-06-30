<?php
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 
use DAO\CustomDAOs\DAOLocalidade; 
use DAO\CustomDAOs\DAOAtuacaoProfissional; 
use DAO\CustomDAOs\DAOFaixaSalarial; 
use Model\Emprego; 

class DAOEmprego extends DAOBehavior{
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element='' ){
		//TODO: Ver o caso de quando o argumento de fato for um objeto localidade. 

		$daoLocalidade = new DAOLocalidade(); 
		//Inserindo localidade para o emprego (VAZIA)
		$idLocalidadeEmprego = $daoLocalidade->insert(); 
		if( !is_int($idLocalidadeEmprego) )
			return $idLocalidadeEmprego; //retorna a mensagem de erro do DAO acima.

		//Inserindo localidade para o egresso (VAZIA)
		$sql = "INSERT INTO EMPREGO (nome_empresa, idlocalidade_fk, idfaixa_salarial_fk, idatuacao_profissional_fk) VALUES ('', $idLocalidadeEmprego,1,1)"; 
		try{
			mysqli_query(parent::$connection,$sql);
			$idEmprego = mysqli_insert_id(parent::$connection); 
		}catch( \Exception $e){}

		if( empty(mysqli_error(parent::$connection)) )
			return $idEmprego;  
		else
			return mysqli_error(parent::$connection); 
	}

	public function select( $pk ){
		$sql = "SELECT * FROM EMPREGO WHERE idemprego = $pk"; 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		$emprego = new Emprego((int) $consulta['idemprego'], $consulta['nome_empresa'], (int) $consulta['idfaixa_salarial_fk'], (int) $consulta['idatuacao_profissional_fk'], (int) $consulta['idlocalidade_fk']); 
			} 			
		}catch( \Exception $e){}

		$daoLocalidade          = new DAOLocalidade(); 
		$daoAtuacaoProfissional = new DAOAtuacaoProfissional(); 
		$daoFaixaSalarial       = new DAOFaixaSalarial();

		//Todo validar a saída disso: 
		$emprego->setLocalidade($daoLocalidade->select($emprego->getLocalidade())); 

		$emprego->setAtuacaoProfissional( $daoAtuacaoProfissional->getDescriptionById($emprego->getAtuacaoProfissional())); 
		$emprego->setFaixaSalarial( $daoFaixaSalarial->getDescriptionById($emprego->getFaixaSalarial())); 
		//var_dump($emprego); 

		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Nada encontrado com essa id"; 
		else
			return $emprego; 
	}

	public function delete( $pk ){}
	public function update ($element){}
}