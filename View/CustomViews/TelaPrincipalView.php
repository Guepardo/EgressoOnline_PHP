<?php
namespace View\CustomViews; 

use View\GenericView; 

class TelaPrincipalView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function principalView(){
		parent::getTemplateByAction('tela'); 
		parent::show(); 
	}
}