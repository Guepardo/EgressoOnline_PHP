<?php 
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class ManterUsuarioView extends GenericView{
	public function __construct(){
		parent::__construct($this); 
	}

	public function cadastroProfessorView(){
		parent::getTemplateByAction("cadastroProfessor"); 
		parent::show(); 
	}

	public function alterarFotoView(){
		parent::getTemplateByAction("alterarFoto"); 
		parent::show(); 
	}

	public function gerenciarCpView(){
		parent::getTemplateByAction("gerenciarCursos");

		Lumine::import('TituloAcademico'); 
		$tituloAcademico = new TituloAcademico(); 
		$tituloAcademico->find(); 

		while($tituloAcademico->fetch()){
			parent::$templator->setVariable("tipo.id", $tituloAcademico->id ); 
			parent::$templator->setVariable("tipo.des", $tituloAcademico->des );
			parent::$templator->addBlock("tipo");
		}

	    //Anexar curso do usuário corrente

		Lumine::import("Curso"); 
		Lumine::import("TituloAcademico"); 
		$curso = new Curso(); 
		$titulo = new TituloAcademico(); 

		$curso->where("usuario_id = ". $_SESSION['user_id'])->find(); 

		while($curso->fetch()){
			parent::$templator->setVariable("id", $curso->id ); 
			$titulo = new TituloAcademico(); 
			$titulo->get($curso->tituloAcademicoId); 
			parent::$templator->setVariable("tipo", $titulo->des );
			parent::$templator->setVariable("instituicao", $curso->instituicao ); 
			parent::$templator->setVariable("nome_curso", $curso->areaNome );
			parent::$templator->setVariable("ano_conclusao", $curso->anoConclusao );
			parent::$templator->addBlock("row");
		}

		parent::show(); 
	}

	public function cadastroEgressoView(){
		parent::getTemplateByAction("cadastroEgresso"); 
		parent::show(); 
	}

	public function addDisciplinaView(){
		parent::getTemplateByAction("adicionarDisciplinas");
		Lumine::import("Professor"); 
		Lumine::import("ProfessorHasDisciplina"); 
		Lumine::import("Disciplina"); 

		$professor = new Professor(); 
		$associativa = new ProfessorHasDisciplina(); 
		$disciplina = new Disciplina(); 

		//Adicionando as matérias do bd no dropdown
		$disciplina->find(); 

		while( $disciplina->fetch() ){
			parent::$templator->setVariable('disciplina.descri', utf8_encode($disciplina->des)); 
			parent::$templator->setVariable('disciplina.id', $disciplina->id);  
			parent::$templator->addBlock('disciplinas'); 
		}

		$associativa->where("professor_usuario_id = ". $_SESSION['user_id'])->find(); 

		while( $associativa->fetch() ){
			$disciplina = new Disciplina(); 
			$disciplina->get($associativa->disciplinaId); 

			parent::$templator->setVariable('disciplina.name', utf8_encode($disciplina->des)); 
			parent::$templator->setVariable('associativa.id', $associativa->id); 
			parent::$templator->setVariable('disciplina.ano_lecionou',$associativa->anoLecionou);
			parent::$templator->addBlock('table'); 
		}
		parent::show(); 
	}

	public function alterarSenhaView(){
		parent::getTemplateByAction("alterarSenha"); 
		parent::show(); 
	}

	public function alterarDadosProfessorView(){
		parent::getTemplateByAction("alterarDadosProfessor"); 
		Lumine::import("Usuario"); 
		Lumine::import("Professor"); 

		$professor = new Professor(); 
		$usuario = new Usuario(); 

		$professor->join($usuario)->where(" usuario_id = ". $_SESSION['user_id'])->find(); 
		$professor->fetch(true); 

		parent::$templator->setVariable("usuario.email", $professor->email); 
		parent::$templator->setVariable("usuario.nome", $professor->nome);

		parent::show(); 
	}

	public function alterarDadosView(){
		parent::getTemplateByAction("alterarDados"); 
		Lumine::import("Usuario");
		Lumine::import("Egresso"); 
		Lumine::import("FaixaSalarial"); 
		Lumine::import("AtuacaoProfissional");
		Lumine::import("Emprego"); 
		Lumine::import("Localidade"); 
		Lumine::import("EstadoCivil"); 
		Lumine::import("EgressoHasRedeSocial"); 
		Lumine::import("RedeSocial"); 

		Lumine::import("Pais"); 
		Lumine::import("Estado"); 
		Lumine::import("Cidade"); 

		$usuario = new Usuario(); 
		$egresso = new Egresso(); 

		$egresso->join($usuario)->where('usuario_id = '. $_SESSION['user_id'])->find(); 
		$egresso->fetch(true); 

		//resgatanto emprego do gresso: 
		$emprego = new Emprego(); 
		$emprego->get($egresso->empregoId); 

		//resgatando localidade do emprego do egresso
		$localidadeEmprego = new Localidade(); 
		$localidadeEmprego->get($emprego->localidadeId); 


		//resgatando localidade do egresso
		$localidadeEgresso = new Localidade(); 
		$localidadeEgresso->get($egresso->localidadeId); 

		//---------Fixando Pais, Estados e cidades:----------- 
		$pais = new Pais(); 
		$pais->find(); 

		//pais egresso; 
		while($pais->fetch()){
			parent::$templator->setVariable('egresso.pais.value',$pais->id); 
			parent::$templator->setVariable('egresso.pais.desc', Convert::toUTF_8(Convert::toUpperCase($pais->des))); 

			if( (int) $pais->id == (int) $localidadeEgresso->paisId)
				parent::$templator->setVariable('egresso.pais.marcado','selected'); 
			else
				parent::$templator->setVariable('egresso.pais.marcado','');

			parent::$templator->addBlock('egresso.pais');
		}

		$cidade = new Cidade(); 
		$total = $cidade->get($localidadeEgresso->cidadeId); 
		$idEstado; 

		if($total > 0)
			$idEstado = $cidade->estadoId; 
		else
			$idEstado = -1; //Caso não houver uma cidade, adicione -1 para informar que não há. 


		$estado = new Estado(); 
		$estado->find(); 

		while($estado->fetch()){
			parent::$templator->setVariable('egresso.estado.value',$estado->id); 
			parent::$templator->setVariable('egresso.estado.desc', Convert::toUTF_8(Convert::toUpperCase($estado->des))); 
			if($idEstado == $estado->id)
				parent::$templator->setVariable('egresso.estado.marcado','selected'); 
			else
				parent::$templator->setVariable('egresso.estado.marcado','');

			parent::$templator->addBlock('egresso.estado');
		}

		if($idEstado != -1 ){
			$idCidade = $cidade->id; 

			$cidade = new Cidade(); 
			$cidade->where("estado_id = ". $idEstado)->find(); 

			while($cidade->fetch()){
				parent::$templator->setVariable('egresso.cidade.value',$cidade->id); 
				parent::$templator->setVariable('egresso.cidade.desc', Convert::toUTF_8(Convert::toUpperCase($cidade->des))); 
				if($idCidade == $cidade->id)
					parent::$templator->setVariable('egresso.cidade.marcado','selected'); 
				else
					parent::$templator->setVariable('egresso.cidade.marcado','');

				parent::$templator->addBlock('egresso.cidade');
			}
		}
		//pais emprego;
		$pais = new Pais(); 
		$pais->find(); 

		while($pais->fetch()){
			parent::$templator->setVariable('emprego.pais.value',$pais->id); 
			parent::$templator->setVariable('emprego.pais.desc', Convert::toUTF_8(Convert::toUpperCase($pais->des))); 

			if( (int) $pais->id == (int) $localidadeEmprego->paisId)
				parent::$templator->setVariable('emprego.pais.marcado','selected'); 
			else
				parent::$templator->setVariable('emprego.pais.marcado','');

			parent::$templator->addBlock('emprego.pais');
		}

		$cidade = new Cidade(); 
		$total = $cidade->get($localidadeEmprego->cidadeId); 
		$idEstado; 

		if($total > 0)
			$idEstado = $cidade->estadoId; 
		else
			$idEstado = -1; //Caso não houver uma cidade, adicione -1 para informar que não há. 


		$estado = new Estado(); 
		$estado->find(); 

		while($estado->fetch()){
			parent::$templator->setVariable('emprego.estado.value',$estado->id); 
			parent::$templator->setVariable('emprego.estado.desc', Convert::toUTF_8(Convert::toUpperCase($estado->des))); 
			if($idEstado == $estado->id)
				parent::$templator->setVariable('emprego.estado.marcado','selected'); 
			else
				parent::$templator->setVariable('emprego.estado.marcado','');

			parent::$templator->addBlock('emprego.estado');
		}

		if($idEstado != -1 ){
			$idCidade = $cidade->id; 

			$cidade = new Cidade(); 
			$cidade->where("estado_id = ". $idEstado)->find(); 

			while($cidade->fetch()){
				parent::$templator->setVariable('emprego.cidade.value',$cidade->id); 
				parent::$templator->setVariable('emprego.cidade.desc', Convert::toUTF_8(Convert::toUpperCase($cidade->des))); 
				if($idCidade == $cidade->id)
					parent::$templator->setVariable('emprego.cidade.marcado','selected'); 
				else
					parent::$templator->setVariable('emprego.cidade.marcado','');

				parent::$templator->addBlock('emprego.cidade');
			}
		}
		//Resgatando atuação, faixas salariais e estado civil:
		$civil = new EstadoCivil(); 
		$civil->find(); 

		while($civil->fetch()){
			parent::$templator->setVariable('civil.value',$civil->id); 
			parent::$templator->setVariable('civil.desc', Convert::toUTF_8(Convert::toUpperCase($civil->des))); 

			if( (int) $civil->id == (int) $egresso->estadoCivilId)
				parent::$templator->setVariable('civil.marcado','selected'); 
			else
				parent::$templator->setVariable('civil.marcado','');

			parent::$templator->addBlock('civil');
		} 


		$faixa = new FaixaSalarial(); 
		$faixa->find(); 

		while($faixa->fetch()){
			parent::$templator->setVariable('faixa.value',$faixa->id); 
			parent::$templator->setVariable('faixa.desc', Convert::toUTF_8(Convert::toUpperCase($faixa->des))); 

			if( (int) $faixa->id == (int) $emprego->faixaSalarialId)
				parent::$templator->setVariable('faixa.marcado','selected'); 
			else
				parent::$templator->setVariable('faixa.marcado','');
			parent::$templator->addBlock('faixa');
		}

		$atuacao = new AtuacaoProfissional(); 
		$atuacao->find(); 

		while($atuacao->fetch()){
			parent::$templator->setVariable('atuacao.value',$atuacao->id); 
			parent::$templator->setVariable('atuacao.desc', Convert::toUTF_8(Convert::toUpperCase($atuacao->des))); 

			if((int) $atuacao->id == (int) $emprego->atuacaoProfissionalId)
				parent::$templator->setVariable('atuacao.marcado','selected'); 
			else
				parent::$templator->setVariable('atuacao.marcado',''); 

			parent::$templator->addBlock('atuacao');
		}

		//Adicionando valor aos campos fixos: 
		parent::$templator->setVariable('egresso.nome',$egresso->nome);
		parent::$templator->setVariable('egresso.email',$egresso->email);
		parent::$templator->setVariable('egresso.qtdFilhos',$egresso->qtdFilhos);
		parent::$templator->setVariable('egresso.telefone',$egresso->telefone); 
		parent::$templator->setVariable('egresso.endereco',$egresso->endereco);
		parent::$templator->setVariable('egresso.complemento',$localidadeEgresso->complemento);
		parent::$templator->setVariable('is_publica',(($emprego->publico)? "checked" : "" ) );
		parent::$templator->setVariable('is_area_ti',(($emprego->areaTi)? "checked" : "" ));
		parent::$templator->setVariable('emprego.nome',$emprego->nomeEmpresa);
		parent::$templator->setVariable('emprego.complemento',$localidadeEmprego->complemento);
		parent::$templator->setVariable('egresso.dados_publico',(($egresso->isDadoPublico)? "checked" : "" ));

		//Resgatando dados das Redes Sociais: 
		$redes = new EgressoHasRedeSocial(); 

		$redes->where("usuario_id = ". $_SESSION['user_id'])->find(); 

		while($redes->fetch()){
			switch($redes->redeSocialId){
				case 1: 
					parent::$templator->setVariable('twitter',$redes->linkAcesso);
				break;
				case 2: 
					parent::$templator->setVariable('linkedin',$redes->linkAcesso);
				break;
				case 3: 
					parent::$templator->setVariable('facebook',$redes->linkAcesso);
				break;
			}
		}
		parent::show(); 
	}
}