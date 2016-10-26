<?php
namespace Tecnotch\Payment;

abstract class APayment implements IPayment {
    
    protected $_returnUrl;
    protected $_cancelUrl;
    protected $_notifyUrl;
    protected $_shoppingUrl;
    
    protected $_email;
    protected $_firstName;
    protected $_lastName;
    
    protected $_street;
    protected $_city;
    protected $_state;
    protected $_zip;
    protected $_locale;
    protected $_phone;
    
    protected $_weight;

    protected $_description;

    protected $_discount;
    protected $_shipping;
    protected $_tax;
    protected $_handling;
    
    protected $_total;
    protected $_invoice;
    
    
    protected $_params;    
    
    protected $_items;    

    protected $_button;
 
    
    public function setReturnUrl($value) {
        $this->_returnUrl = $value;
        return $this;
    }
    
    public function setCancelUrl($value) {
        $this->_cancelUrl = $value;
        return $this;
    }
    
    public function setNotifyUrl($value) {
        $this->_notifyUrl = $value;
        return $this;
    }
    
    public function setShoppingUrl($value) {
        $this->_shoppingUrl = $value;
        return $this;
    }
    
    
    public function getReturnUrl() {
        return $this->_returnUrl;
    }
    
    public function getCancelUrl() {
        return $this->_cancelUrl;
    }
    
    public function getNotifyUrl() {
        return $this->_notifyUrl;
    }
    
    public function getShoppingUrl() {
        return $this->_shoppingUrl;
    }
    
    
    //personal detail
    public function setEmail($value) {
        $this->_email = $value;
        return $this;
    }
    
    public function setFirstName($value) {
        $this->_firstName = $value;
        return $this;
    }
    
    public function setLastName($value) {
        $this->_lastName = $value;
        return $this;
    }
    
    
    public function getEmail() {
        return $this->_email;
    }
    
    public function getFirstName() {
        return $this->_firstName;
    }
    
    public function getLastName() {
        return $this->_lastName;
    }
    
    
    //personal billing address 
    public function setStreet($value) {
        $this->_street = $value;
        return $this;
    }
    
    public function setCity($value) {
        $this->_city = $value;
        return $this;
    }
    
    public function setState($value) {
        $this->_state = $value;
        return $this;
    }
    
    public function setZip($value) {
        $this->_zip = $value;
        return $this;
    }
    
    public function setLocale($value) {
        $this->_locale = $value;
        return $this;
    }
    
    public function setPhone($value) {
        $this->_phone = $value;
        return $this;
    }
    
    
    
    public function getStreet() {
        return $this->_street;
    }
    
    public function getCity() {
        return $this->_city;
    }
    
    public function getState() {
        return $this->_state;
    }
    
    public function getZip() {
        return $this->_zip;
    }
    
    public function getLocale() {
        return $this->_locale;
    }
    
    public function getPhone($start = 0, $end = 0) {
        if ($start) {
            return substr($this->_phone, $start, $end);
        }
        
        return $this->_phone;
    }
    
    //Cart details
     public function setDescription($value) {
        $this->_description = (string) $value;
        return $this;
    }
    
    public function getDescription() {
        return $this->_description;
    }


    //Cart totals
    public function setDiscount($value) {
        $this->_discount = $value;
        return $this;
    }
    
    public function setShipping($value) {
        $this->_shipping = $value;
        return $this;
    }
    
    public function setHandling($value) {
        $this->_handling = $value;
        return $this;
    }
    
    /* set Tax */
    public function setTax($value) {
        $this->_tax = $value;
        return $this;
    }

    /* get Tax */
    public function getTax() {
        return (int) $this->_tax;
    }
    

    /* set Weight */
    public function setWeight($value) {
        $this->_weight = $value;
        return $this;
    }

   


    public function getDiscount() {
        return (float) $this->_discount;
    }
    
    public function getShipping() {
        return (float) $this->_shipping;
    }
    
    public function getHandling() {
        return (float) $this->_handling;
    }
    
     /* get Weight */
    public function getWeight() {
        return (float) $this->_weight;
    }
    
    
    public function setTotal($value) {
        $this->_total = $value;
        return $this;
    }
    
    public function getTotal() {
        return (float) $this->_total;
    }
    
    public function setInvoice($value) {
        $this->_invoice = $value;
        return $this;
    }
    
    public function getInvoice() {
        return $this->_invoice;
    }
    
    //needed for paypal
    
    public function setParams(array $params) {
        $this->_params = $params;
        return $this;
    }
    
    public function getParams() {
        return $this->_params;
    }
    

    public function setParam($key, $value) {
        $this->_params[$key] = $value;
        return $this;
    }
    
    public function getParam($key) {
        if (isset($this->_params[$key])) {
            return $this->_params[$key];
        } else {
            Error::trigger("No key '$key' found in params");
        }
    }
    
    public function setItems(array $items) {
        foreach ($items as $item) {
            if (! $item instanceof \Tecnotch\Payment\Item) {
                Error::trigger("Item should be an instance of class \Tecnotch\Payment\Item");
            } else {
                $this->addItem($item);
            }
        }
    }
    
    public function getItems() {
        return $this->_items;
    }
    
    public function addItem(\Tecnotch\Payment\Item $item) {
        $this->_items[$item->getId()] = $item;
    }
    
    public function getItem($id) {
        if (isset($this->_items[$id])) {
            return $this->_items[$id];
        } else {
            Error::trigger("No item with id $id found in items");
        }       
    }
 
     /* set Button */
    public function setButton(array $value) {
        $this->_button = $value;
        return $this;
    }

    /* get Button */
    public function getButton() {
        return $this->_button;
    }

   
    public function execute() {
        
    }

     
}
