<?php
namespace View\CustomViews; 

use View\GenericView; 

class AutenticarView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function loginView(){
		parent::getTemplateByAction('login'); 
		parent::show(); 
	}
}