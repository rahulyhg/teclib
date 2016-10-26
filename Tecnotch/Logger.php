<?php

/**
 * Logger to log events/debugs in file or printing them directly to screen
 * 
 * @category   Tecnotch
 * @package    Tecnotch\Logger
 * @author     Tofeeq ur Rehman <tofeeq3@gmail.com>
 * @copyright  2016 Tecnotch Ltd.
 * @version    1.0
 */

/**
 * This class can be used to log your events output in a file or directly printing to screen
 * Each log can be created in individual file or can be logged in default log file
 * Default mode is "write", that means it will write output in log file, you can turn it to 
 * "print" mode to print output directly to screen.
 * it uses the satic "enabled" variable to turn logs on or off
 * if enabled is false then logging will not happen
 * Example:
 * \Tecnotch\Logger::log("a test message");
 *
 * logging object/array
 * \Tecnotch\Logger::rlog($object); 
 * 
 */

namespace Tecnotch;

class Logger {

	/**
     * File name of the log file
     * Example : "mail.log"
     * @var string
     */	

	public static $logFile = "log";

	/**
     * File object for open the file 
     * Example self::$file = fopen("log.txt", 'w');
     * @var object
     */	

	public static $file;
	
	/**
     * Directory for logs
     */	
	protected static $_dir;

	/**
     * Either log into file or print to screen
     * Potential values are 'wirte' and 'print'.
     * @var string
     */

	public static $mode = 'write';

	/**
     * Turn on or off the logs
     * Potential values are true and false.
     * @var bool
     */

	public static $enabled = true;

    /**
	 * Set file for writing logs
	 * @param string $file 
	 */

	public static function setFile($file)
	{
		self::$logFile = $file;
	}
	
	/**
	 * Set Dir for writing logs
	 * @param string $dir 
	 */

	public static function setDir($dir)
	{
		self::$_dir = rtrim($dir, "/") . "/";
	}

	/**
	 * Log an event string into file or print to screen
	 * @param string $msg 
	 * @param string $file 
	 */

	public static function log($msg, $file = null) 
	{
		if (!self::$enabled)
			return ;

		if (self::$mode == 'print') {
			$msg .= "\r\n";
			echo nl2br($msg);
			return ;
		}

		fwrite(self::getFile($file), $msg . "\n");
	}
	
	/**
	 * Log an object or array into file or print to screen
	 * @param mixed $var 
	 * @param string $file 
	 */

	public static function rlog($var, $file = null) 
	{
		if (!self::$enabled)
			return ;

		if (self::$mode == 'print') {
			echo '<pre>', $var, '</pre>';
			return ;
		}

		fwrite(self::getFile($file), print_r($var, 1) . "\n");
	}
	
	/**
	 * Get directory to place log files
	 */
	
	public static function getDir()
	{
	    if (self::$_dir) {
	        return self::$_dir;
	    } else {
	        return TECNOTCH_PATH . '/logs/';
	    }
	}
	/**
	 * Create file instace for writing logs
	 * @param string $file 
	 */

	public static function getFile($file = null)
	{
		if ($file and $file != self::$logFile) {
			self::$logFile = $file;
			self::$file = fopen(self::getDir() . self::$logFile, 'a');
			return self::$file;
		}
		
		//create default
		if (!self::$file) {
			self::$file = fopen(self::getDir() . self::$logFile, 'a');		
			return self::$file;
		}
		
		return self::$file;
		
	}
}
