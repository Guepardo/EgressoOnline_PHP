<?php 
namespace View\CustomViews; 

use View\GenericView; 
use DAO\CustomDAOs\DAOEgresso; 
use DAO\CustomDAOs\DAOUsuario; 
use DAO\CustomDAOs\DAOFaixaSalarial; 
use DAO\CustomDAOs\DAOEstadoCivil; 
use DAO\CustomDAOs\DAORegiao; 
use DAO\CustomDAOs\DAOAtuacaoProfissional; 
use DAO\CustomDAOs\DAORedeSocial;

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

		$daoEgresso             = new DAOEgresso(); 
		$daoEstadoCivil         = new DAOEstadoCivil(); 
		$daoFaixaSalarial       = new DAOFaixaSalarial(); 
		$daoRegiao              = new DAORegiao(); 
		$daoAtuacaoProfissional = new DAOAtuacaoProfissional(); 
		$daoRedeSocial          = new DAORedeSocial(); 

		$egresso = $daoEgresso->select($_SESSION['id_user']); 
		parent::getTemplateByAction("alterarDados"); 
		//Begin Blocks
		//Estado Civil: 
		//Faixas salarárias
		foreach( $daoFaixaSalarial->selectAll() as $faixa ){
			parent::$templator->setVariable('emprego.faixa.value', utf8_encode(strtoupper($faixa->getDescricao())));
			parent::$templator->setVariable('emprego.faixa.desc', utf8_encode(strtoupper($faixa->getDescricao())));
			if( $egresso->getEmprego()->getFaixaSalarial() == $faixa->getDescricao() )
				$temp = 'selected'; 
			else
				$temp =''; 
			parent::$templator->setVariable("emprego.faixa.selected", utf8_encode($temp)); 
			parent::$templator->addBlock("emprego.faixa"); 
		}

		//Estado Civil 
		foreach( $daoEstadoCivil->selectAll() as $estadoCivil ){
			parent::$templator->setVariable('egresso.estado_civil.value', utf8_encode(strtoupper($estadoCivil->getDescricao())));
			parent::$templator->setVariable('egresso.estado_civil.desc', utf8_encode(strtoupper($estadoCivil->getDescricao())));

			if( $egresso->getEstadoCivil() == $estadoCivil->getDescricao() )
				$temp = 'selected'; 
			else
				$temp =''; 
			parent::$templator->setVariable("egresso.estado_civil.selected", utf8_encode($temp)); 

			parent::$templator->addBlock("estado_civil"); 
		}

		//Adicionando países no formulário do egresso e do emprego do mesmo
		foreach( $daoRegiao->selectAllCountries() as $regiao ){
			parent::$templator->setVariable('egresso.pais.value', utf8_encode(strtoupper($regiao->getDescricao())));
			parent::$templator->setVariable('egresso.pais.desc', utf8_encode(strtoupper($regiao->getDescricao())));
			parent::$templator->addBlock("egresso.pais"); 
		}

		//Adicionando áreas de atuação profissional
		foreach( $daoAtuacaoProfissional->selectAll() as $atuacao ){
			parent::$templator->setVariable('emprego.atuacao.value', utf8_encode(strtoupper($atuacao->getDescricao())));
			parent::$templator->setVariable('emprego.atuacao.desc', utf8_encode(strtoupper($atuacao->getDescricao())));

			if( $egresso->getEmprego()->getAtuacaoProfissional() == $atuacao->getDescricao() )
				$temp = 'selected'; 
			else
				$temp =''; 
			parent::$templator->setVariable("emprego.atuacao.selected", utf8_encode($temp)); 
			parent::$templator->addBlock("emprego.atuacao"); 
		}

		//Adicionando redes sociais. 
		foreach( $daoRedeSocial->selectAll() as $rede ){
			parent::$templator->setVariable('egresso.rede_social.value', utf8_encode(strtoupper($rede->getDescricao())));
			parent::$templator->setVariable('egresso.rede_social.desc', utf8_encode(strtoupper($rede->getDescricao())));
			parent::$templator->addBlock("rede_social"); 
		}		
		
		//Criando resumo de tela: 
		parent::$templator->setVariable("egresso.nome", $egresso->getNome()); 
		parent::$templator->setVariable("egresso.email", utf8_encode($egresso->getEmail())); 
		parent::$templator->setVariable("egresso.qtdFilhos",$egresso->getQtdFilhos());
		parent::$templator->setVariable("egresso.telefone", utf8_encode($egresso->getTelefone()));
		parent::$templator->setVariable("egresso.endereco", utf8_encode($egresso->getEndereco()));

		parent::$templator->setVariable("emprego.nome", utf8_encode($egresso->getEmprego()->getNomeEmpresa())); 
		
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
		parent::$templator->setVariable("usuario.email", utf8_encode($usuario->getEmail())); 
		parent::show(); 
	}
}