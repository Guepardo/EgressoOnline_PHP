<?php
namespace Controller; 

use Controller\UseCase\HumanController;  

class MainController {
	private $controllersArray;
	public function __construct() {
		// incluir todos os controllers específicos aqui;       
		$this->controllersArray = array (
				'humanos' => new HumanController () 
		);
	}
	
	public function findMyController() {
		// Passos:
		// 1 O useCase está nas lista de ControllersArray?
		// 2 A action existe no controlador?
		// 3 Invocar método;
		// 4 Gerar output.
		$useCase = $_REQUEST ['usecase'];
		$action  = $_REQUEST ['action'];
		
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
		
		$reflection = new \ReflectionMethod ( $controller->sayMyName (), $realNameMethod );
		return $reflection->invoke ( $controller, self::preparingArray( $_REQUEST ));
	}

	private function preparingArray($target) {
		$array = array_merge ( array (), $target );
		unset ( $array ['action'] );
		unset ( $array ['usecase'] );
		return $array;
	}
	
}