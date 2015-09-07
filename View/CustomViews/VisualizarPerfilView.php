<?php
require_once(PATH.'View'.DS.'GenericView.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

class VisualizarPerfilView extends GenericView{
	
	public function __construct(){
		parent::__construct($this); 
	}
	
	public function perfilUserView($id){
		parent::getTemplateByAction('perfil'); 
		Lumine::import("Usuario"); 
		Lumine::import("Egresso"); 
		Lumine::import("Turma");
		Lumine::import("Oportunidade");  
		Lumine::import("Curso"); 
		Lumine::import("TituloAcademico"); 

		$egresso = new Egresso(); 
		$usuario = new Usuario(); 

		$usuario->join($egresso)->where("usuario.id = ". $id)->find();
		$usuario->fetch(true);

		//registrando a visita no perfil.
		$usuario->visualizacao++; 
		$usuario->update(); 

		parent::$templator->setVariable('id', $id ); 
		
		parent::$templator->setVariable("nome", $usuario->nome); 
		parent::$templator->setVariable("foto", $usuario->foto); 
		$turma = new Turma(); 
		$turma->get($usuario->turmaId); 

		parent::$templator->setVariable("turma", $turma->ano); 
		parent::$templator->setVariable("foto_turma", $turma->foto); 

		parent::$templator->setVariable("telefone", $usuario->telefone); 

		// parent::$templator->setVariable("likedin", $usuario->nome); 
		// parent::$templator->setVariable("facebook", $usuario->nome); 
		// parent::$templator->setVariable("twitter", $usuario->nome); 

		$oportunidade = new Oportunidade(); 

		$total = $oportunidade->get('usuarioId', $id); 

		parent::$templator->setVariable("qtd", $total); 

		$oportunidade = new Oportunidade(); 
		$oportunidade->where("usuario_id = ". $id)->order("data_divulgacao DESC")->limit(10)->find(); 

		while($oportunidade->fetch()){
			$texto = "Divulgou uma oportunidade no dia ". $oportunidade->dataDivulgacao; 

			parent::$templator->setVariable('texto', $texto ); 
			parent::$templator->addBlock('atividade'); 
		}


		$curso = new Curso(); 
		$titulo = new TituloAcademico(); 

		$curso->join($titulo)->where("usuario_id = ". $id)->find(); 
		while($curso->fetch()){
			$texto = "". $curso->des." na área ". $curso->areaNome.", na instituição ". $curso->instituicao.". concluiu o curso no ano de ". $curso->anoConclusao; 

			parent::$templator->setVariable('tipo', $curso->des ); 
			parent::$templator->setVariable('label', $texto ); 

			parent::$templator->addBlock('graduacao'); 
		}


		parent::show(); 
	}

	public function perfilTurmaView($id){
		parent::getTemplateByAction('perfilTurma'); 
		Lumine::import("Turma"); 
		Lumine::import("Usuario"); 
		Lumine::import("Egresso"); 

		$turma = new Turma(); 
		$egresso = new Egresso(); 
		$usuario = new Usuario(); 

		$turma->get($id); 
		parent::$templator->setVariable("ano_turma", $turma->ano); 
		parent::$templator->setVariable("id_turma", $turma->id);
		parent::$templator->setVariable("foto_turma",Convert::toUTF_8($turma->foto));  
		
		$usuario->join($egresso)->where("egresso.turma_id = ". $turma->id)->find(); 

		while($usuario->fetch()){
			parent::$templator->setVariable("nome", $usuario->nome); 
			parent::$templator->setVariable("id", $usuario->id); 
			parent::$templator->setVariable("foto", $usuario->foto); 
			parent::$templator->addBlock("aluno");
		}

		if(!$_SESSION['coordenador'])
			parent::$templator->setVariable("is_hide", 'hide'); 
		
		parent::show(); 
	}
}