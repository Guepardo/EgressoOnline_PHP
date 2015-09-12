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
			$result = parent::loadTemplate(PATH.'templates'.DS.'telaPrincipal'.DS.'confCoordenador.html'); 
		else
			$result = parent::loadTemplate(PATH.'templates'.DS.'telaPrincipal'.DS.'confEgresso.html'); 

		parent::$templator->setVariable('tela.configuracao',$result); 

		//Acionando o nome do usuário: 
		$usuario = new Usuario(); 
		$usuario->get($_SESSION['user_id']); 
		parent::$templator->setVariable('nome', $usuario->nome); 
		parent::$templator->setVariable('foto', $usuario->foto);
		parent::$templator->setVariable('visualizacao', $usuario->visualizacao); 

		//Verificando se é egresso: 
		$egresso = new Egresso(); 
		$total = $egresso->get('usuarioId', $usuario->id); 

		if($total < 0 ){
			parent::$templator->setVariable('alterou_dado', 1 ); 
		}else{
			parent::$templator->setVariable('alterou_dado', $egresso->alterouDado ); 
		}

		while( $pais->fetch() ){
			parent::$templator->setVariable("emprego.pais.id", $pais->id ); 
			parent::$templator->setVariable("emprego.pais.des", Convert::toUTF_8($pais->des)); 
			parent::$templator->setVariable("pos.pais.id",  $pais->id); 
			parent::$templator->setVariable("pos.pais.des", Convert::toUTF_8($pais->des)); 

			parent::$templator->addBlock("emprego.pais");
			parent::$templator->addBlock("pos.pais"); 
		}

		Lumine::import('Estado'); 
		$estado = new Estado(); 
		$estado->where('pais_id = 33')->find(); 

		while( $estado->fetch() ){
			parent::$templator->setVariable("emprego.estado.id", $estado->id ); 
			parent::$templator->setVariable("emprego.estado.des", Convert::toUTF_8($estado->des)); 
			parent::$templator->setVariable("pos.estado.id", $estado->id ); 
			parent::$templator->setVariable("pos.estado.des", Convert::toUTF_8($estado->des)); 

			parent::$templator->addBlock("emprego.estado");
			parent::$templator->addBlock("pos.estado"); 
		}
		
		Lumine::import('AtuacaoProfissional'); 
		$area = new AtuacaoProfissional(); 
		$area->find(); 

		while(  $area->fetch() ){
			parent::$templator->setVariable("area.id", $area->id ); 
			parent::$templator->setVariable("area.des", Convert::toUTF_8($area->des)); 

			parent::$templator->addBlock("area");
		}

		Lumine::import('TituloAcademico'); 
		$tituloAcademico = new TituloAcademico(); 

		$tituloAcademico->find(); 

		while( $tituloAcademico->fetch() ){
			parent::$templator->setVariable("pos.tipo.id", $tituloAcademico->id ); 
			parent::$templator->setVariable("emprego.tipo.id", $tituloAcademico->id ); 

			parent::$templator->setVariable("pos.tipo.des", Convert::toUTF_8($tituloAcademico->des)); 
			parent::$templator->setVariable("emprego.tipo.des", Convert::toUTF_8($tituloAcademico->des)); 

			parent::$templator->addBlock("pos.tipo");
			parent::$templator->addBlock("emprego.tipo");
		}


		//Adicionando mensagem de redirecionamento:
		if(!empty($arg['nopost_msg']))
			parent::$templator->setVariable('msg',$arg['nopost_msg']);
		else
			parent::$templator->setVariable('is_hide', 'hide');
		
		parent::show(); 
	}

	public function tutorialView(){
		parent::getTemplateByAction('tutorial'); 
		parent::show(); 
	}
}