<?php
namespace View\CustomViews; 

use View\GenericView; 
use DAO\CustomDAOs\DAORegiao; 


class TelaPrincipalView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function principalView(){
		$daoRegiao = new DAORegiao(); 
		parent::getTemplateByAction('tela'); 

		foreach( $daoRegiao->selectAllCountries() as $country ){
			parent::$templator->setVariable("emprego.pais.value", $country->getId() ); 
			parent::$templator->setVariable("emprego.pais.desc", utf8_encode($country->getDescricao())); 
			parent::$templator->setVariable("pos.pais.value", $country->getId() ); 
			parent::$templator->setVariable("pos.pais.desc", utf8_encode($country->getDescricao())); 

			parent::$templator->addBlock("emprego.pais");
			parent::$templator->addBlock("pos.pais"); 
		}

		foreach( $daoRegiao->selectAllStages("BRASIL") as $estado ){
			parent::$templator->setVariable("emprego.estado.value", $estado->getId() ); 
			parent::$templator->setVariable("emprego.estado.desc", utf8_encode($estado->getDescricao())); 
			parent::$templator->setVariable("pos.estado.value", $estado->getId() ); 
			parent::$templator->setVariable("pos.estado.desc", utf8_encode($estado->getDescricao())); 

			parent::$templator->addBlock("emprego.estado");
			parent::$templator->addBlock("pos.estado"); 
		}
		
		parent::show(); 
	}
}