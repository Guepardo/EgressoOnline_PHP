<?php  
namespace DAO\CustomDAOs; 

use DAO\DAOBehavior; 

use Model\Usuario; 

class DAOUsuario extends DAOBehavior{

	public function __construct(){
		parent::__construct(); 
	}

	public function emailExists($email){
		$sql = "SELECT * from usuario where e_mail = '$email' "; 
		$verification = false; 

		try{
			$result = mysqli_query(parent::$connection,$sql);

			if($result == false ) return $verification;

			while($consulta = mysqli_fetch_array($result)){
				$verification = true; 
				break; 
			} 

		}catch( \Exception $e){}

		return $verification; 
	}

	public function cpfExists($cpf){
		$sql = "SELECT * from usuario where cpf = '$cpf'"; 
		$verification = false; 

		try{
			$result = mysqli_query(parent::$connection,$sql);

			if($result == false ) return $verification;
			
			while($consulta = mysqli_fetch_array($result)){
				$verification = true; 
				break; 
			} 

		}catch( \Exception $e){}

		return $verification; 
	}

	public function alterarSenha($element, $newPassword){
		$sql = "UPDATE USUARIO SET senha ='$newPassword' WHERE senha = '".$element->getSenha()."' and idusuario = ". $element->getId(); 
		
		try{
			mysqli_query(parent::$connection,$sql);
		}catch( \Exception $e){}

		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Nada alterado"; 
		else
			return ""; 
	
	}

	public function insert( $element ){}
	public function delete( $pk ){}

	public function select ( $id ){
		$sql = "SELECT * FROM USUARIO WHERE  idusuario = $id "; 
		
		try{
			$result = mysqli_query(parent::$connection,$sql);

			while($consulta = mysqli_fetch_array($result)) { 
		   		$usuario = new Usuario($consulta['idusuario'], $consulta['nome'], $consulta['e_mail'], $consulta['senha'], $consulta['idgenero_fk'], $consulta['cpf']); 
			} 			
		}catch( \Exception $e){}

		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Nada encontrado com essa id"; 
		else
			return $usuario; 
	}

	public function update ($element){
		$sql = "UPDATE USUARIO SET nome ='".$element->getNome()."',e_mail ='".$element->getEmail()."' WHERE idusuario = ". $element->getId(); 

		try{
			mysqli_query(parent::$connection,$sql);
		}catch( \Exception $e){}

		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Nada alterado"; 
		else
			return ""; 
	}
}