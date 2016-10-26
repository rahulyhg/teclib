<?php
namespace Tecnotch\Payment\Item\Subscription;
use Tecnotch\Payment as Payment;
                 
class APlan extends Payment\APayment implements IPlan
{
	protected $_name;
    protected $_description;
    protected $_numberOfPayments;
    protected $_setupFee;
    protected $_type;
    protected $_terms = array();
    protected $_state;

    /* set State */
    public function setState($value) {
        $this->_state = $value;
        return $this;
    }

    /* get State */
    public function getState() {
        return $this->_state;
    }


    /* set Terms */
    public function setTerms(array $value) {
        $this->_terms = $value;
        return $this;
    }

    /* get Terms */
    public function getTerms() {
        return $this->_terms;
    }

    /* set Terms */
    public function addTerm(\Tecnotch\Payment\Item\Subscription\Plan\Term $term) {
        $this->_terms[] = $term;
        return $this;
    }

    /* get Terms */
    public function getTerm($id) {
        foreach ($this->_terms as $term) {
        	if ($term->getId() == $id) {
        		return $term;
        	}
        }
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

    /* set Name */
    public function setName($value) {
        $this->_name = $value;
        return $this;
    }

    /* get Name */
    public function getName() {
        return $this->_name;
    }

    /* set Description */
    public function setDescription($value) {
        $this->_description = $value;
        return $this;
    }

    /* get Description */
    public function getDescription() {
        return $this->_description;
    }


    /* set SetupFee */
    public function setSetupFee($value) {
        $this->_setupFee = $value;
        return $this;
    }

    /* get SetupFee */
    public function getSetupFee() {
        return $this->_setupFee;
    }


}