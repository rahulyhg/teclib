<?php
namespace Tecnotch\Payment\Item;
                 
class Subscription extends \Tecnotch\Payment\Item
{
	protected $_noOfPayments;
    protected $_interval;
    protected $_occurrences;
    


    protected $_trialPrice;
    protected $_trialInterval;
    protected $_trialOccurrences;

	protected $_trial2Price;
    protected $_trial2Interval;
    protected $_trial2Occurrences;

    protected $_intervals = array (
            'D' => 'Day',
            'W' => 'WEEK',
            'M' => 'Month',
            'Y' => 'Year',
        );
    

    /* set Tenure */
    public function setNoOfPayments($value) {
        $this->_noOfPayments = $value;
        return $this;
    }

    /* get Tenure */
    public function getNoOfPayments() {
        return $this->_noOfPayments;
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

    /* set Occurrences */
    public function setOccurrences($value) {
        $this->_occurrences = $value;
        return $this;
    }

    /* get Occurrences */
    public function getOccurrences() {
        return $this->_occurrences;
    }

     /* set TrialPrice */
    public function setTrialPrice($value) {
        $this->_trialPrice = $value;
        return $this;
    }

    /* get TrialPrice */
    public function getTrialPrice() {
        return $this->_trialPrice;
    }

    /* set TrialInterval */
    public function setTrialInterval($value) {
        $this->_trialInterval = $value;
        return $this;
    }

    /* get TrialInterval */
    public function getTrialInterval() {
        return $this->_trialInterval;
    }

    /* set TrialOccurrences */
    public function setTrialOccurrences($value) {
        $this->_trialOccurrences = $value;
        return $this;
    }

    /* get TrialOccurrences */
    public function getTrialOccurrences() {
        return $this->_trialOccurrences;
    }

    /* set Trial2Price */
    public function setTrial2Price($value) {
        $this->_trial2Price = $value;
        return $this;
    }

    /* get Trial2Price */
    public function getTrial2Price() {
        return $this->_trial2Price;
    }

    /* set Trial2Interval */
    public function setTrial2Interval($value) {
        $this->_trial2Interval = $value;
        return $this;
    }

    /* get Trial2Interval */
    public function getTrial2Interval() {
        return $this->_trial2Interval;
    }

    /* set Trial2Occurrences */
    public function setTrial2Occurrences($value) {
        $this->_trial2Occurrences = $value;
        return $this;
    }

    /* get Trial2Occurrences */
    public function getTrial2Occurrences() {
        return $this->_trial2Occurrences;
    }

    public function getIntervalAbs()
    {
        if (array_key_exists($this->_interval, $this->_intervals)) {
            return $this->_intervals[$this->_interval];
        }
        return $this->_interval;
    }

    public function getTrialIntervalAbs()
    {
        if (array_key_exists($this->_trialInterval, $this->_intervals)) {
            return $this->_intervals[$this->_trialInterval];
        }
        return $this->_trialInterval;   
    }

    public function getTrial2IntervalAbs()
    {
        if (array_key_exists($this->_trial2Interval, $this->_intervals)) {
            return $this->_intervals[$this->_trial2Interval];
        }
        return $this->_trial2Interval;
    }

}