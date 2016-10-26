<?php
class Payment_Resource_AuthorizeNet_Checkout_Aim extends Payment_Model_AuthorizeNetApi 
{
	private $_transaction;
	
	public function __construct($options = null)
	{
		$this->setUsername($options['loginId']);
		$this->setPassword($options['password']);
			
		$this->_transaction = new AuthorizeNetAIM(
			$this->getUsername()
			, $this->getPassword()
		);	
		
		$this->_transaction->setSandbox(
			empty($options['mode']) ? false : true
		);
	}
	
	public function authorize()
	{
		return $this->_transaction->authorizeOnly(
			$this->getAmount(), $this->getCreditCardNumber(), $this->getCreditCardExpiry()
		);
	}
	
	public function capture()
	{
		return $this->_transaction->priorAuthCapture($this->getTransactionId(), $this->getAmount());
	}
	
	public function void()
	{
		return $this->_transaction->void($this->getTransactionId());
	}
	
	public function refund()
	{
		//echo '<pre>'; echo ($this->getTransactionId() . " " . $this->getAmount() . " " . $this->getCreditCardNumber()); echo '</pre>';
		
		return $this->_transaction->credit($this->getTransactionId(), $this->getAmount(), $this->getCreditCardNumber());
	}
}