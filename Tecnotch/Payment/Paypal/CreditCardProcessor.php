<?php
namespace Tecnotch\Payment\Paypal;

use Tecnotch\Logger as Logger;
use Tecnotch\Payment\CreditCard as CreditCard;
use Tecnotch\Payment\ACreditCardProcessor as ACreditCardProcessor;

require __DIR__  . '/../lib/Paypal/vendor/autoload.php';

use \PayPal\Api\CreditCard as Paypal_CreditCard;


class CreditCardProcessor extends ACreditCardProcessor
{
    private $_apiContext;


    public function setApiContext(\PayPal\Rest\ApiContext $context)
    {
        $this->_apiContext = $context;
        return $this;    
    }

    public function getApiContext()
    {
        if (!$this->_apiContext) {
            
            $config = \Tecnotch\Config\Payment::getConfig();

            $this->_apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    $config->api_key,     // ClientID
                    $config->api_secret      // ClientSecret
                )
            );
        }

        return $this->_apiContext;
    }

    public function saveCreditCard()
    {
        $creditCard = new Paypal_CreditCard();
        $creditCard
            ->setType($this->getCreditCard()->getType())
            ->setNumber($this->getCreditCard()->getNumber())
            ->setExpireMonth($this->getCreditCard()->getExpireMonth())
            ->setExpireYear($this->getCreditCard()->getExpireYear())
            ->setCvv2($this->getCreditCard()->getSecurityCode())
            ->setFirstName($this->getCreditCard()->getFirstName())
            ->setLastName($this->getCreditCard()->getLastName());


        try {

            $creditCard->create($this->getApiContext());
            Logger::log($creditCard);


            $this->getCreditCard()
                ->setId($creditCard->getId())
                ->setState($creditCard->getState())
                ->setValidUntil($creditCard->getValidUntil())
                ->setCreateTime($creditCard->getCreateTime())
                ->setUpdateTime($creditCard->getUpdateTime())
                ;
            
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            Logger::log($ex->getData());
        } catch (Exception $ex) {
            Logger::log($ex->getMessage());
        }    
    }

    public function getSavedCreditCard($cardId)
    {
        try {
            
            $creditCard = Paypal_CreditCard::get($cardId, $this->getApiContext());
            Logger::log($creditCard);

            $card = new CreditCard();
            $card
                ->setId($creditCard->getId())
                ->setType($creditCard->getType())
                ->setNumber($creditCard->getNumber())
                ->setExpireMonth($creditCard->getExpireMonth())
                ->setExpireYear($creditCard->getExpireYear())
                ->setFirstName($creditCard->getFirstName())
                ->setLastName($creditCard->getLastName())
                
                ->setState($creditCard->getState())
                ->setValidUntil($creditCard->getValidUntil())
                ->setCreateTime($creditCard->getCreateTime())
                ->setUpdateTime($creditCard->getUpdateTime())
                ;
            return $card;
        } catch (Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function getSavedCreditCards()
    {
        try {
            
            $params = array(
                "sort_by" => "create_time",
                "sort_order" => "desc",
                //"merchant_id" => "MyStore1"  // Filtering by MerchantId set during CreateCreditCard.
            );

            $paypal = Paypal_CreditCard::all($params, $this->getApiContext());
            Logger::log($paypal);

            $paypalCards = $paypal->getItems();

            $creditCards = array();
            foreach ($paypalCards as $creditCard) {
                $card = new CreditCard();
                $card
                    ->setId($creditCard->getId())
                    ->setType($creditCard->getType())
                    ->setNumber($creditCard->getNumber())
                    ->setExpireMonth($creditCard->getExpireMonth())
                    ->setExpireYear($creditCard->getExpireYear())
                    ->setFirstName($creditCard->getFirstName())
                    ->setLastName($creditCard->getLastName())
                    
                    ->setState($creditCard->getState())
                    ->setValidUntil($creditCard->getValidUntil())
                    ->setCreateTime($creditCard->getCreateTime())
                    ->setUpdateTime($creditCard->getUpdateTime())
                    ;
                $creditCards[] = $card;
            }

            
            return $creditCards;

        } catch (Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function updateCard(\Tecnotch\Payment\CreditCard $card)
    {
        $patches = array();

        if ($card->getExpireMonth()) {
            $patch = new \PayPal\Api\Patch();
            $patch->setOp("replace")
                ->setPath('/expire_month')
                ->setValue($card->getExpireMonth());

            $patches[] = $patch;
        }

        if ($card->getExpireYear()) {
            $patch = new \PayPal\Api\Patch();
            $patch->setOp("replace")
                ->setPath('/expire_year')
                ->setValue($card->getExpireYear());

            $patches[] = $patch;
        }        

        if ($card->getFirstName()) {
            $patch = new \PayPal\Api\Patch();
            $patch->setOp("replace")
                ->setPath('/first_name')
                ->setValue($card->getFirstName());

            $patches[] = $patch;
        }        

        if ($card->getLastName()) {
            $patch = new \PayPal\Api\Patch();
            $patch->setOp("replace")
                ->setPath('/last_name')
                ->setValue($card->getLastName());

            $patches[] = $patch;
        }


        if (!empty($patches)) {

            $pathRequest = new \PayPal\Api\PatchRequest();

            foreach ($patches as $patch) {
                $pathRequest->addPatch($patch);
            }

            $papalCard = new Paypal_CreditCard();
            $papalCard->setId($card->getId());
            $papalCard = $papalCard->update($pathRequest, $this->getApiContext());

            Logger::log($papalCard);
        }    
    }


    public function deleteCard($cardId)
    {
        $papalCard = new Paypal_CreditCard();
        $papalCard->setId($cardId);
        return $papalCard->delete($this->getApiContext());       
    }

    public function execute() {
        
        $config = \Tecnotch\Config\Payment::getConfig();
        
        /*    
        $this->getNotifyUrl()
        $config->currency
        $this->getInvoice()
        $config->merchant_email
            
        $this->getShoppingUrl()
            
             
            
        $this->getFirstName()
        $this->getLastName()
        $this->getStreet()
        $this->getCity()
        $this->getState()
        $this->getZip()
        $this->getPhone(1, 3)
        $this->getPhone(3, 3)
        $this->getPhone(7, 4)
        $this->getEmail()
        $this->getHandling()
        $this->getTax()
        $this->getWeight()
        $config->weight_unit
            
        if ($this->getDiscount()) {
            $this->getDiscount()
        }
             
        $this->getTotal()
        $this->getShipping()


        $n = 0;
        foreach ($this->getItems() as $item) {
           
           $n ++; 
            
           $item->getPrice()
           $item->getName()
           $item->getId()
           $item->getQuantity()
           $item->getDiscount()
           $item->getTax()
           $item->getShipping()
           $item->getHandling()
           
            
        }
                             
            
        foreach ($this->getParams() as $key => $val) {
           
        }       
                      
        if ($this->getButton()) {
            $this->getButton();    
        }
        */
    }
}
