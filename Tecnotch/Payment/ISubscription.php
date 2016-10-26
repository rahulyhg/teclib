<?php
namespace Tecnotch\Payment;

abstract class ASubscription extends APayment implements ISubscription {
	
	protected $_setupFee;
	
	public function setSetupFee($value)
	{
		$this->_setupFee = (float) $value;
		return $this;
	}

	public function getSetupFee()
	{
		return (float) $this->_setupFee;
	}


}