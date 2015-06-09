<?php
namespace View\CustomViews; 

use View\GenericView; 

class HumanView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function cadastroView(){
		parent::getTemplateByAction('cadastro');
		parent::show(); 
	}
	
	public function loginView(){
		parent::getTemplateByAction('login'); 
		parent::show(); 
	}
}