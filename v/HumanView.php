<?php
class HumanView extends Genericview{
	
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