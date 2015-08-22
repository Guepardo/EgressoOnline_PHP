<?php
require_once(PATH.'Util'.DS.'BDConnectionFactory.php'); 

abstract class DAOBehavior{
	static protected $connection; 

	public function __construct(){
		$Bd = BDConnectionFactory::getInstance(); 
		self::$connection = $Bd->getConnection(); 
	}

	abstract public function insert( $element ); 
	abstract public function delete( $pk ); 
	abstract public function select ( $pk ); 
	abstract public function update ($element); 
}