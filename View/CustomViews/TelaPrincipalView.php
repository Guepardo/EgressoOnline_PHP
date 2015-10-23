<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class TelaPrincipalView extends GenericView
{
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function principalView($arg=null){
		parent::getTemplateByAction('tela'); 

		Lumine::import("Pais"); 
		Lumine::import("Usuario"); 
		Lumine::import("Egresso"); 
		
		$pais = new Pais(); 
		$pais->find(); 

		//alternando menu de configurações: 
		$result = null; 

		if($_SESSION['user']['coordenador'])
			$result = parent::loadTemplate(PATH.'templates'.DS.'telaprincipal'.DS.'confCoordenador.html'); 
		else{
			if($_SESSION['user']['professor'])
				$result = parent::loadTemplate(PATH.'templates'.DS.'telaprincipal'.DS.'confProfessor.html'); 
			else
				$result = parent::loadTemplate(PATH.'templates'.DS.'telaprincipal'.DS.'confEgresso.html'); 
		}
		parent::$templator->setVariable('tela.configuracao',$result); 

		//Acionando o nome do usuário: 
		$usuario = new Usuario(); 
		$usuario->get($_SESSION['user_id']); 
		parent::$templator->setVariable('nome', $usuario->nome); 
		parent::$templator->setVariable('foto', $usuario->foto);
		parent::$templator->setVariable('visualizacao', $usuario->visualizacao); 

		while( $pais->fetch() ){
			parent::$templator->setVariable("pais.marcado",  (($pais->id == 33) ? 'selected' : '')); 
			parent::$templator->setVariable("pais.id",  $pais->id); 
			parent::$templator->setVariable("pais.des", Convert::upperUtf8($pais->des)); 

			parent::$templator->addBlock("pais"); 
		}

		Lumine::import('Estado'); 
		$estado = new Estado(); 
		$estado->where('pais_id = 33')->find(); 

		while( $estado->fetch() ){ 
			parent::$templator->setVariable("estado.id", $estado->id ); 
			parent::$templator->setVariable("estado.des", Convert::upperUtf8($estado->des)); 

			parent::$templator->addBlock("estado"); 
		}
		
		Lumine::import('AtuacaoProfissional'); 
		$area = new AtuacaoProfissional(); 
		$area->find(); 

		while(  $area->fetch() ){
			parent::$templator->setVariable("area.id", $area->id ); 
			parent::$templator->setVariable("area.des", Convert::upperUtf8($area->des)); 

			parent::$templator->addBlock("area");
		}

		Lumine::import('TituloAcademico'); 
		$tituloAcademico = new TituloAcademico(); 

		$tituloAcademico->find(); 

		while( $tituloAcademico->fetch() ){
			parent::$templator->setVariable("pos.tipo.id", $tituloAcademico->id ); 
			parent::$templator->setVariable("emprego.tipo.id", $tituloAcademico->id ); 

			parent::$templator->setVariable("pos.tipo.des", Convert::upperUtf8($tituloAcademico->des)); 
			parent::$templator->setVariable("emprego.tipo.des", Convert::upperUtf8($tituloAcademico->des)); 

			parent::$templator->addBlock("pos.tipo");
			parent::$templator->addBlock("emprego.tipo");
		}


		//Adicionando mensagem de redirecionamento:
		if(!empty($arg['nopost_msg']))
			parent::$templator->setVariable('msg',$arg['nopost_msg']);
		else
			parent::$templator->setVariable('is_hide', 'hide');

		//Adicionando o e-mail do coordenador vigente no modal da divulgação de emprego: 
		Lumine::import('Professor');
		Lumine::import('Usuario'); 
		$professor = new Professor(); 
		$professor->join( new Usuario )->where(" is_coordenador = 1 ")->find(); 
		$professor->fetch(true);  

		parent::$templator->setVariable('coordenador.email', $professor->email);
		
		parent::show(); 
	}

	public function tutorialView(){
		parent::getTemplateByAction('tutorial'); 
		parent::show(); 
	}
}