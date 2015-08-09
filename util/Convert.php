<?php 
class Convert 
{
	function __construct()
	{
	}

	public static function toUTF_8($string){
		return utf8_encode($string); 
	}

	public static function toUpperCase($string){
		return strtoupper($string); 
	}

	public static function minification($string, $minLength){
		if($string == null ) return null; 
		if(strlen($string) <= $minLength ) return $string; 

		return substr($string,0,$minLength).'...'; 
	}
}