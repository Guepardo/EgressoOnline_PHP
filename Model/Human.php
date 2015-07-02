<?php
namespace Model; 

class Human{
	private $name; 
	private $age; 
	private $weight; 
	
	public function __construct( $name, $age, $wieght){
		$this->name = $name; 
		$this->age = $age; 
		$this->weight = $wieght;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getAge(){
		return $this->age; 
	}
	
	public function getWeight(){
		return $this->weight; 
	}
}