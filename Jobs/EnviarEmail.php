<?php  
//Criar um arquivo para definições mais tarde.
 
require_once('..\conf.php'); 
require_once(WWW_ROOT.DS.'Util'.DS.'Mail.php');

Lumine::import('EmailEnviar'); 
Lumine::import('Usuario'); 

$mail = new Mail(); 

$email = new EmailEnviar(); 

$email->limit(500)->find(); 

while($email->fetch()){
	$usuario = new Usuario(); 
	$usuario->get($email->usuarioId); 

	if($email->tipoEmail == 1 ){
		$mail->sendEmail($email->conteudo,$usuario->email,"EgressoOnline UEG - Informe de cadastro", $usuario->nome); 
	
	}else{
		$mail->sendEmail('olá',$usuario->email,"EgressoOnline UEG - Informe de oportunidade", $usuario->nome); 
	}
	echo("email enviado"); 

	$email->delete(); 
}