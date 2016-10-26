<?php
require_once 'Tecnotch/bootstrap.php';
use \Tecnotch as Tecnotch;
use Tecnotch\Logger as Logger;

Logger::setDir(__DIR__ . '/logs/');

Logger::setFile("paypal_ipn.log");
Logger::log("=======================");
Logger::log(date("Y-m-d H:i:s"));
Logger::log("=======================");


$hook = \Tecnotch\Payment\Factory::paymentHook(); 

$res = $hook->verifyPayment();
$data = $hook->getData();

Logger::log("Data from paypal");
Logger::log(print_r($data, 1));
Logger::log(print_r($res, 1));

if ($res === true) {
    
    Logger::log("Payment verified");
    
    $transactionId  = $hook->getTransactionId();
    $invoiceId      = $hook->getInvoice();
    $amount         = $hook->getAmount();
    $currency       = $hook->getCurrency();
            
    Logger::log("transactionId: " . $transactionId);
    Logger::log("invoiceId: " . $invoiceId);
    Logger::log("amount: " . $amount);
    Logger::log("currency: " . $currency);

    
    // Check that txn_id has not been previously processed
	// Check that payment_amount/payment_currency are correct
    

    //Do your logic here

    $mailer = Tecnotch\Factory::mailer('simple');

 
    $placeholders = array(
	    "[user_name]" => "Tofeeq Rehman",
	    "[product]" => "Purchase Order",
	    "[site_admin]" => "Tecnotch Team"
    );

    $mailer
	    ->setPlaceholders($placeholders)
        ->setTemplatePath(__DIR__ . '/html/email/en')
        ->setTemplate("payment_confirmation.html")
        ->setTo(array("tofeeq3@gmail.com" => "Tofeeq Rehman"))
        ->setFrom(array("info@tecnotch.com" => "Tecnotch"))
        ->send();
	
	
    Logger::log("Finished");
    
} else {
    Logger::log("Payment not verified please check some thing in code or profile");
}
