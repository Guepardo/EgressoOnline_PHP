<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'VisualizarPerfilView.php'); 
require_once(PATH.'Util'.DS.'Image.php');

class ManterPerfilTurma extends GenericController {
	public function __construct() {
	}	

	/** @BlockList({'visitante','professor','egresso'}) */
	public function alterarFoto($arg){
		// die; 
		$view = new VisualizarPerfilView(); 

		if(empty($arg['x']) || empty($arg['y']) || empty($arg['x2']) || empty($arg['y2'])){
			$arg['nopost_msg'] = "Recorte a foto antes de enviar."; 
			$view->perfilTurmaView($arg); 
			exit; 
		}

		$m = new Image(); 
		$result = $m->saveCropLandspace('file',$arg['x'],$arg['y'],$arg['x2'],$arg['y2']); 
		Lumine::import("Turma"); 

		$turma = new Turma(); 
		$total = $turma->get((int) $arg['id']); 

		if($total < 0){
			die("error");
		}
		
		if(is_int($result)){
			$msg = array('nopost_msg' => 'Erro: '.$m->errors[$result] );
			$arg['nopost_msg'] = "Sua foto de perfil foi modificada com sucesso.";
			$view->perfilTurmaView($arg);
			exit; 
		}

		$lastImage = $turma->foto; 

		if(strcmp($lastImage,'Midia/default_turma.png') != 0 )
			unlink(PATH.$lastImage); 

		$turma->foto = 'Midia/'.$result; 
		$turma->update(); 

		//Passando mensagem interna para a outra tela 

		
		$arg['nopost_msg'] = "Sua foto de perfil foi modificada com sucesso."; 
		$view->perfilTurmaView($arg); 
	}

	
}