<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class RelatoriosView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function relatorioView(){
		parent::getTemplateByAction('relatorios'); 
		Lumine::import("Turma"); 
		Lumine::import("Oportunidade"); 

		//Pegando anos de conclusão: 
		$turma = new Turma();
		$turma->select('COUNT(*) as contador, ano')->groupBy('ano')->having('COUNT(*) >= 1')->order('ano asc')->find(); 

		while($turma->fetch()){
			parent::$templator->setVariable('ano.conclusao.des', $turma->ano); 
			parent::$templator->addBlock('ano.conclusao'); 
		}

		//Pegando data das postagnes: 
		// $oportunidade = new Oportunidade(); 

		// $oportunidade->select('COUNT(*) as contador, YEAR(data_divulgacao) as data')->groupBy('data')->having('COUNT(*) >= 1')->find(); 

		// while($oportunidade->fetch()){
		// 	parent::$templator->setVariable('ano.postagem.des', $oportunidade->data); 
		// 	parent::$templator->addBlock('ano.postagem');  
		// }

		parent::show(); 
	}

	private function anoConclusaoQuery($var){
		$temp = " "; 


		if(empty($var['ano_conclusao']))
			return " "; 

		if(is_array($var['ano_conclusao'])){
		foreach( $var['ano_conclusao'] as $a )
			$temp .= ' ano_conclusao = '.$a." or "; 
		}else{
			$var = $var['ano_conclusao']; 
			$temp = " ano_conclusao = $var and "; 
		}

		return $temp; 
	}

	//Relatório de distribuição geográfica: 
	public function relatorio1($arg){
		parent::getTemplateByAction('r01'); 
		parent::show(); 
	}

	//Relatório de atuação profissional - faixa salarial 
	public function relatorio2($arg){
		parent::getTemplateByAction('r02'); 
		Lumine::import("FaixaSalarial");
		Lumine::import("Egresso"); 
		Lumine::import("Emprego"); 

		$faixa = new FaixaSalarial(); 

		$faixa->find(); 

		//público ou privado: 
		$publico = (empty($arg['is_publico'])) ? 0 : 1;
		$areaTi  = (empty($arg['is_ti'])) ? 0 : 1;

		while($faixa->fetch()){
			$emprego = new Emprego(); 
			$egresso = new Egresso(); 

			die(" publico = $publico and area_ti = $areaTi and ". self::anoConclusaoQuery($arg) );
			$emprego->join($egresso)->where(" publico = $publico and area_ti = $areaTi and ". self::anoConclusaoQuery($arg['ano_conclusao'])); 
		} 

		parent::show(); 
	}

	//Relatório de distribuição geográfica: 
	public function relatorio3($arg){
		parent::getTemplateByAction('r03'); 
		var_dump($arg); 
		parent::show(); 
	}

	//Relatório de distribuição geográfica: 
	public function relatorio4($arg){
		parent::getTemplateByAction('r04'); 
		parent::show(); 
	}

	//Relatório de distribuição geográfica: 
	public function relatorio5($arg){
		parent::getTemplateByAction('r05'); 
		parent::show(); 
	}

	//Relatório de estatística do site: 
	public function relatorio6($arg){
		parent::getTemplateByAction('r06'); 
		Lumine::import('Turma'); 
		Lumine::import('Egresso'); 

		$turma = new Turma(); 
		$turma->select('COUNT(*) as contador, ano')->groupBy('ano')->having('COUNT(*) >= 1')->order('ano asc')->find(); 

		//Criando hash para para contar
		$contador; 
		foreach( $turma->allToArray() as $value ){
			$contador[$value['ano']]['egresso'] = 0; 
			$contador[$value['ano']]['atualizados'] = 0; 
		}

		$turma = new Turma(); 
		$egresso = new Egresso(); 

		$egresso->select('ano,alterou_dado')->join($turma)->find(); 
		while($egresso->fetch()){
			$contador[$egresso->ano]['egresso']++; 
			if($egresso->alterouDado)
			$contador[$egresso->ano]['atualizados']++; 
		}

		$totalEgresso = 0; 
		$totalAtualizados = 0; 

		foreach($contador as $key => $ano){
			$totalEgresso += $ano['egresso']; 
			$totalAtualizados += $ano['atualizados']; 
			//Fixando valores no template: 
			parent::$templator->setVariable('ano', $key); 
			parent::$templator->setVariable('egresso', $ano['egresso']); 
			parent::$templator->setVariable('atualizados',$ano['atualizados']); 
			parent::$templator->addBlock('row'); 
		}

		parent::$templator->setVariable('total.egresso', $totalEgresso); 
		parent::$templator->setVariable('total.atualizados', $totalAtualizados); 

		parent::show(); 
	}

	//Relatório de distribuição geográfica: 
	public function relatorio7($arg){
		parent::getTemplateByAction('r07'); 
		parent::show(); 
	}

	//Relatório de distribuição geográfica: 
	public function relatorio8($arg){
		parent::getTemplateByAction('r08'); 
		parent::show(); 
	}

}