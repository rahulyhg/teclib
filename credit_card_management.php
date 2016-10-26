<?php
require_once 'Tecnotch/bootstrap.php';

use \Tecnotch as Tecnotch;
use Tecnotch\Payment\CreditCard as CreditCard;
use Tecnotch\Logger as Logger;


Logger::setDir(__DIR__ . "/logs/");
Logger::setFile("ccget.log");
Logger::log("=====================\n" . date("Y-m-d H:i:s")
          . "\n=====================");


$creditCardProcessor = Tecnotch\Payment\Factory::CreditCardProcessor();

/*
//Save new card

$creditCard = new CreditCard();
$creditCard->setType("visa")
    ->setNumber("4417119669820331")
    ->setExpireMonth("11")
    ->setExpireYear("2019")
    ->setSecurityCode("012")
    ->setFirstName("Tofeeq")
    ->setLastName("Rehman");    

$creditCardProcessor->setCreditCard($creditCard);
$creditCardProcessor->saveCreditCard();

echo '<pre>';
print_r($creditCard);
print_r($creditCard->getId());
print_r($creditCard->getState());
*/



/*

//get saved credit card
$cardId = 'CARD-2H977042YF569730LLAEFQCQ';
$creditCard = $creditCardProcessor->getSavedCreditCard($cardId);

if ($creditCard->getState() == 'ok') {
    echo 'Card get: <pre>';
    print_r($creditCard);

} else {
    echo '<pre>';
    print_r($creditCard);
}
*/



/*
//update card
$card = new Tecnotch\Payment\CreditCard();
$card
    ->setId('CARD-2H977042YF569730LLAEFQCQ')
    ->setExpireMonth(11)
    ->setExpireYear(2022)
    ->setFirstName("RehmanU")
    ->setLastName("TofeeqU")
    ;
$card = $creditCardProcessor->updateCard($card);
print_r($card);
*/



/*
//get saved credit card
$cardId = 'CARD-2H977042YF569730LLAEFQCQ';
$res = $creditCardProcessor->deleteCard($cardId);
if ($res) {
    echo "Card Deleted";
}
*/

//get all cards
$cards = $creditCardProcessor->getSavedCreditCards();
echo '<pre>';
print_r($cards);
