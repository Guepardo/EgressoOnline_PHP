<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'ConfigurarView.php'); 

class Configurar extends GenericController {
	private $configurarView; 

	public function __construct() {
		$this->configurarView = new ConfigurarView(); 
	}	

	/**
	 * Fachada para o método configurarView da classe ConfigurarView. 
	 *
	 * @param      <array>  $arg   Ver a entrada deste array na especificação do método da classe ConfigurarView.
	 * @return     <void> 
	 */
	/** @BlockList({'visitante'}) */
	public function configurarView(){
		$this->configurarView->configurarView(); 
	}


	/**
	 * Adiciona uma área de atuação profissinal na lista de interesses de notificação via e-mail do usuário corrente na sessão.
	 *
	 * @param      <array>  $arg    Recebe um array com a chave id (int). O id deve ser correspondente a uma id real de uma área de atuação provissional persistida no banco de dados.
	 * @return     <JSON>   {status :  boolean , msg : string } 
	 */
	/** @BlockList({'visitante'}) */
	public function addArea($arg){
		Lumine::import("Notificacao"); 
		Lumine::import("NotificacaoHasAtuacaoProfissional"); 

		$notificacao = new Notificacao(); 
		$notificacao->get('usuarioId', $_SESSION['user_id']); 

		//Verificando se já está cadastrada: 
		$associativa = new NotificacaoHasAtuacaoProfissional(); 
		$associativa->where("notificacao_id = ". $notificacao->id ." and atuacao_profissional_id = ". $arg['id'])->find(); 
		$total=0; 

		while($associativa->fetch())$total++; 

		if($total > 0)
			$this->configurarView->sendAjax(array('status' => false , 'msg' => 'Essa área de atuacão já foi adicionada.') );

		$associativa = new NotificacaoHasAtuacaoProfissional(); 

		$associativa->notificacaoId         = $notificacao->id; 
		$associativa->atuacaoProfissionalId = (int) $arg['id']; 
		$associativa->insert(); 

		$this->configurarView->sendAjax(array('status' => true ));

	}

    /**
     * Deleta uma área de atuação profissinal na lista de interesses de notificação via e-mail do usuário corrente na sessão.
     *
     * @param      <array>  $arg    Recebe um array com a chave id (int). O id deve ser correspondente a uma id real de uma área de atuação provissional persistida no banco de dados.
     * @return     <void>  
     */
	/** @BlockList({'visitante'}) */
	public function deletarArea($arg){
		Lumine::import("Notificacao"); 
		Lumine::import("NotificacaoHasAtuacaoProfissional"); 

		$notificacao = new Notificacao(); 
		$notificacao->get('usuarioId', $_SESSION['user_id']); 

		$associativa = new NotificacaoHasAtuacaoProfissional(); 
		$associativa->where("notificacao_id = ". $notificacao->id ." and atuacao_profissional_id = ". $arg['id'])->find(); 
		$associativa->fetch(true); 
		$associativa->delete(); 

		$this->configurarView->sendAjax(array('status' => true ));		
	}

	/**
	 * Altera qual é o título de pós-graduação que o usuário deseja ser notificado via e-mail. 
	 *
	 * @param      <array>  $arg    Recebe um array com uma chave id contendo o id do banco de dados correspondente ao título de pós-graduação a ser alterado.
	 * @return <void>
	 */
	/** @BlockList({'visitante'}) */
	public function mudarTitulo($arg){
		Lumine::import("Notificacao"); 
		$notificacao = new Notificacao(); 
		$notificacao->get('usuarioId', $_SESSION['user_id']); 

		if( 0 !== (int) $arg['id'])
		$notificacao->tituloAcademicoId = (int) $arg['id']; 
		else
		$notificacao->tituloAcademicoId = null; 
	
		$notificacao->update(); 

		$this->configurarView->sendAjax(array('status' => true ));
	}

}