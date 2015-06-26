<?php 
namespace View\CustomViews; 

use View\GenericView; 
use DAO\CustomDAOs\DAOEgresso; 
use DAO\CustomDAOs\DAOUsuario; 

class ManterUsuarioView extends GenericView{
	public function __construct(){
		parent::__construct($this); 
	}

	public function cadastroProfessorView(){
		parent::getTemplateByAction("cadastroProfessor"); 
		parent::show(); 
	}

	public function cadastroEgressoView(){
		parent::getTemplateByAction("cadastroEgresso"); 
		parent::show(); 
	}

	public function alterarDadosView(){
		$daoEgresso = new DAOEgresso(); 
		$egresso = $daoEgresso->select($_SESSION['id_user']); 

		parent::getTemplateByAction("alterarDados"); 
		parent::$templator->setVariable("egresso.nome", $egresso->getNome()); 
		parent::$templator->setVariable("egresso.email", $egresso->getEmail()); 
		parent::$templator->setVariable("egresso.qtdFilhos", $egresso->getQtdFilhos());
		parent::$templator->setVariable("egresso.telefone", $egresso->getTelefone());
		parent::show(); 
	}

	public function alterarSenhaView(){
		parent::getTemplateByAction("alterarSenha"); 
		parent::show(); 
	}

	public function alterarDadosProfessorView(){
		$daoUsuario = new DAOUsuario(); 
		//TODO: validar a saída desse dao:
		$usuario = $daoUsuario->select($_SESSION['id_user']); 

		parent::getTemplateByAction("alterarDadosProfessor"); 
		parent::$templator->setVariable("usuario.nome", $usuario->getNome()); 
		parent::$templator->setVariable("usuario.email", $usuario->getEmail()); 
		parent::show(); 
	}
}