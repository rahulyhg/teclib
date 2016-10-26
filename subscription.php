<?php
require_once 'Tecnotch/bootstrap.php';
use \Tecnotch as Tecnotch;

$payment = \Tecnotch\Payment\Factory::simpleSubscription();



$payment
    //business email
    
    //store urls
    ->setReturnUrl("http://23.235.211.194/~tecnot5/teclib/return.php")
    ->setCancelUrl("http://23.235.211.194/~tecnot5/teclib/cancel.php")
    ->setNotifyUrl("http://23.235.211.194/~tecnot5/teclib/subscription_notification.php")
    
    //personal detail
    ->setEmail("developer.tofeeq.pay@gmail.com")
    ->setFirstName("Tofeeq")
    ->setLastName("Rehman")
    
    //personal billing address 
    ->setStreet("Street 2")
    ->setCity("Multan")
    ->setState("Punjab")
    ->setZip(60000)
    ->setLocale("EN_US")
    ->setPhone('03017874905')
    
    
    ->setInvoice(rand())
    
    
    ;

$item = new Tecnotch\Payment\Item\Subscription();

$item
  ->setName('$5.00 USD/M, with free trial first month, $4.00 for next month and then $5.00 for total 15 payments')

  //a3 - amount to be invoiced each recurrence
  ->setPrice(5.00)
  //p3 - number of time periods between each recurrence
  ->setOccurrences(1)
  //t3 - time period (D=days, W=weeks, M=months, Y=years)
  ->setInterval('M')

  //a1 trial price, 0 = free
  ->setTrialPrice(0)
  //p1 trial duration
  ->setTrialOccurrences(1)

  /*t1
    D — for days; allowable range for p2 is 1 to 90
    W — for weeks; allowable range for p2 is 1 to 52
    M — for months; allowable range for p2 is 1 to 24
    Y — for years; allowable range for p2 is 1 to 5
  */

  ->setTrialInterval('M')

  //a2, requires trial 1
  ->setTrial2Price(4)
  //p2
  ->setTrial2Occurrences(1)
  //t2
  ->setTrial2Interval('M')

  //srt Total No of Recurring times. Leave empty for unlimited,Total Number of times that subscription payments recur. 
  //2 and a maximum value of 52.
  ->setNoOfPayments(15)
  /*
  For the example above, the variables would be:
  $5.00 USD (a3) every 1 (p3) month (t3)
  */
  ;

$payment->addItem($item);


$payment->setButton(array('value' => 'Subscribe', 'class' => ""));

echo $payment->execute();
