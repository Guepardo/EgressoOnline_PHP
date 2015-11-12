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
		$temp = "("; 

			if(empty($var['ano_conclusao']))
				return ""; 

			if(is_array($var['ano_conclusao'])){
				foreach( $var['ano_conclusao'] as $a )
					$temp .= ' ano_conclusao = '.$a." or "; 
			}else{
				$var = $var['ano_conclusao']; 
				$temp = " ano_conclusao = $var and "; 
			}

			return substr($temp,0,(strlen($temp)-3)).')'; 
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
	Lumine::import("Turma"); 

	$faixa = new FaixaSalarial(); 

	$faixa->find(); 

		//público ou privado: 
	$publico = (empty($arg['is_publico'])) ? 0 : 1;
	$areaTi  = (empty($arg['is_ti'])) ? 0 : 1;

	$contador = 0; 

	while($faixa->fetch()){
		$emprego = new Emprego(); 
		$egresso = new Egresso(); 
		$turma   = new Turma();

			//die( self::anoConclusaoQuery($arg) );
		$egresso->select("COUNT(*) as count")->join($emprego)->join($turma)->where("$publico = publico and $areaTi = area_ti and faixa_salarial_id = ". (int) $faixa->id." and ". self::anoConclusaoQuery($arg))->find(); 

		$count = (int) $egresso->allToArray()[0]['count']; 


		if( $count > 0 ){
			parent::$templator->setVariable('label', Convert::toUTF_8($faixa->des)); 
			parent::$templator->setVariable('value', $count); 
			parent::$templator->addblock('row'); 

			$contador += $count; 
		}

		parent::$templator->setVariable('total', $contador); 
	} 

	parent::show(); 
}

	//Atuação profissional - tipo atuação
public function relatorio3($arg){
	parent::getTemplateByAction('r03'); 
	Lumine::import("AtuacaoProfissional"); 
	Lumine::import("FaixaSalarial"); 
	Lumine::import("Emprego"); 
	Lumine::import("Turma"); 
	Lumine::import("Egresso"); 

		//público ou privado: 
	$publico = (empty($arg['is_publico'])) ? 0 : 1;


	$egresso = new Egresso(); 
	$emprego = new Emprego(); 
	$turma   = new Turma(); 

	$egresso->select("faixa_salarial_id, atuacao_profissional_id")->join($emprego)->join($turma)->where("$publico = publico and has_emprego = 1 and ". self::anoConclusaoQuery($arg))->find(); 

	$atuacao = new AtuacaoProfissional(); 
	$atuacao->find(); 
 	
 	$total = 0; 

 	$salarioMaior = 0; 
 	$salarioMenor = 0; 

 	$acumuladorMedia = 0; 

	while($atuacao->fetch()){
		$contador= 0;

			$min = 45000;//Maior valor dentro das opções.  
			$max = 0; 

			foreach( $egresso->allToArray() as $value ){
				if( $value['atuacao_profissional_id'] == $atuacao->id ){
					$contador++; 

					$faixaSalarial = new FaixaSalarial(); 

					$faixaSalarial->get($value['faixa_salarial_id']); 

					if($faixaSalarial->minima < $min ) $min = $faixaSalarial->minima; 
					if($faixaSalarial->maxima > $max ) $max = $faixaSalarial->maxima; 

					if($salarioMaior < $max ) $salarioMaior = $max; 
					if($salarioMenor < $min ) $salarioMenor = $min; 
				}
			}

			//fixar elementos aqui: 
			if($contador > 0){
				$total += $contador; 

				parent::$templator->setVariable('label', Convert::toUpperCase($atuacao->des));  
				parent::$templator->setVariable('quantidade', $contador); 
				parent::$templator->setVariable('media', ($min + $max) / 2 ); 
				parent::$templator->setVariable('maior', $max);
				parent::$templator->setVariable('menor', $min); 
				parent::$templator->addBlock('row'); 

				$acumuladorMedia += (($min + $max )  / 2);
			}

		}

		parent::$templator->setVariable('total', $total);
		parent::$templator->setVariable('resumo.media', $acumuladorMedia / $total );
		parent::$templator->setVariable('resumo.maior',$salarioMaior);
		parent::$templator->setVariable('resumo.menor',$salarioMenor); 


		
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
		Lumine::import("TituloAcademico");
		Lumine::import("OpPosGraduacao"); 

		$titulo = new TituloAcademico();
		$titulo->find(); 
		$contador =0; 

		while($titulo->fetch()){
			if($titulo->id == 1 )continue; 

			var_dump($titulo->id); 
			$pos    = new OpPosGraduacao(); 
			$total = $pos->get('tituloAcademicoId', $titulo->id);  

			parent::$templator->setVariable('label',Convert::upperUtf8($titulo->des));
			parent::$templator->setVariable('value',$total );
			parent::$templator->addBlock('row');  

			$contador += $total;  
		}

		parent::$templator->setVariable('total',$contador);
		parent::show(); 
	}

}