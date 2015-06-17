<?php  
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 

class DAOLocalidade extends DAOBehavior{
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element ){

	}

	public function delete( $pk ){}
	public function select ( $pk ){}
	public function update ($element){}
}