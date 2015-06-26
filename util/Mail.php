<?php 
namespace Util;

use Library\PHPMailer; 

class Mail{
	private $phpMailer; 

	public function __construct(){
		$this->phpMailer = new PHPMailer(); 
	}

	public function sendEmail($emailContent, $emailAddress, $name ){
		//Configuraçãoes do servidor SMTP
		//To-do: Essas informações deverão ser agrupadas numa classe de configuração. 
		

		$this->phpMailer->isSMTP(); //Informa que a coisa será em SMTP
		$this->phpMailer->Host     = "g4group.me"; 
		$this->phpMailer->Username = "egressoonline@g4group.me"; 
		$this->phpMailer->Password = "12345678"; 

		$this->phpMailer->Port     =    465; 
		$this->phpMailer->SMTPSecure = 'ssl';
		$this->phpMailer->SMTPAuth   =  true;


		$this->phpMailer->SMTPAutoTLS = true;
		$this->phpMailer->SMTPDebug = 1;

		$this->phpMailer->From = "egressoonline.com"; 
		$this->phpMailer->FromName = "EgressoOnline"; 
		//Adicionando endereços de email que irão receber a mensagem; 
		$this->phpMailer->AddAddress($emailAddress, $name); 
		//Informando a PHPMailer enviará emails com conteúdo html; 
		$this->phpMailer->IsHTML(true); 

		self::setAttributes("Mensagem Teste", $emailContent); 

		$isSend = $this->phpMailer->Send(); 

		var_dump($isSend);  
		//var_dump($this->phpMailer); 
		//Limpando tudo que foi adicionando ao PHPMailer
		self::clearAll();
		return $isSend; 
	}

	private function setAttributes($subjet, $body, $altBody=''){
		$this->phpMailer->Subjet = $subjet; 
		$this->phpMailer->Body  = $body; 
		$this->phpMailer->AltBody = $altBody; 
	} 

	private function clearAll(){
		$this->phpMailer->ClearAllRecipients(); 
		$this->phpMailer->ClearAttachments(); 
	}
}