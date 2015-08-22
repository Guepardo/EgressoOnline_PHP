<?php
require_once(PATH.'Controller'.DS.'UseCase'.DS.'HumanController.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'ManterUsuario.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'AjaxServices.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'Autenticar.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'TelaPrincipal.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'DivulgarOportunidade.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'VisualizarOportunidade.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'VisualizarPerfil.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'Configurar.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'ManterCurso.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'Mensagens.php'); 

class MainController {
	private $controllersArray;
	public function __construct() {
		// incluir todos os controllers específicos aqui;       
		$this->controllersArray = array (
				'humanos'       => new HumanController (),
				'manterUsuario' => new ManterUsuario(),
				'telaPrincipal' => new TelaPrincipal(),
				'ajaxServices'  => new AjaxServices(), 
				'autenticar'    => new Autenticar(),
				'divulgar'      => new DivulgarOportunidade(), 
				'visualizar'	=> new VisualizarOportunidade(), 
				'configurar'    => new Configurar(), 
				'manterCurso'   => new ManterCurso(), 
				'mensagens'     => new Mensagens(), 
				'perfil'        => new VisualizarPerfil()
 		);
	}
	
	public function findMyController() {
		// Passos:
		// 1 O useCase está nas lista de ControllersArray?
		// 2 A action existe no controlador?
		// 3 Invocar método;
		// 4 Gerar output.
		$useCase = $_REQUEST ['uc'];
		$action  = $_REQUEST ['a'];
		
		// if( $this->$controllersArray[$useCase] == null ) return;
		$controller = $this->controllersArray [$useCase];
		$realNameMethod = '';
		
		$arrayMethods = $controller->sayMyActions();
		
		foreach ( $arrayMethods as $a ) {
			if (strcasecmp ( $a, $action ) == 0) {
				$realNameMethod = $a;
				break;
			}
		}
		
		if (strlen ( $realNameMethod ) == 0) {
			die('Não há ação para ser executada');
		}
		
		$reflection = new ReflectionMethod ( $controller->sayMyName (), $realNameMethod );
		return $reflection->invoke ( $controller, self::preparingArray( $_REQUEST ));
	}

	private function preparingArray($target) {
		$array = array_merge ( array (), $target );
		unset ( $array ['a'] );
		unset ( $array ['uc'] );
		return $array;
	}
	
}