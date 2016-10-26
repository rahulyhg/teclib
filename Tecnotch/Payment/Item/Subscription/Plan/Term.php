<?php
namespace Tecnotch\Payment\Item\Subscription\Plan;

class Term {
	protected $_id;
    protected $_name;
    protected $_interval;
    protected $_occurrences;
    protected $_price;
    protected $_type;
    protected $_noOfPayments;

    protected $_intervalsAbs = array (
            'D' => 'Day',
            'W' => 'WEEK',
            'M' => 'Month',
            'Y' => 'Year',
        );

    /* set NoOfPayments */
    public function setNoOfPayments($value) {
        $this->_noOfPayments = $value;
        return $this;
    }

    /* get NoOfPayments */
    public function getNoOfPayments() {
        return $this->_noOfPayments;
    }

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

    /* set Interval */
    public function setInterval($value) {
        $this->_interval = $value;
        return $this;
    }

    /* get Interval */
    public function getInterval() {
        return $this->_interval;
    }
    

    /* get Interval Abs */
    public function getIntervalAbs() {
        if (array_key_exists($this->_interval, $this->_intervalsAbs)) {
            return $this->_intervalsAbs[$this->_interval];
        }
        return $this->_interval;
    }

    /* set Occurrences */
    public function setOccurrences($value) {
        $this->_occurrences = $value;
        return $this;
    }

    /* get Occurrences */
    public function getOccurrences() {
        return $this->_occurrences;
    }

    /* set Amount */
    public function setPrice($value) {
        $this->_price = $value;
        return $this;
    }

    /* get Amount */
    public function getPrice() {
        return $this->_price;
    }

    /* set Type */
    public function setType($value) {
        $this->_type = $value;
        return $this;
    }

    /* get Type */
    public function getType() {
        return $this->_type;
    }

}