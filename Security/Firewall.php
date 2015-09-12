<?php 
class Firewall{
	function __construct(){

	}


	public static function initFirewall(){
		if(empty($_SESSION['user']) )
			$_SESSION['user']['visitante'] = true; 
	}

	public static function permissao($class, $methodName){
 		// echo("classe"+$class->sayMyName()+"nome do método: $methodName");  
		$reflection = new ReflectionAnnotatedMethod($class,$methodName); 
		$blockList = $reflection->getAnnotation('BlockList');

		if (in_array('noblock',$blockList->value))
		 	return false;//Não é bloqueado. 

		 $courrentUser = null; 

		 foreach($_SESSION['user'] as $key => $value){
		 	if($value){
		 		$courrentUser = $key; 
		 		break; 
		 	} 
		 }

		 if (in_array($courrentUser, $blockList->value))
		 	return true; 

		 // var_dump($blockList->value); 
		 // var_dump($_SESSION['user']); 
		 // var_dump($courrentUser); 

		 return false; 
		}
	}