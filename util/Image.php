<?php 
require_once(PATH.'Library'.DS.'WideImage'.DS.'WideImage.php'); 

class Image
{
	private $path = "Midia"; 
	private $tam; 
	public  $errors; 

	function __construct(){
		$this->tam = 1028 * 1028 * 5;
		$this->errors = array('houve um problema no upload de arquivo.',
							  'o arquivo é muito grande.', 
							  'servidor com problemas.', 
							  'envie um arquivo de imagem PNG ou JPG.'
							 );  
	}

	//Salva uma imagem a partir do $_Files
	public function saveImg($name){
		if($_FILES[$name]['error'] != 0)
			return 0; 
		
		if($_FILES[$name]['size'] > $this->tam )
			return 1; 
		
		$extension = strtolower(explode('.',$_FILES[$name]['name'])); 
		$extension = $extension[1]; 
		if(strcmp($extension,'png') != 0 && strcmp($extension,'jpg') != 0 )
			return 3; 

		$nomeFinal = md5(time().$_FILES[$name]['name']).'.'.$extension[1]; 

		if(move_uploaded_file($_FILES[$name]['tmp_name'],PATH.$this->path.DS.$nomeFinal))
			return PATH.$this->path.DS.$nomeFinal; 
		else
			return 2; 
	}


	public function saveCropAvatar($name,$x=0,$y=0,$x2=100,$y2=100,$compress=50){
		$result = self::saveImg($name);

		if(is_int($result))
			return $result; 

		$wide = WideImage::load($result); 

		$extension = explode('.',$_FILES[$name]['name']); 
		$nomeFinal = md5(time().$_FILES[$name]['name'].'A-D').'.'.$extension[1]; 

		$wide->crop($x,$y,$x2,$y2)->resize(128)->saveToFile(PATH.$this->path.DS.$nomeFinal,$compress); 
		//$wide->crop($x,$y,$x2,$y2)->resize(128)->output('jpg', $compress);

		unlink($result); 
		return $nomeFinal; 
	}

	public function saveCropLandspace($name,$x=0,$y=0,$x2=100,$y2=100,$compress=50){
		$result = self::saveImg($name);

		if(is_int($result))
			return $result; 

		$wide = WideImage::load($result); 

		$extension = explode('.',$_FILES[$name]['name']); 
		$nomeFinal = md5(time().$_FILES[$name]['name'].'A-D').'.'.$extension[1]; 

		var_dump($extension); 
		
		$wide->crop($x,$y,$x2,$y2)->resize(1000,400)->saveToFile(PATH.$this->path.DS.$nomeFinal,$compress); 
		//$wide->crop($x,$y,$x2,$y2)->resize(128)->output('jpg', $compress);

		unlink($result); 
		return $nomeFinal; 
	}

}