<?php
namespace Util; 

class BDConnectionFactory {
	const BANCO = "test";
	const USUARIO = "root";
	const SENHA = "";
	const HOSTNAME = "localhost";
	const PORT = 3306;
	
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
		$this->connection = mysqli_connect(self::HOSTNAME, self::USUARIO, self::SENHA, self::BANCO, self::PORT, null );
		if (! $this->connection) {
			echo "Não foi possível conectar ao banco MySQL.";
			exit ();
		} else {
			echo "Parabéns!! A conexão ao banco de dados ocorreu normalmente!.";
		}
	}
	
	public function getConnection(){
		return $this->connection; 
	}
}
