<?php
namespace Tecnotch;

class Factory {
	public static function mailer($mailer = 'simple') {
		switch ($mailer) {
			case 'smtp':
				return Mailer\Factory::smtp();
			break;
			
			default:
				return new Mailer\Simple();
			break;
		}
		
	}
	
}
