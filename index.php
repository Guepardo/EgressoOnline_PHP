<?php
//Indicando que este script usará sessões em algum momento em sua execução. 
session_start(); 

//Criar um arquivo para definições mais tarde. 
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once( WWW_ROOT . DS . 'autoload.php'); 


use Controller\MainController; 
use Security\SecurityFilter; 


//(new SecurityFilter())->filteringRequest(); 

//var_dump($_REQUEST); 

(new MainController() )->findMyController(); 
