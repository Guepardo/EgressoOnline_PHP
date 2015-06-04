<?php
class DataTransfer {
	private $useCase;
	private $action;
	private $data;
	public function __construct($useCase, $action, $data) {
		self::$useCase = $useCase;
		self::$action = $action;
		self::$data = $data;
	}
}