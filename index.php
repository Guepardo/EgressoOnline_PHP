<?php
//Indicando que este script usará sessões em algum momento em sua execução. 
session_start(); 

//*********Apenas para motivos de debug*********

//Criar um arquivo para definições mais tarde. 
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once( WWW_ROOT . DS . 'autoload.php'); 


use Controller\MainController; 
use Security\SecurityFilter; 
use DAO\CustomDAOs\DAOEgresso; 
use DAO\CustomDAOs\DAOFaixaSalarial; 
use DAO\CustomDAOs\DAOGenero; 
use DAO\CustomDAOs\DAODisciplina; 
use DAO\CustomDAOs\DAOProfessor; 

use Util\Mail; 

//	(new SecurityFilter())->filteringRequest(); 

//var_dump($_REQUEST); 
//Apenas para os testes ficarem mais dinâmicos. 
if( empty($_REQUEST['usecase']) || empty($_REQUEST['action']) ){
	$_REQUEST['usecase'] = 'autenticar'; 
	$_REQUEST['action'] = 'loginView'; 
}

(new MainController() )->findMyController(); 

//Ainda em digivolvimento
//$mail = new Mail(); 

//$mail->sendEmail("Apenas um texto simples aqui","bsinet@hotmail.com", "Allyson Maciel"); 