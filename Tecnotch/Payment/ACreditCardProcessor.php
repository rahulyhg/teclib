<?php
namespace Tecnotch\Payment;

abstract class ACreditCardProcessor implements ICreditCardProcessor {
    
    private $_creditCard;

    public function setCreditCard(CreditCard $creditCard)
    {
        $this->_creditCard = $creditCard;
        return $this;
    }

    public function getCreditCard()
    {
        return $this->_creditCard;
    }
    public function saveCreditCard() {
        
    }

    public function getSavedCreditCard($cardId)
    {

    }
    
    public function getSavedCreditCards()
    {

    }

    public function updateCard(CreditCard $card)
    {
        
    }

    public function deleteCard($cardId)
    {

    }
    /*util*/
    public function parseJson($json)
    {
        return json_decode($json);
    }
}
