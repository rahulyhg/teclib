<?php

namespace Tecnotch\Payment;

class CreditCard {

    protected $_type;
    protected $_number;
    protected $_expireMonth;
    protected $_expireYear;
    protected $_securityCode;
    protected $_firstName;
    protected $_lastName;

    protected $_id;
    protected $_state;
    protected $_validUntil;
    protected $_createTime;
    protected $_updateTime;

    /* set Type */
    public function setType($value) {
        $this->_type = (string) $value;
        return $this;
    }

    /* get Type */
    public function getType() {
        return $this->_type;
    }

    /* set Number */
    public function setNumber($value) {
        $this->_number = (string) $value;
        return $this;
    }

    /* get Number */
    public function getNumber() {
        return $this->_number;
    }

    /* set ExpireMonth */
    public function setExpireMonth($value) {
        $this->_expireMonth = (string) $value;
        return $this;
    }

    /* get ExpireMonth */
    public function getExpireMonth() {
        return $this->_expireMonth;
    }

    /* set ExpireYear */
    public function setExpireYear($value) {
        $this->_expireYear = (string) $value;
        return $this;
    }

    /* get ExpireYear */
    public function getExpireYear() {
        return $this->_expireYear;
    }

    /* set SecurityCode */
    public function setSecurityCode($value) {
        $this->_securityCode = (string) $value;
        return $this;
    }

    /* get SecurityCode */
    public function getSecurityCode() {
        return $this->_securityCode;
    }

    /* set FirstName */
    public function setFirstName($value) {
        $this->_firstName = (string) $value;
        return $this;
    }

    /* get FirstName */
    public function getFirstName() {
        return $this->_firstName;
    }

    /* set LastName */
    public function setLastName($value) {
        $this->_lastName = (string) $value;
        return $this;
    }

    /* get LastName */
    public function getLastName() {
        return $this->_lastName;
    }

    /* set Id */
    public function setId($value) {
        $this->_id = (string) $value;
        return $this;
    }

    /* get Id */
    public function getId() {
        return $this->_id;
    }

    /* set State */
    public function setState($value) {
        $this->_state = (string) $value;
        return $this;
    }

    /* get State */
    public function getState() {
        return $this->_state;
    }

    /* set ValidUntil */
    public function setValidUntil($value) {
        $this->_validUntil = (string) (string) $value;
        return $this;
    }

    /* get ValidUntil */
    public function getValidUntil() {
        return $this->_validUntil;
    }

    /* set CreateTime */
    public function setCreateTime($value) {
        $this->_createTime = (string) $value;
        return $this;
    }

    /* get CreateTime */
    public function getCreateTime() {
        return $this->_createTime;
    }

    /* set UpdateTime */
    public function setUpdateTime($value) {
        $this->_updateTime = (string) $value;
        return $this;
    }

    /* get UpdateTime */
    public function getUpdateTime() {
        return $this->_updateTime;
    }


}