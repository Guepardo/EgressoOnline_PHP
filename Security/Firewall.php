<?php 
class Firewall{
	function __construct(){

	}


 	public static function permissao($class, $methodName){
 		$result = true; //ação bloqueada: 
 		// echo("classe"+$class->sayMyName()+"nome do método: $methodName");  
 		$reflection = new ReflectionAnnotatedMethod($class,$methodName); 
		$annotation = $reflection->getAnnotation('BlockList');
		
		$isVisitante = (empty($_SESSION['user']) || (!$_SESSION['user']['egresso'] && !$_SESSION['user']['professor'] && !$_SESSION['user']['coordenador'] ));

		echo "asdfasdfkjasdf ".(int) $isVisitante;
		var_dump($annotation->value);    
 	}
}