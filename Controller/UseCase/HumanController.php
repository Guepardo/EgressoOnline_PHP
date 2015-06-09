<?php
namespace Controller\UseCase; 

use Controller\GenericController; 
use View\CustomViews\HumanView; 

class HumanController extends GenericController {
	private $humanView;

	public function __construct() {
		$this->humanView = new HumanView ();
	}

	public function cadastrar($arg) {
		$this->humanView->cadastroView();
	}

	public function login($arg) {
		echo('Entrei na tela de login'); 
		$this->humanView->loginView();
	}

	public function loginAjax($arg) {
		$book = array (
				"title" => "JavaScript: The Definitive Guide",
				"author" => "David Flanagan",
				"edition" => 6 
		);
		
		foreach ( $arg as $key => $a ) {
			$book[$key] = array(1,2,3,4,5,6,4); 
		}
		
		$this->humanView->sendAjax ($book);
	}
}