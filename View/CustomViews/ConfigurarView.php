<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class ConfigurarView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function configurarView(){
		parent::getTemplateByAction('confNotificacoes'); 

		Lumine::import('AtuacaoProfissional'); 
		$area = new AtuacaoProfissional(); 
		$area->find(); 

		while(  $area->fetch() ){
			parent::$templator->setVariable("area.id", $area->id ); 
			parent::$templator->setVariable("area.des", Convert::toUTF_8($area->des)); 
			parent::$templator->addBlock("area");
		}

		Lumine::import("Notificacao"); 
		Lumine::import("NotificacaoHasTituloAcademico"); 
		Lumine::import("NotificacaoHasAtuacaoProfissional"); 
		$notificacao = new Notificacao(); 
		$notificacao->get('usuarioId', (int) $_SESSION['user_id']); 

		//Pegando as diciplinas de interessa. 
		$notificacaoAtuacao = new NotificacaoHasAtuacaoProfissional(); 
		$notificacaoAtuacao->where("notificacao_id = ". $notificacao->id)->find();  

		while($notificacaoAtuacao->fetch()){
			parent::$templator->setVariable("id", $notificacaoAtuacao->atuacaoProfissionalId );
			$area = new AtuacaoProfissional();  
			$area->get($notificacaoAtuacao->atuacaoProfissionalId); 
			parent::$templator->setVariable("nome", $area->des); 

			parent::$templator->addBlock("row");
		}

		//Pegando os interesses da pós-graduação. 
		parent::show(); 
	}
}