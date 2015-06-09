<?php
//Indicando que este script usará sessões em algum momento da sua execução. 
session_start(); 

//Criar um arquivo para definições mais tarde. 
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once( WWW_ROOT . DS . 'autoload.php'); 


use Controller\MainController; 
use Security\SecurityFilter; 



//Exemplo funcional da fábrica de conexões funcionando. 
//$nada = BDConnectionFactory::getInstance();
//$result = mysqli_query($nada->getConnection(),"select * from nada");

//(new SecurityFilter())->filteringRequest(); 

var_dumP($_REQUEST); 

(new MainController() )->findMyController(); 
