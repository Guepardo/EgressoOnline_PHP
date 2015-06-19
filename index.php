<?php
//Indicando que este script usará sessões em algum momento em sua execução. 
session_start(); 

//*********Apenas para motivos de debug*********
$_SESSION['id_user'] = 65; 

//Criar um arquivo para definições mais tarde. 
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once( WWW_ROOT . DS . 'autoload.php'); 


use Controller\MainController; 
use Security\SecurityFilter; 
use DAO\CustomDAOs\DAOEgresso; 

//(new SecurityFilter())->filteringRequest(); 

//var_dump($_REQUEST); 
 

//(new MainController() )->findMyController(); 


$daoEgresso = new DAOEgresso(); 

$daoEgresso->select(1); 
