<?php
namespace Tecnotch\Payment\Paypal\Api\Subscription;

use \Tecnotch as Tecnotch;
use Tecnotch\Logger as Logger;
use Tecnotch\Payment\Item\Subscription as Subscription;

require TECNOTCH_PATH  . '/Payment/lib/Paypal/vendor/autoload.php';

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan as PaypalPlan;

use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;


class Plan Extends Subscription\APlan
{
	private $_apiContext;

	public function setApiContext(\PayPal\Rest\ApiContext $context)
    {
        $this->_apiContext = $context;
        return $this;    
    }

    public function getApiContext()
    {
        if (!$this->_apiContext) {
            
            $config = \Tecnotch\Config\Payment::getConfig();

            $this->_apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    $config->api_key,     // ClientID
                    $config->api_secret      // ClientSecret
                )
            );

            
            $this->_apiContext->setConfig(
                array(
                    'log.LogEnabled' => true,
                    'log.FileName' => Logger::getDir() . Logger::$logFile,
                    'log.LogLevel' => 'DEBUG'
                )
            );
        }

        return $this->_apiContext;
    }

	public function execute() {

		$config = \Tecnotch\Config\Payment::getConfig();
		
		$plan = new PaypalPlan();
        $plan
        	->setName($this->getName())
		    ->setDescription($this->getDescription())
		    //Type of the billing plan. Allowed values: `FIXED`, `INFINITE`.
		    ->setType($this->getType());	

		$paymentDefinitions = array();
		
		foreach ($this->getTerms() as $item) {
           
            $paymentDefinition = new PaymentDefinition();

			$paymentDefinition
				->setName($item->getName())
				//Type of the payment definition. Allowed values: `TRIAL`, `REGULAR`.
			    ->setType($item->getType())
			    ->setFrequency($item->getIntervalAbs())
			    ->setFrequencyInterval($item->getOccurrences())
			    ->setCycles($item->getNoOfPayments())
			    ->setAmount(new Currency(
			    		array(
			    			'value' => $item->getPrice(), 
			    			'currency' => $config->currency
			    		)
			    	)
			    );

            
            /* 
 			$chargeModel = new ChargeModel();
			$chargeModel->setType('SHIPPING')
			    ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));
			$paymentDefinition->setChargeModels(array($chargeModel));
			*/
			$paymentDefinitions[] = $paymentDefinition;
		}
		
		//print_r($paymentDefinitions); die;

		$merchantPreferences = new MerchantPreferences();
		$merchantPreferences
			->setReturnUrl($this->getReturnUrl())
		    ->setCancelUrl($this->getCancelUrl())
		    ->setAutoBillAmount("yes")
		    ->setInitialFailAmountAction("CONTINUE")
		    ->setMaxFailAttempts("0")
		    ->setSetupFee(
		    	new Currency(
		    		array(
		    			'value' => $this->getSetupFee(), 
		    			'currency' => $config->currency
		    		)
		    	)
		    );

		//echo '<pre>'; print_r($paymentDefinitions); 

		$plan->setPaymentDefinitions($paymentDefinitions);
		$plan->setMerchantPreferences($merchantPreferences);

		try {
		    $plan = $plan->create($this->getApiContext());
		    Logger::log($plan);
		    return $plan;
		} catch (Exception $ex) {
			print_r($ex->getMessage());
		}    
    }


    public function getPlan($planId)
    {
    	return PaypalPlan::get($planId, $this->getApiContext());
    }


    public function activatePlan($planId)
    {
    	try {
		    $patch = new Patch();

		    $value = new PayPalModel('{
			       "state":"ACTIVE"
			     }');

		    $patch->setOp('replace')
		        ->setPath('/')
		        ->setValue($value);

		    $patchRequest = new PatchRequest();
		    $patchRequest->addPatch($patch);

		    $plan = $this->getPlan($planId);
		    $plan->update($patchRequest, $this->getApiContext());

		    $plan = PaypalPlan::get($plan->getId(), $this->getApiContext());
		    return $plan;
		} catch (Exception $ex) {
			Logger::log($ex->getMessage());
		}
    }


    public function update($planId)
    {
    	$config = \Tecnotch\Config\Payment::getConfig();
		
    	try {

		    $patchRequest = new PatchRequest();
		    if (1) {
			    $patch = new Patch();
			    $value = new PayPalModel('{
				       "state":"' . $this->getState() . '",
				       "name" : "' . $this->getName() . '",
				       "description" : "' . $this->getDescription() . '"
				     }');


			    $patch->setOp('replace')
			        ->setPath('/')
			        ->setValue($value);
			    $patchRequest->addPatch($patch);
		    }

		    //updating setup fee
		    if ( $this->getSetupFee()) {
		    	$patch = new Patch();
			    $patch->setOp('replace')
			        ->setPath('/merchant-preferences')
			        ->setValue('{"setup-fee" :
				            {
								"currency": "' . $config->currency . '",
								"value": "' . $this->getSetupFee() . '"
				            }
				        }'
			        );

				$patchRequest->addPatch($patch);
		    }

		    //updating terms

		    if (0 && count($this->getTerms())) {    
			    foreach ($this->getTerms() as $term) {
			    	$Patch = new Patch();

				    $patch->setOp('replace')
				        ->setPath('/payment-definitions/' . $term->getId())
				        ->setValue(json_decode(
				            '{
				                    "name": "' . $term->getName() . '",
				                    "frequency": "' . $term->getIntervalAbs() . '",
				                    "frequency-intervals": "' . $term->getOccurrences() . '",
				                    "cycles": "' . $term->getNoOfPayments() . '",
				                    "amount": {
				                        "currency": "' . $config->currency . '",
				                        "value": "' . $term->getPrice() . '"
				                    }
				            }'
				        ));

				    $patchRequest->addPatch($patch);
		
			    }
		    }


		    $plan = $this->getPlan($planId);
		    $plan->update($patchRequest, $this->getApiContext());

		    $plan = PaypalPlan::get($planId, $this->getApiContext());
		    return $plan;

		} catch (Exception $ex) {
			Logger::log($ex->getMessage());
		}
    }
}