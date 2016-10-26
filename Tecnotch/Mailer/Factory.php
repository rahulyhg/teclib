<?php
namespace Tecnotch\Mailer;
use Tecnotch\Config as Config;


class Factory {

	public static function smtp() 
	{
		$config = Config\Email::getConfig();
		
		switch ($config->smtp_backend) {
			case 'phpmailer':
				return new Smtp\PhpMailer();
				break;
			
			default:
				return new Smtp\Swift();
				break;
		}
		
	}
}
