<?php
class Payment_Resource_AuthorizeNet_Recurring_Arb extends Payment_Model_AuthorizeNetArb 
{
	
	public function __construct($options = null)
	{
		
	}
	
	public function createProfile()
	{

		//build xml to post
		$content =
		        "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
		        "<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
		        "<merchantAuthentication>".
		        "<name>" . $this->getUsername() . "</name>".
		        "<transactionKey>" . $this->getPassword() . "</transactionKey>".
		        "</merchantAuthentication>".
				"<refId>" . $this->getOrderId() . "</refId>".
		        "<subscription>".
		        "<name>" . $this->getDescription() . "</name>".
		        "<paymentSchedule>".
		        "<interval>".
		        "<length>". $this->getRecurringInterval() ."</length>".
		        "<unit>". $this->getRecurringPeriod() ."</unit>".
		        "</interval>".
		        "<startDate>" . $this->getRecurringStartDate() . "</startDate>".
		        "<totalOccurrences>". $this->getTotalRecurrings() . "</totalOccurrences>".
		        "<trialOccurrences>". $this->getTrialRecurrings() . "</trialOccurrences>".
		        "</paymentSchedule>".
		        "<amount>". $this->getAmount() ."</amount>".
		        "<trialAmount>" . $this->getTrialAmount() . "</trialAmount>".
		        "<payment>".
		        "<creditCard>".
		        "<cardNumber>" . $this->getCreditCardNumber() . "</cardNumber>".
		        "<expirationDate>" . $this->getCreditCardExpiry() . "</expirationDate>".
		        "</creditCard>".
		        "</payment>".
		        "<billTo>".
		        "<firstName>". $this->getFirstName() . "</firstName>".
		        "<lastName>" . $this->getLastName() . "</lastName>".
		        "</billTo>".
		        "</subscription>".
		        "</ARBCreateSubscriptionRequest>";
		
		
		
		if ($this->getMode() == 'sandbox') {
			$host = "apitest.authorize.net";
		} else {
			$host = "api.authorize.net";
		}
		
		//echo $content; die;
		
		$path = $this->getPath();
		
		//send the xml via curl
		$response = send_request_via_curl($host, $path, $content);
		
		//if curl is unavilable you can try using fsockopen
		/*
		$response = send_request_via_fsockopen($host,$path,$content);
		*/
		
		
		//if the connection and send worked $response holds the return from Authorize.net
		if ($response)
		{
				/*
			a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
			please explore using SimpleXML in php 5 or xml parsing functions using the expat library
			in php 4
			parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
			*/
			
			return parse_return($response);
		
			
			
			
		
			
		}
		else
		{
			echo "Transaction Failed. <br>";
		}
	}
}