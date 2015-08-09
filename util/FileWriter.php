<?php 


 class FileWriter{
 	private $fileName; 

	public function __construct( $fileName){
		$this->fileName = $fileName; 
	}

	public function writeString( $string ){
		$f=fopen(WWW_ROOT.DS.$this->fileName.".txt","a+",0);
		$string = $string .":\n";
		fwrite($f,$string,strlen($string));
		fclose($f);
	}
}