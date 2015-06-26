<?php 
namespace View\CustomViews; 

use View\GenericView; 
use DAO\CustomDAOs\DAOEgresso; 
use DAO\CustomDAOs\DAOUsuario; 
use DAO\CustomDAOs\DAOFaixaSalarial; 
use DAO\CustomDAOs\DAOEstadoCivil; 

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
		//Roteiro: 
		//Adicionar todos os conteúdos dos dropdowns
		//Adicionar valores da variável egresso ao template; 

		$daoEgresso = new DAOEgresso(); 
		$daoEstadoCivil = new DAOEstadoCivil(); 
		$daoFaixaSalarial = new DAOFaixaSalarial(); 

		$egresso = $daoEgresso->select($_SESSION['id_user']); 
		parent::getTemplateByAction("alterarDados"); 
		//Begin Blocks
		//Estado Civil: 

		foreach( $daoEstadoCivil->selectAll() as $estadoCivil ){
			parent::$templator->setVariable('egresso.estado_civil.value', $estadoCivil->getDescricao());
			parent::$templator->setVariable('egresso.estado_civil.desc', $estadoCivil->getDescricao());
			parent::$templator->addBlock("estado_civil"); 
		}

		
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