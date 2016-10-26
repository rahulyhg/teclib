<?php
require_once 'Tecnotch/bootstrap.php';
use \Tecnotch as Tecnotch;

use \Tecnotch\Logger as Logger;


Logger::setDir(__DIR__ . "/logs/");
Logger::setFile("api_subscription_plan.log");
Logger::log("=====================\n" . date("Y-m-d H:i:s")
          . "\n=====================");


$plan = \Tecnotch\Payment\Factory::ApiSubscriptionPlan();
$plan
    ->setReturnUrl("http://23.235.211.194/~tecnot5/teclib/return.php")
    ->setCancelUrl("http://23.235.211.194/~tecnot5/teclib/cancel.php")
    ->setNotifyUrl("http://23.235.211.194/~tecnot5/teclib/subscription_notification.php")
    ->setInvoice(rand())
    ;

/*

$term = new Tecnotch\Payment\Item\Subscription\Plan\Term();
$term
  ->setName('Trial Payments')
  ->setPrice(4.00)
  //repeat every 2 weeks
  ->setOccurrences(2)
  ->setInterval('W')

  ->setType('TRIAL')
  //total payments
  ->setNoOfPayments(2)
  ;

$plan->addTerm($term);


$term = new Tecnotch\Payment\Item\Subscription\Plan\Term();
$term
  ->setName('Regular Payments')
  ->setPrice(4.00)
  //repeat every 1 Month
  ->setOccurrences(1)
  ->setInterval('M')

  ->setType('REGULAR')
  //total payments
  ->setNoOfPayments(15)
  ;


$plan->addTerm($term);


$plan
  ->setName("Golden Plan")
  ->setDescription("Golden Plan, enjoy full features")
  // 'FIXED' : 'INFINITE'
  ->setType('FIXED')
  ->setSetupFee(11);


$createdPlan = $plan->execute();

print_r($createdPlan);

if ($createdPlan->getId()) {
    echo "Plan Id " . $createdPlan->getId();
    //save plan id
    //"id": "P-523439043367204246EBV6FI"
    //payment ids
    //"id": "PD-9C7940917M949905M6EBV6FI",
    //"id": "PD-3AG17727S3112594U6EBV6FI",        
    
}
*/

/*
//get plan
$planId = 'P-523439043367204246EBV6FI';
$createdPlan = $plan->getPlan($planId);
print_r($createdPlan);
*/

/*
//activate plan
$planId = 'P-523439043367204246EBV6FI';
$activePlan = $plan->activatePlan($planId);
echo '<pre>'; print_r($activePlan);
*/


$plan
  ->setName("Golden Plan Updated")
  ->setDescription("Golden Plan Updated, enjoy full features")
  // 'FIXED' : 'INFINITE'
  ->setType('INFINITE')
  ->setSetupFee(10)
  //CREATED, ACTIVE, INACTIVE, DELETED.
  ->setState('ACTIVE');


$term = new Tecnotch\Payment\Item\Subscription\Plan\Term();
$term
  ->setId('PD-9C7940917M949905M6EBV6FI')
  ->setName('Trial Payments Updated')
  ->setPrice(5.00)
  //repeat every 1 Month
  ->setOccurrences(1)
  ->setInterval('M')

  ->setType('TRIAL')
  //total payments
  ->setNoOfPayments(3)
  ;

$plan->addTerm($term);

$term = new Tecnotch\Payment\Item\Subscription\Plan\Term();
$term
  ->setId('PD-3AG17727S3112594U6EBV6FI')
  ->setName('Regular Payment Updated')
  ->setPrice(6.00)
  //repeat every 1 Month
  ->setOccurrences(1)
  ->setInterval('M')

  ->setType('REGULAR')
  //total payments
  ->setNoOfPayments(20)
  ;

$plan->addTerm($term);



$updatedPlan = $plan->update('P-523439043367204246EBV6FI');

print_r($updatedPlan);