<?php
namespace Tecnotch\Payment\Paypal;

use Tecnotch\Logger as Logger;

require __DIR__  . '/../lib/Paypal/vendor/autoload.php';


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;



class Api extends \Tecnotch\Payment\AAPI
{
    private $_apiContext;

    protected $_itemsTotal = 0;
    protected $_itemsTax = 0;
    protected $_itemsShipping = 0;
    protected $_itemsHandling = 0;
    protected $_itemsDiscount = 0;

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

            
            $this->_apiContext->setConfig(
                array(
                    'log.LogEnabled' => true,
                    'log.FileName' => Logger::getDir() . Logger::$logFile,
                    'log.LogLevel' => 'DEBUG'
                )
            );
        }

        return $this->_apiContext;
    }

   

    public function execute() {
        
        $config = \Tecnotch\Config\Payment::getConfig();
        
        $payee = new Payee();
        $payee
            ->setEmail($this->getEmail())
            ->setFirstName($this->getFirstName())
            ->setLastName($this->getLastName())
            ->setPhone($this->getPhone())
        ;

        $payer = new Payer();
        //Valid Values: ["credit_card", "bank", "paypal", "pay_upon_invoice", "carrier", "alternate_payment"]
        $payer->setPaymentMethod("paypal");


        $itemList = new ItemList();

        $orderDiscountPerItem = $this->getOrderDiscountPerItem();
        
        foreach ($this->getItems() as $item) {

            //paypal item
            $paypalItem = new Item();

            $itemPrice = $item->getPrice() - $item->getDiscount();
            
            //echo '<p>' . $itemPrice . '</p>';

            //if discount given on order instead of items then divide it equally to items

            if ($orderDiscountPerItem) {
                $itemPrice -= $orderDiscountPerItem;
            }
            

            $paypalItem
                ->setName($item->getName())
                //setDescription
                ->setTax( $item->getTax() )
                //setUrl
                //setWeight
                ->setCurrency($config->currency)
                ->setQuantity( $item->getQuantity() )
                ->setSku( $item->getId() ) // Similar to `item_number` in Classic API
                ->setPrice( $itemPrice );

                
            //$item->getDiscount()
            //$item->getShipping()
            //$item->getHandling()
            
            $this->_itemsTotal     += ($itemPrice * $item->getQuantity());
            $this->_itemsTax       += ($item->getTax() * $item->getQuantity());
            $this->_itemsShipping  += ($item->getShipping() * $item->getQuantity());
            $this->_itemsHandling  += ($item->getHandling() * $item->getQuantity());
            $this->_itemsDiscount  += ($item->getDiscount() * $item->getQuantity());
            
            $itemList->addItem($paypalItem);

        }

        echo '<p>Subtotal '     . $this->getSubTotal() . '</p>';
        echo '<p>Shipping '     . $this->getShippingHandling() . '</p>';
        echo '<p>Tax '          . $this->getTax() . '</p>';
        echo '<p>Discount -'    . ($this->getDiscount() + $this->_itemsDiscount) . '</p>';
        echo '<p>Total '        . $this->getTotal() . '</p>';

       
        // set order details
        $orderDetails = new Details();
        $orderDetails
            ->setShipping($this->getShippingHandling())
            ->setTax($this->getTax())
            ->setSubtotal($this->getSubTotal());

        //set order amount

        $amount = new Amount();
        $amount->setCurrency($config->currency)
            ->setTotal($this->getTotal())
            ->setDetails($orderDetails);    

        
        //set transaction
        $transaction = new Transaction();
        $transaction
            ->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($this->getDescription())
            ->setInvoiceNumber($this->getInvoice())
        ;

        //set urls
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->getReturnUrl())
            ->setCancelUrl($this->getCancelUrl());

        
        //creating payment
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
                             
        //creating payment urls
        try {
            $payment->create($this->getApiContext());
            return $payment->getApprovalLink();
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode(); // Prints the Error Code
            echo $ex->getData(); // Prints the detailed error message 
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
         
    }



    public function getTax()
    {
        $tax = $this->_itemsTax + parent::getTax();

        return $tax;
    }

    public function getShippingHandling() 
    {
        $shipping = $this->_itemsShipping + $this->getShipping();

        $handling = $this->_itemsHandling + $this->getHandling();  
                        
        return $shipping + $handling;              

    }

    

    public function getSubTotal()
    {
        $subtotal = $this->_itemsTotal;
        return $subtotal;
    }

    
}