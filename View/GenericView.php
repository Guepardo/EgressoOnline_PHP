<?php
namespace View; 

use Library\MiniTemplator;

class GenericView {
	protected static $templator;
	private $dirName;

	public function __construct($class) {
		self::$templator = new MiniTemplator ();
		$var = new \ReflectionClass ( $class );
		$this->dirName = strtolower ( substr ( $var->getShortName(), 0, strlen ( $var->getShortName() ) - 4 ) ) . DS;
	}

	protected function getTemplateByAction($templateName) {
		self::$templator->readTemplateFromFile (WWW_ROOT.DS.'templates'.DS. $this->dirName . $templateName . '.html' );
	}

	protected function show() {
		self::$templator->generateOutput();
	}

	public function sendAjax($value){
		 die (json_encode($value));
	}
}