<?php 

require_once(PATH.'Library'.DS.'PHPMailer.php'); 

class Mail{
	private $phpMailer; 

	public function __construct(){
		//require_once( WWW_ROOT . DS .'Library'. DS .'PHPMailerAutoload.php'); 
		$this->phpMailer = new PHPMailer(true); 
	}

	public function sendEmail($emailContent, $emailAddress, $subject, $name ){
		//Configuraçãoes do servidor SMTP
		//To-do: Essas informações deverão ser agrupadas numa classe de configuração. 
		
		//$this->phpMailer->Debugoutput = 'html';
		$this->phpMailer->Mailer = "smtp"; 
		$this->phpMailer->isSMTP(); //Informa que a coisa será em SMTP
		$this->phpMailer->SMTPAuth = true;
		$this->phpMailer->Host     = "tls://g4group.me:20000"; 
		$this->phpMailer->Username = "egressoonline@g4group.me"; 
		$this->phpMailer->Password = "12345678"; 

		$this->phpMailer->SMTPAutoTLS = true;
		//$this->phpMailer->SMTPDebug = 3;

		$this->phpMailer->From = "egressoonline@g4group.me"; 
		$this->phpMailer->FromName = "EgressoOnline"; 
		//Adicionando endereços de email que irão receber a mensagem; 
		$this->phpMailer->AddAddress($emailAddress, $name); 
		//Informando a PHPMailer enviará emails com conteúdo html; 
		$this->phpMailer->IsHTML(true); 

		self::setAttributes($subject, $emailContent,''); 

		$isSend = $this->phpMailer->Send(); 

		//var_dump($isSend);  
		//var_dump($this->phpMailer); 
		//Limpando tudo que foi adicionando ao PHPMailer
		self::clearAll();
		return $isSend; 
	}

	private function setAttributes($subjet, $body, $altBody=''){
		$this->phpMailer->Subject = $subjet; 
		$this->phpMailer->Body   = $body; 
		$this->phpMailer->AltBody = $altBody; 
	} 

	private function clearAll(){
		$this->phpMailer->ClearAllRecipients(); 
		$this->phpMailer->ClearAttachments(); 
	}
}