<?php
//Indicando que este script usar� sess�es em algum momento em sua execu��o. 
session_start(); 

//Criar um arquivo para defini��es mais tarde. 
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once( WWW_ROOT . DS . 'autoload.php'); 


use Controller\MainController; 
use Security\SecurityFilter; 


//(new SecurityFilter())->filteringRequest(); 

//var_dump($_REQUEST); 

(new MainController() )->findMyController(); 
