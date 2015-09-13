<?php 
date_default_timezone_set('America/Sao_Paulo');

define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
define ('PATH', WWW_ROOT.DS); 


require_once(WWW_ROOT.DS.'Persistence'.DS.'Lumine.php');
require_once(WWW_ROOT.DS.'Persistence'.DS.'lumine-conf.php');

$cfg = new Lumine_Configuration( $lumineConfig );

require_once(WWW_ROOT.DS.'Library'.DS.'annotations.php');
require_once(PATH.'Controller'.DS.'MainController.php'); 

session_start(); 