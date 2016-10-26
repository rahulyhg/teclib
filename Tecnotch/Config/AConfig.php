<?php
namespace Tecnotch\Config;
use Tecnotch\Error;

class AConfig implements IConfig {
    
    protected static $_config = array();
    protected static $_file;
    
    public static function getConfig() {
    }
    
    
    public static function parseConfig($file) {
        if (empty(self::$_config[$file])) {
            self::validateConfig($file);
            
            $json = file_get_contents(self::$_file);
            $config = json_decode($json);
            if (!$config) {
                Error::trigger("No valid json found in config: " . self::$_file);
            }
            
            self::$_config[$file] = $config;
       }
       
       return self::$_config[$file];
    }
    
    public static function validateConfig($file)
    {
        if (file_exists($file)) {
            self::$_file = $file;
            return true;
        }
        
        Error::trigger("File not found at location: " . $file);
    }
} 
