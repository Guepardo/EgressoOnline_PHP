<?php 
//Definições Gerais
date_default_timezone_set('America/Sao_Paulo');
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
define ('PATH', WWW_ROOT.DS); 
//Definições de banco de dados: 
define('DB_DATABASE',"mydb"); 
define('DB_USER'    ,"root"); 
define('DB_PASSWORD',""); 
define('DB_HOST'    ,"localhost"); 
define('DB_PORT'    ,"3306");
require_once(WWW_ROOT.DS.'Persistence'.DS.'Lumine.php');
require_once(WWW_ROOT.DS.'Persistence'.DS.'lumine-conf.php');
$cfg = new Lumine_Configuration( $lumineConfig );
//Definições de e-mail
define('EMAIL_HOST'    ,"tls://g4group.me:20000"); 
define('EMAIL_USERNAME',"egressoonline@g4group.me"); 
define('EMAIL_PASSWORD',"12345678"); 
define('EMAIL_FROM'    ,"egressoonline@g4group.me");
//Bibliotecas globais: 
require_once(WWW_ROOT.DS.'Library'.DS.'annotations.php');
require_once(PATH.'Controller'.DS.'MainController.php'); 
session_start(); 