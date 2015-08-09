<?php
require_once(PATH.'Controller'.DS.'GenericController.php'); 
require_once(PATH.'View'.DS.'CustomViews'.DS.'HumanView.php'); 



class HumanController extends GenericController {
	private $humanView;

	public function __construct() {
		$this->humanView = new HumanView ();
	}

	public function cadastrar($arg) {
		$this->humanView->cadastroView();
	}

	public function login($arg) {
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
		
		$this->humanView->sendAjax($book);
	}
}