<?php
require_once(PATH.'Security'.DS.'BlockList.php');

/**
 * Classe abstrata que implementa comportamentos que devem ser implementados por qualquer classe que implemente um caso de uso neste sistema
 */
abstract class GenericController {
	/**
	 * Retorna o nome da classe por meio de métodos reflexivos. Exemplo class Exemplo{}, este método irá retornar Exemplo. 
	 *
	 * @return   <String> Nome da classe corrente.
	 */
	public function sayMyName() {
		$var = new ReflectionClass ( $this );
		return $var->getName ();
	}
	
	/**
	 * Retorna o nome dos métodos públicos por meio de métodos reflexívos. 
	 *
	 * @return   <array> Array contendo apenas o nome dos métodos públicos da classe corrente.
	 */
	public function sayMyActions() {
		$var = new ReflectionClass ( $this );
		$array = array ();
		$arrayTemp = $var->getMethods ( ReflectionMethod::IS_PUBLIC );
		
		foreach ( $arrayTemp as $a )
			array_push ( $array, $a->name );
		
		return $array;
	}

	/**
	 * Verifica se há itens no array. Caso houver algum item nesse array, isso será intempretado como um erro ocorrido. Consequentemente será adicionado o 'status' da requisição como falso, o conteúdo do array será transformado em JSON e despachado para o usuário. 
	 *
	 * @param      <array>  $array  
	 */
	protected function verifyErros($array){
		if(!empty($array)){
			$msg = "Alerta de incosistência! "; 
			$result = array(); 

			foreach( $array as $key => $value ){
				$msg .= $key.": "; 

				foreach($value as $a )
					$msg .= $a.', '; 
				$msg .= '.'; 
			}

			$result['status'] = false; 
			$result['msg']    = $msg; 

			die(json_encode(($result))); 
		}
	}
}