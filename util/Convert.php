<?php  
namespace Util; 

class Convert {
	
	function __construct(){

	}

	public static function toUTF8($string){
		return utf8_encode($string); 
	}

	public static function toUpperCase_ToUTF8($string){
		return self::toUTF8(strtoupper($string)); 
	}
}