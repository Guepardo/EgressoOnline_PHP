<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class BuscarView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function buscaView($arg){
		parent::getTemplateByAction('busca'); 
		Lumine::import("Usuario"); 
		Lumine::import("Egresso"); 
		Lumine::import("Professor"); 
		//Se for inteiro, procurar por classes
		//Se for string, procurar por nomes relacionados
		$arg = $arg['arg']; 

		if(is_numeric($arg)){
			$arg = (int) $arg; 

			$usuario = new Usuario(); 
			$usuario->where("")
		}else{

		}
		parent::show(); 
	}
}