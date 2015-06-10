<?php
function __autoload( $class  ){
	$class = WWW_ROOT . DS . str_replace( '\\' , DS , $class ) . '.php'; 
	if( ! file_exists($class) ){
		throw new Exception("File path '{$class}' not found.");
	}
	require_once( $class ); 
}
