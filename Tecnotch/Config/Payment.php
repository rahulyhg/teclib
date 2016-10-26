<?php
namespace Tecnotch\Config;

class Payment extends AConfig {
    
    public static function getConfig() {
        $configFile = TECNOTCH_PATH . '/../config_payment.php';
        return self::parseConfig($configFile);
    }    
}
