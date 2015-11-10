<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'TelaPrincipalView.php'); 
require_once(PATH.'DAO'.DS.'CustomDAOs'.DS.'DAOFeed.php'); 
require_once(PATH.'Util'.DS.'Convert.php'); 

/**
 * Esta classe implementa o caso de uso tela principal.
 */
class TelaPrincipal extends GenericController {
	private $telaPrincipalView; 

	public function __construct() {
		$this->telaPrincipalView = new TelaPrincipalView(); 
	}

	/**
	 * Fachada para o método principalView da classe TelaPrincipalView. Contudo, além da função de fachada, este método identifica é a primeira vez que o usuário está acessando o sistema e o redireciona para uma tela de tutorial da página inicial.
	 * 
	 * @param      <void> 
	 * @return     <void> 
	 */
	/** @BlockList({'visitante'}) */
	public function principalView(){
		Lumine::import("Egresso"); 
		Lumine::import("Usuario"); 
		//Tratando caso especial para tela principal para egresso
		//expor o modal para atualização dos dados somente para ele. 

		if($_SESSION['user']['egresso']){
			if(!isset($_COOKIE['egresso'])){
				$egresso = new Egresso(); 
				$egresso->get('usuarioId', $_SESSION['user_id']); 

				//validade para o bolo é de apenas 30 minutos. 
				setcookie('egresso', (($egresso->alterouDado) ? 1 : 0), time() + 60 * 30, "/");
			}
		}else
			setcookie('egresso', 1, time() + 60 * 30, "/");

		$usuario = new Usuario(); 
		$usuario->get($_SESSION['user_id']); 

		//Se for a primeira vez do usuário no sistema, rodar a tela de 
		//tutorial. 
		if($usuario->primeiraVez){
			$usuario->primeiraVez = false; 
			$usuario->update(); 

			$this->telaPrincipalView->tutorialView();
		}

		$this->telaPrincipalView->principalView(); 
	}

	/**
	 * Fachada para o método tutorialView da classe telaPrincipalView. 
	 *
	 * @param      <void>  
	 * @return     <void> 
	 */
	/** @BlockList({'visitante'}) */
	public function tutorialView(){
		$this->telaPrincipalView->tutorialView(); 
	}

	/**
	 * Retorna as mensagens e oportunidades de emprego e pós-graduação para a tela principal. As mensagens que são privadas são confrontadas com a sessão do usuário corrente, dessa forma só as mensagens que são para ele serão exibidas no feed. 
	 *
	 * @param      <array>  $arg    Recebe um array com a chave date (datetime). Caso data = null, o método irá procurar pelos elementos mais recentes na tabela de oportunidades e mensagens. 
	 * @return     <array(JSON)>    Dentro deste array pode conter duas estruturas JSON: { 'turma' : int, 'id_user_origem' : int, 'foto' : string, 'id', 'rementente' : string, 'data_envio': datatime, 'msg' : string, 'publica' : boolean, 'post': boolean } ou {'graduacao' : int, 'info_adicionais' : string, 'id' : int, 'post' : boolean, 'data_envio' : datetime}
	 */
	/** @BlockList({'visitante'}) */
	public function feed($arg){
		$limit = 10; 

		$daoFeed = new DAOFeed(); 

		if( empty($arg['date']) )
			$arg['date'] = date("Y-m-d H:i:s"); 

		$result = $daoFeed->feed((string) $arg['date'],$limit); 
		
		if(!is_array($result) || count($result) == 0 )
			$this->telaPrincipalView->sendAjax(array('status' => false , 'msg' => 'Não há mais mansagens')); 
		
		//Procurar oportunidades e mensagens a partir do id data; 
		Lumine::import("Postagem"); 
		Lumine::import("Oportunidade"); 
		Lumine::import("UsuarioHasPostagem"); 
		Lumine::import("Usuario"); 
		Lumine::import("Egresso"); 
		Lumine::import("Turma"); 

		Lumine::import("OpPosGraduacao"); 
		Lumine::import("OpEmprego"); 

		$array = array(); 

		do{
			foreach($result as $temp ){
				$post = new Postagem(); 
				$op   = new Oportunidade(); 
				$tam = $post->get('id', (int) $temp[0]);

				//é uma mensagem: 
				if( $tam > 0 && (strcmp($post->dataEnvio, $temp[1] ) == 0 ) ){
					$usuario = new Usuario(); 
					$turma   = new Turma(); 
					$egresso = new Egresso(); 
					$associativa = new UsuarioHasPostagem(); 
					//Pegando a turma do egresso: 
					// $usuario->get('id',$post->usuarioId); 
					$total = $egresso->get($post->usuarioId); 

					$turma->get($egresso->turmaId); 

					// $anoTurma = ($total <= 0)? null : $turma->ano; 
					$semestre; 
					$anoTurma; 
					
					if($total <= 0 ){
						$semestre = null; 
						$anoTurma = null; 
					}else{
						$semestre = $turma->semestre;
						$anoTurma = $turma->ano;  
					}
					//obtendo destinatário; 
					$tam = $associativa->get('postagemId', $post->id); 

					$usuario->get('id', $post->usuarioId); 
					//Se a mensagem é uma mensagem direta: 
					if($tam > 0 && $associativa->postagemId == $post->id){
						if((int) $associativa->usuarioId == (int) $_SESSION['user_id'])//Adicionar no array se a mensagem privada for para a sessão corrente.
							array_push($array, array('turma' => $anoTurma,'semestre' => $semestre,'id_user_origem' => $post->usuarioId, 'foto' => $usuario->foto, 'id' => $post->id, 'remetente' => $usuario->nome, 'data_envio' => $post->dataEnvio , 'msg' => $post->mensagem , 'publica' => false, 'post' => true));  
					}else
					array_push($array, array('turma' => $anoTurma,'semestre' => $semestre, 'id_user_origem' => $post->usuarioId, 'foto' => $usuario->foto, 'id' => $post->id, 'remetente' => $usuario->nome, 'data_envio' => $post->dataEnvio , 'msg' => $post->mensagem , 'publica' => true, 'post' => true)); 
				}

				$tam = $op->get('id', (int) $temp[0]); 

				if( $tam > 0 && (strcmp($op->dataDivulgacao, $temp[1]) == 0 ) ){
					$associativa = new OpPosGraduacao(); 
					$total = 0; 
					$total = $associativa->get('oportunidadeId', (int) $op->id);

					array_push($array, array('graduacao' => ($total > 0 ),'info_adicionais' => $op->infoAdicionais ,'id' => $post->id, 'post' => false, 'data_envio' => $op->dataDivulgacao)); 
				}
			}

			$result = $daoFeed->feed($result[count($result)-1][1],1); 

			if(!$result)
				break; 

		}while( count($array) < $limit && count($result) >= 0 ); 

		$this->telaPrincipalView->sendAjax($array); 
	}
}