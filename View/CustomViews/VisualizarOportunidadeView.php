<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class VisualizarOportunidadeView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function oportunidadesView(){
		parent::getTemplateByAction('listaOportunidade'); 
		Lumine::import("Oportunidade"); 
		Lumine::import("OpEmprego");
		Lumine::import("Usuario");  

		$op = new Oportunidade(); 

		$op->order("data_divulgacao desc")->limit(500)->find(); 

		while($op->fetch()){
			$emprego = new OpEmprego(); 
			$total = $emprego->get($op->id); 

			$whoIs = ($total > 0 ) ? "Emprego" : "Pós-graduação"; 

			parent::$templator->setVariable("op.tipo", $whoIs); 
			parent::$templator->setVariable("op.data", $op->dataDivulgacao); 

			$usuario = new Usuario(); 
			$usuario->get($op->usuarioId); 

			parent::$templator->setVariable("op.divulgador", $usuario->nome); 
			parent::$templator->setVariable("op.id", $op->id."-".(($total > 0 ) ? 'false' : 'true' ) );

			parent::$templator->addBlock("row");  

		}
		parent::show(); 
	}

}