<?php
namespace View; 

use Library\MiniTemplator;

class GenericView {
	protected $templator;
	private $dirName;

	public function __construct($class) {
		$this->templator = new MiniTemplator ();
		$var = new \ReflectionClass ( $class );
		$this->dirName = strtolower ( substr ( $var->getShortName(), 0, strlen ( $var->getShortName() ) - 4 ) ) . DS;
	}

	protected function getTemplateByAction($templateName) {
		$this->templator->readTemplateFromFile (WWW_ROOT.DS.'templates'.DS. $this->dirName . $templateName . '.html' );
	}

	protected function show() {
		echo $this->templator->generateOutput();
	}

	public function sendAjax($value){
		 echo json_encode($value);
		 die;
	}
}