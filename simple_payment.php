<?php
require_once 'Tecnotch/bootstrap.php';
use \Tecnotch as Tecnotch;

$payment = \Tecnotch\Payment\Factory::simplePayment();



$payment
    //business email
    
    //store urls
    ->setReturnUrl("http://23.235.211.194/~tecnot5/teclib/return.php")
    ->setCancelUrl("http://23.235.211.194/~tecnot5/teclib/cancel.php")
    ->setNotifyUrl("http://23.235.211.194/~tecnot5/teclib/payment_notification.php")
    ->setShoppingUrl("http://23.235.211.194/~tecnot5/teclib/")
    
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
    
    //Cart totals
    //->setDiscount(10)
    //->setShipping(8)
    //->setHandling(3)
    //->setTax(10)
    //->setTotal(100)
    
    //needed for paypal
    ->setInvoice(rand())
    
//    ->setParam('cmd', '_xclick')
    ->setParam('cmd', '_cart')
    ->setParam('upload', 1)
    
    ->setParam('custom', 'sometext')
    
    
    ;


$items = array(
  array(
      "id" => 1,
      "name" => "test item",
      "quantity" => 3,
      "price"   => 10,
      "tax" => 1,
      "shipping" => 4,
      "handling" => 3,
      "discount" => 2
  ),
  array(
      "id" => 2,
      "name" => "test item 2",
      "quantity" => 4,
      "price"   => 4,
      "tax" => 2,
      "shipping" => 3,
      "handling" => 2,
      "discount" => 2.5
  )  
);

foreach ($items as $item) {
    $payItem = new \Tecnotch\Payment\Item();
    $payItem->setId($item['id'])
        ->setName($item['name'])
        ->setQuantity($item['quantity'])
        ->setPrice($item['price'])
        ->setTax($item['tax'])
        ->setShipping($item['shipping'])
        ->setHandling($item['handling'])
        ->setDiscount($item['discount']);
        
    $payment->addItem($payItem);    
}
			
$payment->setButton(array('value' => 'Subscribe', 'class' => ""))

echo $payment->execute();
