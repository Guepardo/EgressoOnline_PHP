<?php 
require_once(PATH.'Library'.DS.'WideImage'.DS.'WideImage.php'); 

class Image
{
	private $path = "Midia"; 
	private $tam; 
	private $errors; 

	function __construct(){
		$this->tam = 1028 * 1028 * 5;
		$this->errors = array('Houve um problema no uploado de arquivo',
							  'O arquivo é muito grande', 
							  'Erro no servidor.'
							 );  
	}

	//Salva uma imagem a partir do $_Files
	public function saveImg($name){
		if($_FILES[$name]['error'] != 0)
			return 0; 
		
		if($_FILES[$name]['size'] > $this->tam )
			return 2; 
		
		$extension = explode('.',$_FILES[$name]['name']); 
		$nomeFinal = md5(time().$_FILES[$name]['name']).'.'.$extension[1]; 

		if(move_uploaded_file($_FILES[$name]['tmp_name'],PATH.$this->path.DS.$nomeFinal))
			return PATH.$this->path.DS.$nomeFinal; 
		else
			return 3; 
	}


	public function saveCropAvatar($name,$x=0,$y=0,$x2=100,$y2=100,$compress=50){
		$result = self::saveImg($name);

		if(is_int($result))
			return $this->errors[$result]; 

		$wide = WideImage::load($result); 

		$extension = explode('.',$_FILES[$name]['name']); 
		$nomeFinal = md5(time().$_FILES[$name]['name'].'A-D').'.'.$extension[1]; 

		$wide->crop($x,$y,$x2,$y2)->resize(128)->saveToFile(PATH.$this->path.DS.$nomeFinal,$compress); 
		//$wide->crop($x,$y,$x2,$y2)->resize(128)->output('jpg', $compress);

		unlink($result); 
		return $nomeFinal; 
	}

}