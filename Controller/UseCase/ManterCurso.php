<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'ManterCursoView.php'); 

class ManterCurso extends GenericController {
	private $manterCursoView; 

	public function __construct() {
		$this->manterCursoView = new ManterCursoView(); 
	}	

	/** @BlockList({'visitante','professor','egresso'}) */
	public function novaAreaView(){
		$this->manterCursoView->novaAreaView(); 
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function novaDisciplinaView(){
		$this->manterCursoView->novaDisciplinaView(); 
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function transferirView(){
		$this->manterCursoView->transferirView(); 
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function transCoordenador($arg){
		lumine::import("Usuario"); 
		Lumine::import("Professor"); 	
		$id = $arg['id']; 

		$novo = new Usuario(); 

		$total = $novo->get($id); 

		if($total <= 0 )
			$this->manterCursoView->sendAjax(array('status' => false, 'msg' => 'Falha. Tente atualizar a página.')); 

		$velho = new Usuario(); 

		$total = $velho->get($_SESSION['user_id']); 

		if($total <= 0 )
			$this->manterCursoView->sendAjax(array('status' => false, 'msg' => 'Falha. Tente atualizar a página.')); 

		//Modificando privilégios: 
		
		$professor = new Professor(); 
		$professor->get('usuarioId', $novo->id); 
		$professor->isCoordenador = 1; 
		$professor->update(); 

		$professor = new Professor(); 
		$professor->get("usuarioId", $velho->id); 
		$professor->isCoordenador = 0; 
		$professor->update(); 

		$this->manterCursoView->sendAjax(array('status' => true)); 
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function deletarArea($arg){
		Lumine::import('AtuacaoProfissional'); 
		Lumine::import('Emprego'); 
		Lumine::import('OpEmprego'); 
		Lumine::import('NotificacaoHasAtuacaoProfissional');
		$total = 0; 

		$emprego   = new Emprego(); 
		$opEmprego = new OpEmprego(); 
		$notifica  = new NotificacaoHasAtuacaoProfissional(); 

		$total += $emprego->get('atuacaoProfissionalId', (int) $arg['id']); 
		$total += $opEmprego->get('atuacaoProfissionalId', (int) $arg['id']); 
		$total += $notifica->get('atuacaoProfissionalId', (int) $arg['id']); 

		if($total == 0){
			$area = new AtuacaoProfissional(); 
			$area->get((int) $arg['id']); 
			$area->delete(); 
			$this->manterCursoView->sendAjax(array('status' => true ) );
		}

		$this->manterCursoView->sendAjax(array('status' => false , 'msg' => 'há '. $total.' registro(s) vinculado(s) nessa Área de Atuação. Não é possivel apagar.') );
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function alterarArea($arg){
		Lumine::import("AtuacaoProfissional"); 
		$atuacao  = new AtuacaoProfissional(); 

		$atuacao->get((int) $arg['id'] ); 
		$atuacao->des = $arg['nome']; 
		$atuacao->update(); 

		$this->manterCursoView->sendAjax(array('status' => true ) );
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function novaArea($arg){
		Lumine::import("AtuacaoProfissional"); 
		$atuacao  = new AtuacaoProfissional(); 

		$total = $atuacao->get('des', $arg['nome']); 

		$atuacao  = new AtuacaoProfissional();
		if($total == 0 ){
			$atuacao->des = $arg['nome']; 
			$atuacao->insert(); 
		}else{
			$this->manterCursoView->sendAjax(array('status' => false , 'msg' => 'Há uma área de atuação com esse nome no sistema') );
		}

		$this->manterCursoView->sendAjax(array('status' => true ) );
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function novaDisciplina($arg){
		Lumine::import("Disciplina"); 
		$disciplina  = new Disciplina(); 

		$total = $disciplina->get('des', $arg['nome']); 

		$disciplina  = new Disciplina();
		if($total == 0 ){
			$disciplina->des = $arg['nome']; 
			$disciplina->insert(); 
		}else{
			$this->manterCursoView->sendAjax(array('status' => false , 'msg' => 'Há uma disciplina com esse nome no sistema') );
		}

		$this->manterCursoView->sendAjax(array('status' => true ) );
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function alterarDisciplina($arg){
		Lumine::import("Disciplina"); 
		$disciplina  = new Disciplina(); 

		$disciplina->get((int) $arg['id'] ); 
		$disciplina->des = $arg['nome']; 
		$disciplina->update(); 

		$this->manterCursoView->sendAjax(array('status' => true ) );
	}

	/** @BlockList({'visitante','professor','egresso'}) */
	public function deletarDisciplina($arg){
		Lumine::import("ProfessorHasDisciplina"); 
		Lumine::import("Disciplina"); 

		$associativa = new ProfessorHasDisciplina(); 
		$total = 0; 

		$total += $associativa->get('disciplinaId', (int) $arg['id']); 

		if($total == 0){
			$disciplina = new Disciplina(); 
			$disciplina->get((int) $arg['id']); 
			$disciplina->delete(); 
			$this->manterCursoView->sendAjax(array('status' => true ) );
		}

		$this->manterCursoView->sendAjax(array('status' => false , 'msg' => 'há '. $total.' registro(s) vinculado(s) nessa disciplina. Não é possivel apagar.') );

	}
}