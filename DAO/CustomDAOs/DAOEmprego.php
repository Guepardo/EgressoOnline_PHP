<?php
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 
use DAO\CustomDAOs\DAOLocalidade; 

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

	public function delete( $pk ){}
	public function select ( $pk ){}
	public function update ($element){}
}