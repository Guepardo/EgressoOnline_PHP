<?php
require_once('conf.php'); 


if( empty($_REQUEST['uc']) && empty($_REQUEST['a'])){
	$_REQUEST['uc'] = 'autenticar'; 
	$_REQUEST['a']  = 'loginView'; 
}

$controller = new MainController(); 
$controller->findMyController(); 

