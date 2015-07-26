<?php
namespace View\CustomViews; 

use View\GenericView; 
use DAO\CustomViews\DAORegiao; 


class TelaPrincipalView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function principalView(){
		$daoRegiao = DAORegiao(); 

		foreach( $daoRegiao->selectAllCountries() as $country ){
			parent::$templator->setVariable("emprego.pais.value", $country->getId() ); 
			parent::$templator->setVariable("emprego.pais.desc", $country->getDescricao()); 
			parent::$templator->setVariable("pos.pais.value", $country->getId() ); 
			parent::$templator->setVariable("pos.pais.desc", $country->getDescricao()); 

			parent::$templator->addBlock("emprego.pais");
			parent::$templator->addBlock("pos.pais"); 
		}

		parent::getTemplateByAction('tela'); 
		parent::show(); 
	}
}