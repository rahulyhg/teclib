<?php
require_once 'Tecnotch/bootstrap.php';
use \Tecnotch as Tecnotch;
use \Tecnotch\Logger as Logger;


Logger::setDir(__DIR__ . "/logs/");
Logger::setFile("api_paypal_notify.log");
Logger::log("=====================\n" . date("Y-m-d H:i:s")
          . "\n=====================");

$payment = \Tecnotch\Payment\Factory::ApiPayment();

