<?php  
namespace DAO\CustomDAOs; 

use DAO\CustomDAOs\DAOUsuario; 
use DAO\CustomDAOs\DAOLocalidade; 
use DAO\CustomDAOs\DAOEmprego; 

use Model\Egresso; 
use Model\Localidade; 

class DAOEgresso extends DAOUsuario {
	
	public function __construct(){
		parent::__construct(); 
	}

	public function insert( $element ){
		//Verificando se cpf e e-mail já foram cadastrados: 
		if(parent::emailExists($element->getEmail()))
			return "Esse email já foi cadastrado"; 
		if(parent::cpfExists($element->getCpf()))
			return "Esse CPF já foi cadastrado"; 

		$daoLocalidade = new DAOLocalidade(); 
		$daoEmprego    = new DAOEmprego(); 

		//Ordem nas inserções: 
		//Criar usuario, egresso, localidade e emprego 

		//Inserindo usuario
		$idUsuario = parent::insert($element);
		if( !is_int($idUsuario) )
			return $idUsuario; 

		//Inserindo localidade para o egresso (VAZIA)
		$idLocalidade = $daoLocalidade->insert(); 
		if( !is_int($idLocalidade) )
			return $idLocalidade; //retorna a mensagem de erro do DAO acima. 

		//Inserindo emprego (VAZIA)
		$idEmprego = $daoEmprego->insert(); 
		if( !is_int($idEmprego) )
			return $idEmprego; 

		//Inserindo Egresso
		$sql = "INSERT INTO EGRESSO (idusuario_fk, ano_ingresso, ano_conclusao, is_dado_publico, idlocalidade_fk, idemprego_fk) VALUES (". $idUsuario .",". $element->getAnoIngresso().",".$element->getAnoConclusao().",". $element->isDadoPublico() .", $idLocalidade, $idEmprego)"; 
		try{
			mysqli_query(parent::$connection,$sql);
		}catch( \Exception $e){}

		return mysqli_error(parent::$connection); 
	}
	
	public function delete( $pk ){
		
	}
	
	public function select ( $pk ){
		//Pegar a id do usuario; 
		//Pegar o Egresso; 
		//Pegar a localidade; 
		//Pegar o emprego ;

		$usuario = parent::select($pk); 
		if( is_string($usuario) )
			return $usuario; //Retorna a mensagem de erro do parent::select; 

		var_dump($usuario); 

		$egresso = new Egresso($usuario->getId(), $usuario->getNome(), $usuario->getEmail(), $usuario->getSenha(), $usuario->getGenero(), $usuario->getCpf() ); 

		$sql = "SELECT * FROM EGRESSO WHERE  idusuario_fk = ". $usuario->getId(); 
		try{
			$result = mysqli_query(parent::$connection,$sql);
			while($consulta = mysqli_fetch_array($result)) { 
		   		$egresso->setTelefone($consulta['telefone']); 
		   		$egresso->setAnoIngresso( (int) $consulta['ano_ingresso']); 
		   		$egresso->setAnoConclusao( (int) $consulta['ano_conclusao']); 
		   		$egresso->setEndereco($consulta['endereco']); 
		   		$egresso->setDadoPublico( (boolean) $consulta['is_dado_publico']); 
		   		$idLocalidade = (int) $consulta['idlocalidade_fk']; 
		   		$idEmprego = (int) $consulta['idemprego_fk'];
			} 			
		}catch( \Exception $e){}

		$status =  mysqli_affected_rows(parent::$connection); 
		if( $status == -1 )
			return mysqli_error(parent::$connection); 
		else if( $status == 0 )
			return "Nada encontrado com essa id"; 
		
		$daoLocalidade = new DAOLocalidade(); 

		$localidade = $daoLocalidade->select($idLocalidade); 
		if( is_string($localidade) )
			return $localidade; // retorna a mensagem de erro do dao localidade; 

		$egresso->setLocalidade($localidade); 
		var_dump($localidade); 
		return $egresso; 
	}
	
	public function update ($element){
		
	}
}