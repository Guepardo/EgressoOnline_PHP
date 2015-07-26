<?php
namespace View\CustomViews; 

use View\GenericView; 
use DAO\CustomDAOs\DAORegiao; 
use DAO\CustomDAOs\DAOAtuacaoProfissional; 
use Util\Convert; 


class TelaPrincipalView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function principalView(){
		$daoAtuacao = new DAOAtuacaoProfissional(); 
		$daoRegiao = new DAORegiao(); 
		parent::getTemplateByAction('tela'); 

		foreach( $daoRegiao->selectAllCountries() as $country ){
			parent::$templator->setVariable("emprego.pais.value", Convert::toUpperCase_ToUTF8($country->getDescricao()) ); 
			parent::$templator->setVariable("emprego.pais.desc", Convert::toUpperCase_ToUTF8($country->getDescricao())); 
			parent::$templator->setVariable("pos.pais.value", Convert::toUpperCase_ToUTF8($country->getDescricao()) ); 
			parent::$templator->setVariable("pos.pais.desc", Convert::toUpperCase_ToUTF8($country->getDescricao())); 

			parent::$templator->addBlock("emprego.pais");
			parent::$templator->addBlock("pos.pais"); 
		}

		foreach( $daoRegiao->selectAllStages("BRASIL") as $estado ){
			parent::$templator->setVariable("emprego.estado.value", Convert::toUpperCase_ToUTF8($estado->getDescricao()) ); 
			parent::$templator->setVariable("emprego.estado.desc", Convert::toUpperCase_ToUTF8($estado->getDescricao())); 
			parent::$templator->setVariable("pos.estado.value", Convert::toUpperCase_ToUTF8($estado->getDescricao()) ); 
			parent::$templator->setVariable("pos.estado.desc", Convert::toUpperCase_ToUTF8($estado->getDescricao())); 

			parent::$templator->addBlock("emprego.estado");
			parent::$templator->addBlock("pos.estado"); 
		}
		
		foreach( $daoAtuacao->selectAll() as $area ){
			parent::$templator->setVariable("area.value", Convert::toUpperCase_ToUTF8($area->getDescricao()) ); 
			parent::$templator->setVariable("area.desc", Convert::toUpperCase_ToUTF8($area->getDescricao())); 

			parent::$templator->addBlock("area");
		}
		parent::show(); 
	}
}