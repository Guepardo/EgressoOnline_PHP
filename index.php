<?php
//Indicando que este script usar� sess�es em algum momento da sua execu��o. 
session_start(); 

//Criar um arquivo para defini��es mais tarde. 
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once( WWW_ROOT . DS . 'autoload.php'); 


use Controller\MainController; 
use Security\SecurityFilter; 



//Exemplo funcional da f�brica de conex�es funcionando. 
//$nada = BDConnectionFactory::getInstance();
//$result = mysqli_query($nada->getConnection(),"select * from nada");

//(new SecurityFilter())->filteringRequest(); 

var_dumP($_REQUEST); 

(new MainController() )->findMyController(); 
