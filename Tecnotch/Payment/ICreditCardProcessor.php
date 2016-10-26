<?php
namespace Tecnotch\Payment;

interface ICreditCardProcessor {
    public function setCreditCard(CreditCard $creditCard);
    public function getCreditCard();


    public function saveCreditCard();
    public function getSavedCreditCard($cardId);
    public function getSavedCreditCards();
    public function updateCard(CreditCard $card);
    public function deleteCard($cardId);
    
}
