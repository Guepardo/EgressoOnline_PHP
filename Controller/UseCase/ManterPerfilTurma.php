<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'Util'.DS.'Image.php');

class ManterPerfilTurma extends GenericController {
	public function __construct() {
	}	

	public function alterarFoto($arg){
		// var_dump($arg); 
		// die; 

		$m = new Image(); 
		$result = $m->saveCropLandspace('file',$arg['x'],$arg['y'],$arg['x2'],$arg['y2']); 
		Lumine::import("Turma"); 

		$turma = new Turma(); 
		$total = $turma->get($_SESSION['user_id']); 

		if($total < 0){
			die("error");
		}
		if(is_int($result)){
			$msg = array('nopost_msg' => 'Erro: '.$m->errors[$result] ); 
			exit; 
		}

		$lastImage = $turma->foto; 

		if(strcmp($lastImage,'Midia\\default_turma.png') != 0)
			unlink(PATH.$lastImage); 

		$turma->foto = 'Midia'.DS.DS.$result; 
		$turma->update(); 

		//Passando mensagem interna para a outra tela 
		$msg = array('nopost_msg' => "Sua foto de perfil foi modificada com sucesso."); 
		var_dump($msg); 
	}

	
}