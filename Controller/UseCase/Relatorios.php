<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'RelatoriosView.php'); 


class Relatorios extends GenericController {
	private $relatoriosView; 

	public function __construct() {
		$this->relatoriosView = new RelatoriosView(); 
	}	

	public function relatorioView(){
		$this->relatoriosView->relatorioView(); 
	}

	public function relatorio($arg){
		$qual = (int) $arg['cod']; 

		switch($qual){
			case 1://Distribuição geográfica: 
			$this->relatoriosView->relatorio1($arg);
			break; 
			case 2:
			$this->relatoriosView->relatorio2($arg);
			break; 
			case 3:
			$this->relatoriosView->relatorio3($arg);
			break; 
			case 4:
			$this->relatoriosView->relatorio4($arg);
			break; 
			case 5:
			$this->relatoriosView->relatorio5($arg);
			break; 
			case 6:
			$this->relatoriosView->relatorio6($arg);
			break; 
			case 7:
			$this->relatoriosView->relatorio7($arg);
			break; 
			case 8:
			$this->relatoriosView->relatorio8($arg);
			break; 
			default:
			die("Esse formulário não existe"); 
		}
	}

}