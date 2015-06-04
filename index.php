<?php
//Indicando que este script usará sessões em algum momento da sua execução. 
session_start(); 

//Criar um arquivo para definições mais tarde. 
define ( 'PROJECT_NAME', 'PseudoArquitetura' );
define ( 'PATH_TEMPLATE', $_SERVER ['DOCUMENT_ROOT'] . PROJECT_NAME . '/templates/' );

require ('c/MainController.php');
require ('v/GenericView.php');
require ('v/HumanView.php');
require ('util/SecurityFilter.php'); 			
require_once ('c/GenericController.php');
require_once ('util/BDConnectionFactory.php');

//Exemplo funcional da fábrica de conexões funcionando. 
//$nada = BDConnectionFactory::getInstance();
//$result = mysqli_query($nada->getConnection(),"select * from nada");

(new SecurityFilter())->filteringRequest(); 

$mainController = new MainController ();
echo $mainController->findMyController(); 