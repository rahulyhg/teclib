<?php

/**
 * Error handler class
 * 
 * @category   Tecnotch
 * @package    Tecnotch\Error
 * @author     Tofeeq ur Rehman <tofeeq3@gmail.com>
 * @copyright  2016 Tecnotch Ltd.
 * @version    1.0
 */

/**
 * This class can be used to show or log errors
 * Example:
 * \Tecnotch\Error::trigger("a test message");
 * \Tecnotch\Error::log("a test message");
 * 
 */

namespace Tecnotch;

class Error {
    
    public static function trigger($error) {
        echo $error;
    }
    
    public static function log($error) {
        Logger::log($error);
    }
    
}
