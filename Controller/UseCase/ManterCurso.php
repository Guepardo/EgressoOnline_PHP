<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'ManterCursoView.php'); 

class ManterCurso extends GenericController {
	private $manterCursoView; 

	public function __construct() {
		$this->manterCursoView = new ManterCursoView(); 
	}	

	public function novaAreaView(){
		$this->manterCursoView->novaAreaView(); 
	}

	public function novaDisciplinaView(){
		$this->manterCursoView->novaDisciplinaView(); 
	}

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

	public function alterarArea($arg){
		Lumine::import("AtuacaoProfissional"); 
		$atuacao  = new AtuacaoProfissional(); 

		$atuacao->get((int) $arg['id'] ); 
		$atuacao->des = $arg['nome']; 
		$atuacao->update(); 

		$this->manterCursoView->sendAjax(array('status' => true ) );
	}


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


	public function alterarDisciplina($arg){
		Lumine::import("Disciplina"); 
		$disciplina  = new Disciplina(); 

		$disciplina->get((int) $arg['id'] ); 
		$disciplina->des = $arg['nome']; 
		$disciplina->update(); 

		$this->manterCursoView->sendAjax(array('status' => true ) );
	}


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