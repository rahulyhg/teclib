<?php
namespace Tecnotch\Payment;

interface IPayment {
    
    public function setReturnUrl($value);
    public function setCancelUrl($value);
    public function setNotifyUrl($value);
    public function setShoppingUrl($value);
    
    public function getReturnUrl();
    public function getCancelUrl();
    public function getNotifyUrl();
    public function getShoppingUrl();
    
    //personal detail
    public function setEmail($value);
    public function setFirstName($value);
    public function setLastName($value);
    
    public function getEmail();
    public function getFirstName();
    public function getLastName();
    
    //personal billing address 
    public function setStreet($value);
    public function setCity($value);
    public function setState($value);
    public function setZip($value);
    public function setLocale($value);
    public function setPhone($value);
    
    
    public function getStreet( );
    public function getCity( );
    public function getState( );
    public function getZip( );
    public function getLocale( );
    public function getPhone( );
    
    //cart
    public function setDescription($value);
    public function getDescription();

    //Cart totals
    public function setDiscount($value);
    public function setShipping($value);
    public function setHandling($value);
    public function setTax($value);
    public function setWeight($value);
    
    
    public function getDiscount();
    public function getShipping();
    public function getHandling();
    public function getTax();    
    public function getWeight();
    
    public function setTotal($value);
    public function getTotal();
    
    //needed for paypal
    
    public function setParams(array $params);
    public function getParams();

    public function setParam($key, $value);
    public function getParam($key);

    public function setItems(array $items);
    public function getItems();
    
    public function addItem(\Tecnotch\Payment\Item $item);
    public function getItem($id);
    
    public function setInvoice($value);
    public function getInvoice();
    
    public function execute();


    public function setButton(array $array);
    
}
