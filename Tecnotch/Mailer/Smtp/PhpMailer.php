<?php
namespace Tecnotch\Mailer\Smtp;
use \Tecnotch\Mailer as Mailer;
use \Tecnotch\Config\Email  as Email_Config;

class PhpMailer extends Mailer\Abs {
	public function send() {
		
		/*
		$params = array(
			'from' => array(
					'email' => 'name',
				),
			'Subject'	=> $subject,
			'to'	=> array(
					'tofeeq3@gmail.com' => 'Tofeeq'
				),
			'cc'	=> array(
					'tofeeq3@gmail.com' 
				),
			'body'	=> $body
		);
		*/

		$config = Email_Config::getConfig();

		require_once TECNOTCH_PATH . '/Mailer/lib/phpmailer/PHPMailerAutoload.php';
 		
 		$mail = new \PHPMailer();
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $config->smtp_host; 			 		  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $config->smtp_username;                 // SMTP username
		$mail->Password = $config->smtp_password; 		          // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, `tls` also accepted
		$mail->Port = $config->smtp_port; 			          // TCP port to connect to
		$mail->setFrom(key($this->getFrom()), current($this->getFrom()));
		
		foreach ($this->getTo() as $email => $name) {
			$mail->addAddress($email, $name);     // Add a recipient
		}
		
		if ($this->getReplyTo()) {
			$mail->addReplyTo(key($this->getReplyTo()), current($this->getReplyTo()));	
		}
		if ($this->getCc()) {
			foreach ($this->getCc() as $email => $name) {
				$mail->addCC($email, $name);     // Add a recipient
			}
		}
		
		if ($this->getBcc()) {
			foreach ($this->getBcc() as $email => $name) {
				$mail->addBCC($email, $name);     // Add a recipient
			}
		}
		
		$attachments = $this->getAttachments();
		if (!empty($attachments)) {
			foreach ($attachments as $attachment) {
				$mail->addAttachment($attachment['file_path'], $attachment['title']);
				//$attachment['type']
			}
		}

		 

		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $this->getSubject();
		$mail->Body    = $this->getBody();
		$mail->AltBody = strip_tags($this->getBody());
		$result = $mail->send();

		\Tecnotch\Logger::rlog($result);
		\Tecnotch\Logger::rlog("Errors: " . $mail->ErrorInfo);
		return $result;
	}
}