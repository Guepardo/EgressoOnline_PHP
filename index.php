<?php
//Configurando a data e hora do servidor: 
date_default_timezone_set('America/Sao_Paulo');

//Criar um arquivo para definições mais tarde. 
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
define ('PATH', WWW_ROOT.DS); 


require_once(WWW_ROOT.DS.'Persistence'.DS.'Lumine.php');
require_once(WWW_ROOT.DS.'Persistence'.DS.'lumine-conf.php');
require_once(WWW_ROOT.DS.'Library'.DS.'annotations.php');
require_once(PATH.'Controller'.DS.'MainController.php'); 

$cfg = new Lumine_Configuration( $lumineConfig );

//Indicando que este script usará sessões em algum momento em sua execução. 
session_start(); 

//ADICIONANDO O VALOR DO USER_ID SEMPRE EM UM, PELO FATO DE NÃO EXISTIR SISTEMA DE LOGIN AINDA. 

//require_once( WWW_ROOT . DS . 'autoload.php'); 

//(new SecurityFilter())->filteringRequest(); 

//var_dump($_REQUEST); 

if( empty($_REQUEST['uc']) || empty($_REQUEST['a'])){
	$_REQUEST['uc'] = 'autenticar'; 
	$_REQUEST['a']  = 'loginView'; 
}

$controller = new MainController(); 
$controller->findMyController(); 

//Ainda em digivolvimento
//$mail = new Mail(); 

//$mail->sendEmail("Apenas um texto simples aqui","bsinet@hotmail.com", "Allyson Maciel"); 

// require(WWW_ROOT.DS.'Util'.DS.'Image.php');

// $m = new Image(); 

// $arg = $_REQUEST; 
// // var_dump($arg); 
// echo $m->saveCropAvatar('file',$arg['x'],$arg['y'],$arg['x2'],$arg['y2']); 