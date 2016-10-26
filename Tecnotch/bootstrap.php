<?php
/*******************************************************************************
* Tecnotch Libraries                                                 		   *
*                                                                              *
* Version: 1.0                                                                 *
* Date:    2016-03-15                                                          *
* Author:  Tofeeq ur Rehman - Tecnotch Ltd.                                    *
*******************************************************************************/

namespace Tecnotch;

error_reporting(-1);
ini_set('display_errors', 'On');
//set_error_handler("var_dump");

//ini_set("mail.log", __DIR__ . "/logs/php_mail.log");
//ini_set("mail.add_x_header", TRUE);

//safarjal fruit

define('TECNOTCH_PATH', __DIR__);
define('TECNOTCH_ENV', 'dev');


spl_autoload_register(function ($className) {
	if (strpos($className, 'Tecnotch') === 0) {
		//suppress Tecnotch
		$className = str_replace("Tecnotch", "", $className);		
		
		//convert \ to /
		$className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
		$classPath = TECNOTCH_PATH . $className . '.php';
		
		if (file_exists($classPath)) {
			require_once($classPath);
		} else {
			echo "inclusion failed for class: $classPath";
		}
	} 
});
