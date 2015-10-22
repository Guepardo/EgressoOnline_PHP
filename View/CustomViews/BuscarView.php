<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class BuscarView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function buscaView($arg){
		parent::getTemplateByAction('busca'); 
		Lumine::import("Usuario"); 
		Lumine::import("Egresso"); 
		Lumine::import("Professor"); 
		Lumine::import("Turma"); 

		//Se for inteiro, procurar por classes
		//Se for string, procurar por nomes relacionados
		$arg = $arg['arg']; 

		parent::$templator->setVariable("arg", $arg); 

		if(is_numeric($arg)){
			$arg = (int) $arg; 

			$usuario = new Usuario(); 
			$turma   = new Turma(); 
			$egresso = new Egresso(); 

			$egresso->select("usuario.id as id, usuario.foto as foto, nome, turma.ano as ano, turma.semestre as semestre")->join($usuario)->join( $turma)->where("ano = ". $arg )->find(); 

			while($egresso->fetch()){
				parent::$templator->setVariable("usuario.id", $egresso->id); 
				parent::$templator->setVariable("usuario.nome", $egresso->nome); 

				$result = self::whoIsUser($egresso->id); 

				if(count($result) > 1){//é um aluno
					parent::$templator->setVariable("usuario.tipo", $result[0]); 
					parent::$templator->setVariable("usuario.turma", $result[1].'-'.$result[3]); 
					parent::$templator->setVariable("turma.id",'index.php?uc=perfil&a=perfilTurmaView&id='.$result[2]); 
				}else{
					parent::$templator->setVariable("usuario.tipo", $result[0]); 
					parent::$templator->setVariable("usuario.turma", "X"); 
				}
				
				parent::$templator->setVariable("usuario.foto", $egresso->foto); 

				parent::$templator->addBlock('row'); 
			} 
		}else{
			$arg = strtoupper($arg); 

			$usuario   = new Usuario(); 
			$professor = new Professor(); 
			$turma     = new Turma(); 

			$usuario->where("UPPER(nome) like '".$arg."%'")->find(); 

			while($usuario->fetch()){
				parent::$templator->setVariable("usuario.id", $usuario->id); 
				parent::$templator->setVariable("usuario.nome", $usuario->nome); 

				$result = self::whoIsUser($usuario->id); 

				if(count($result) > 1){//é um aluno
					parent::$templator->setVariable("usuario.tipo", $result[0]); 
					parent::$templator->setVariable("usuario.turma", $result[1].'-'.$result[3]); 
					parent::$templator->setVariable("turma.id",'index.php?uc=perfil&a=perfilTurmaView&id='.$result[2]); 
				}else{
					parent::$templator->setVariable("usuario.tipo", $result[0]); 
					parent::$templator->setVariable("usuario.turma", "X"); 
				}
				
				parent::$templator->setVariable("usuario.foto", $usuario->foto); 

				parent::$templator->addBlock('row'); 
			} 
		}
		
		parent::show(); 
	}

	private function whoIsUser($id){
		Lumine::import("Egresso"); 
		Lumine::import("Professor"); 
		$result = array(); 

		$egresso = new Egresso(); 
		$total = $egresso->get($id);

		//Se é um egresso, devo saber qual é o ano da turma. 
		if($total > 0){
			Lumine::import("Turma"); 
			array_push($result,"Egresso"); 
			$turma = new Turma(); 
			$turma->get($egresso->turmaId); 

			array_push($result,$turma->ano); 
			array_push($result,$turma->id); 
			array_push($result,$turma->semestre); 
			return $result; 
		} 

		$professor = new Professor(); 
		$total = $professor->get($id); 

		//Se for um professor, veja se ele é um coordenador; 
		if($total > 0 ){
			$temp = (!$professor->isCoordenador) ? "Professor" : "Coordenador"; 
			array_push($result,$temp);
			return $result;  
		}

		return null;
	}
}