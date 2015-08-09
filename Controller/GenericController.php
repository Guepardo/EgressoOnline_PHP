<?php

abstract class GenericController {
	public function sayMyName() {
		$var = new ReflectionClass ( $this );
		return $var->getName ();
	}
	
	public function sayMyActions() {
		$var = new ReflectionClass ( $this );
		$array = array ();
		$arrayTemp = $var->getMethods ( ReflectionMethod::IS_PUBLIC );
		
		foreach ( $arrayTemp as $a )
			array_push ( $array, $a->name );
		
		return $array;
	}
}