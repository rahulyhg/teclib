<?php
namespace Tecnotch\Payment;

class Item {
    
    protected $_id;
    protected $_name;
    protected $_quantity;
    protected $_price;
    protected $_tax;
    protected $_shipping;
    protected $_handling;
    protected $_discount;

    /* set Id */
    public function setId($value) {
        $this->_id = $value;
        return $this;
    }

    /* get Id */
    public function getId() {
        return $this->_id;
    }

    /* set Name */
    public function setName($value) {
        $this->_name = $value;
        return $this;
    }

    /* get Name */
    public function getName() {
        return $this->_name;
    }

    /* set Quantity */
    public function setQuantity($value) {
        $this->_quantity = $value;
        return $this;
    }

    /* get Quantity */
    public function getQuantity() {
        return $this->_quantity;
    }

    /* set Price */
    public function setPrice($value) {
        $this->_price = $value;
        return $this;
    }

    /* get Price */
    public function getPrice() {
        return $this->_price;
    }

    /* set Tax */
    public function setTax($value) {
        $this->_tax = $value;
        return $this;
    }

    /* get Tax */
    public function getTax() {
        return $this->_tax;
    }

    /* set Shipping */
    public function setShipping($value) {
        $this->_shipping = $value;
        return $this;
    }

    /* get Shipping */
    public function getShipping() {
        return $this->_shipping;
    }

    /* set Handling */
    public function setHandling($value) {
        $this->_handling = $value;
        return $this;
    }

    /* get Handling */
    public function getHandling() {
        return $this->_handling;
    }

    /* set Discount */
    public function setDiscount($value) {
        $this->_discount = $value;
        return $this;
    }

    /* get Discount */
    public function getDiscount() {
        return $this->_discount;
    }

    
} 
