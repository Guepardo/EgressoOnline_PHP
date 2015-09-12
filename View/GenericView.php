<?php
require_once(PATH.'Library'.DS.'MiniTemplator.php'); 

class GenericView {
	protected static $templator;
	private $dirName;

	public function __construct($class) {
		self::$templator = new MiniTemplator ();
		$var = new ReflectionClass ( $class );
		$this->dirName = strtolower ( substr ( $var->getShortName(), 0, strlen ( $var->getShortName() ) - 4 ) ) . DS;
	}

	protected function getTemplateByAction($templateName) {
		self::$templator->readTemplateFromFile (PATH.'templates'.DS. $this->dirName . $templateName . '.html' );
	}

	protected function show() {
		self::$templator->generateOutput();
		exit;
	}

	protected function loadTemplate($path){
		$temp = new MiniTemplator(); 
		$temp->readTemplateFromFile($path); 
		$result; 
		$temp->generateOutputToString($result); 
		return $result;
	}

	public function sendAjax($value){
		 die (json_encode($value));
	}
}