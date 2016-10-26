<?php
namespace Tecnotch\Mailer\Smtp;
use \Tecnotch\Mailer as Mailer;
use \Tecnotch\Config\Email  as Email_Config;


class Swift extends Mailer\Abs {

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
		require_once TECNOTCH_PATH . '/Mailer/lib/swiftmailer/swift_required.php';
 		
 		// Create the message
		$message = \Swift_Message::newInstance()
			  // Give the message a subject
			  ->setSubject($this->getSubject())
			  // Set the From address with an associative array
			  ->setFrom($this->getFrom())
			  // Set the To addresses with an associative array
			  ->setTo($this->getTo())
			  
			   
			  // Give it a body
			  ->setBody($this->getBody(),  'text/html')
			  // And optionally an alternative body
			  //->addPart('<q>Here is the message itself</q>', 'text/html')
			  // Optionally add any attachments
			  //->attach(Swift_Attachment::fromPath('my-document.pdf'))
			  ;
			  
		if ($this->getCc()) {
			$message->setCc($this->getCc());
		}
		
		if ($this->getReplyTo()) {
			$message->setReplyTo($this->getReplyTo());
		}
		
		$attachments = $this->getAttachments();
		if (!empty($attachments)) {
			foreach ($attachments as $attachment) {
				
				$message->attach(
				  	\Swift_Attachment::fromPath(
				  		$attachment['file_path'],
				  		$attachment['type']
				  	)->setFilename($attachment['title'])
				);	
			}
			
		}

		$config = Email_Config::getConfig();
		
		$transport = \Swift_SmtpTransport::newInstance(
							$config->smtp_host, 
							$config->smtp_port, 'ssl'
						)
						->setUsername($config->smtp_username)
			  			->setPassword($config->smtp_password)
		;
		  
		$mailer = \Swift_Mailer::newInstance($transport);
		
		$result = $mailer->send($message);
		
		\Tecnotch\Logger::rlog($result);
		
		return $result;
	}
}