<?php

class BDConnectionFactory {
	const BANCO = DB_DATABASE;
	const USUARIO = DB_USER;
	const SENHA = DB_PASSWORD;
	const HOSTNAME = DB_HOST;
	const PORT = DB_PORT;
	
	private $connection;
	private static $instance = null;
	
	public function __construct() {
		self::connect ();
	}
	
	public static function getInstance() {
		if (self::$instance == null)
			return self::$instance = new BDConnectionFactory();
		else 
			return self::$instance; 
	}
	
	private function connect() {
		$this->connection = mysqli_connect(self::HOSTNAME, self::USUARIO, self::SENHA, self::BANCO, self::PORT, null ) or die('falha de banco de dados');
	}
	
	public function getConnection(){
		return $this->connection; 
	}
}
