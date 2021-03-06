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
		return mb_strtoupper($string); 
	}

	public static function upperUtf8($string){
		return self::toUTF_8(self::toUpperCase($string)); 
	}

	public static function minification($string, $minLength){
		if($string == null ) return null; 
		if(strlen($string) <= $minLength ) return $string; 

		return substr($string,0,$minLength).'...'; 
	}
}