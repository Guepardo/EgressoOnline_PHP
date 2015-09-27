<?php
require_once(PATH.'Security'.DS.'Firewall.php'); 

require_once(PATH.'Controller'.DS.'UseCase'.DS.'HumanController.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'ManterUsuario.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'AjaxServices.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'Autenticar.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'TelaPrincipal.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'DivulgarOportunidade.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'VisualizarOportunidade.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'VisualizarPerfil.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'Configurar.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'ManterCurso.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'Mensagens.php');
require_once(PATH.'Controller'.DS.'UseCase'.DS.'Relatorios.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'Buscar.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'ManterPerfilTurma.php'); 
require_once(PATH.'Controller'.DS.'UseCase'.DS.'Security.php'); 
/**
 * Controlador principal dos casos de uso. Essa classe tem a responsabilidade de encontrar qual é o caso de uso mais adequado e relação ao request que é passado pelo usuário. 
 */
class MainController {
	private $controllersArray;
	public function __construct() {
		// incluir todos os controllers específicos aqui;       
		$this->controllersArray = array (
			'humanos'       => new HumanController (),
			'manterUsuario' => new ManterUsuario(),
			'telaPrincipal' => new TelaPrincipal(),
			'ajaxServices'  => new AjaxServices(), 
			'autenticar'    => new Autenticar(),
			'divulgar'      => new DivulgarOportunidade(), 
			'visualizar'	=> new VisualizarOportunidade(), 
			'configurar'    => new Configurar(), 
			'manterCurso'   => new ManterCurso(), 
			'mensagens'     => new Mensagens(), 
			'perfil'        => new VisualizarPerfil(), 
			'relatorios'    => new Relatorios(), 
			'buscar'        => new Buscar(), 
			'manterTurma'   => new ManterPerfilTurma(), 
			'security'      => new Security()
			);
	}
	
	/**
	 * Método que inicia a classe Firewall e faz a leitura da variável global $_REQUEST para atender as requisições dos usuários.
	 * @param      <void> 
	 * @return     <boolean> Indica se o método do caso de uso foi invocado com sucesso. 
	 */
	public function findMyController() {
		// Passos:
		// 1 O useCase está nas lista de ControllersArray?
		// 2 A action existe no controlador?
		// 3 Invocar método;
		// 4 Gerar output.
		Firewall::initFirewall(); 
		$isNotFound = false; 
		$controller = null; 

		$useCase = (empty($_REQUEST ['uc'])) ? null : $_REQUEST['uc'];
		$action  = (empty($_REQUEST ['a'])) ? null : $_REQUEST['a'];
		

		if(array_key_exists($useCase, $this->controllersArray)){
			$controller = $this->controllersArray [$useCase];
			$realNameMethod = '';
		}else{
			$controller = $this->controllersArray['security']; 
			$realNameMethod = 'notFoundView'; 
			$isNotFound = true; 
		}
		
		
		$arrayMethods = $controller->sayMyActions();

		if(!empty($action)){
			foreach ( $arrayMethods as $a ) {
				if (strcasecmp ( $a, $action ) == 0) {
					$realNameMethod = $a;
					break;
				}
			}
		}
		
		if (strlen ( $realNameMethod ) == 0) {
			$controller = $this->controllersArray['security']; 
			$realNameMethod = 'notFoundView'; 
			$isNotFound = true; 
		}
		
		//Verificando permissão
		
		if(!$isNotFound){
			$block = Firewall::permissao($controller, $realNameMethod); 

			if($block){
				$controller = $this->controllersArray['security']; 
				$realNameMethod = 'blockView';
			}
		}

		$reflection = new ReflectionMethod ( $controller->sayMyName (), $realNameMethod );
		return $reflection->invoke ( $controller, self::preparingArray( $_REQUEST ));
	}

	private function preparingArray($target) {
		$array = array_merge ( array (), $target );
		unset ( $array ['a'] );
		unset ( $array ['uc'] );
		return $array;
	}
	
}