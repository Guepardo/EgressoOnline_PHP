<?php
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 

class DAOHuman implements DAOBehavior{
	public function insert( $element ){
		$sql = "insert into human (name,age,weight) values ('".$element->getName()."',".$element->getAge()."," .$element->getWeight().") ";
		for( $a = 0 ; $a < 100; $a++)
		self::query($sql); 
	}
	
	public function delete( $pk ){
		
	}
	
	public function select ( $pk ){
		
	}
	
	public function update ($element){
		
	}
	
}