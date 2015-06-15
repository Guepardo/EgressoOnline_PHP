<?php
namespace Model; 

class Usuario{
	static protected $id; 
	static protected $nome;
	static protected $email; 
	static protected $senha; 
	static protected $genero; 
	static protected $cpf; 

	public function __construct($id, $nome, $email, $senha, $genero, $cpf){
		self::$id = $id; 
		self::$nome = $nome;
		self::$email = $email; 
		self::$senha = $senha; 
		self::$genero = $genero; 
		self::$cpf  = $cpf; 
	}

	public function getId(){
		return self::$id; 
	}

	public function getNome(){
		return self::$nome; 
	}

	public function getEmail(){
		return self::$email; 
	}

	public function getSenha(){
		return self::$senha; 
	}

	public function getGenero(){
		return self::$genero; 
	}

	public function getCpf(){
		return self::$cpf; 
	}
}