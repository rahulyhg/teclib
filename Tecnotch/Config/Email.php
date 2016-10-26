<?php
namespace Tecnotch\Config;

class Email extends AConfig {
    
    public static function getConfig() {
        $configFile = TECNOTCH_PATH . '/../config_email.php';
        return self::parseConfig($configFile);
    }    
}
