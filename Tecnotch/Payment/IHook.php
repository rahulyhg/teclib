<?php
namespace Tecnotch\Payment;
                 
interface IHook {
    public function verifyPayment();
    public function verifySubscription();
    public function getAmount();
    public function getCurrency();
    public function getInvoice();
    public function getTransactionId();


    public function getSubscriptionDate();
    public function getNoOfPayments();
    public function getTrialAmount();
    public function getTrialAmount2();

    public function getData();
    

}
