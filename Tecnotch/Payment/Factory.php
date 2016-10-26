<?php
namespace Tecnotch\Payment;

use Tecnotch\Config as Config;


class Factory {

public static function simplePayment() {
		
		$config = Config\Payment::getConfig();
		
		switch ($config->gateway) {
		    case 'paypal':
		        $gateway = new Paypal\Simple();
		    break;
		    
		    case 'google':
		        $gateway = new Google\Simple();        
		    break;
		    
		     case 'authorize.net':
		        $gateway = new Authorize\Simple();        
		    break;
		    
		     case 'amazon':
		        $gateway = new Amazon\Simple();        
		    break;
		    
		     case 'cybersource':
		        $gateway = new Cybersource\Simple();        
		    break;
		    
		     case 'stripe':
		        $gateway = new Stripe\Simple();        
		    break;
		    default :
		        Messenger::showError("No gateway found, Please configure a correct gateway in config file");
		        return;
		    break;
		}
		
		return $gateway;
	}
	
	
	public static function paymentHook() {
		
		$config = Config\Payment::getConfig();
		
		switch ($config->gateway) {
		    case 'paypal':
		        $gateway = new Paypal\Hook();
		    break;
		    
		    case 'google':
		        $gateway = new Google\Hook();        
		    break;
		    
		     case 'authorize.net':
		        $gateway = new Authorize\Hook();        
		    break;
		    
		     case 'amazon':
		        $gateway = new Amazon\Hook();        
		    break;
		    
		     case 'cybersource':
		        $gateway = new Cybersource\Hook();        
		    break;
		    
		     case 'stripe':
		        $gateway = new Stripe\Hook();        
		    break;
		    default :
		        Messenger::showError("No gateway found, Please configure a correct gateway in config file");
		        return;
		    break;
		}
		
		return $gateway;
	}
	
	
	public static function ApiPayment() {
		
		$config = Config\Payment::getConfig();
		
		switch ($config->gateway) {
		    case 'paypal':
		        $gateway = new Paypal\Api();
		    break;
		    
		    case 'google':
		        $gateway = new Google\Api();        
		    break;
		    
		     case 'authorize.net':
		        $gateway = new Authorize\Api();        
		    break;
		    
		     case 'amazon':
		        $gateway = new Amazon\Api();        
		    break;
		    
		     case 'cybersource':
		        $gateway = new Cybersource\Api();        
		    break;
		    
		     case 'stripe':
		        $gateway = new Stripe\Api();        
		    break;
		    default :
		        Error::trigger("No gateway found, Please configure a correct gateway in config file");
		        return;
		    break;
		}
		
		return $gateway;
	}

	public static function ApiSubscription() {
		
		$config = Config\Payment::getConfig();
		
		switch ($config->gateway) {
		    case 'paypal':
		        $gateway = new Paypal\Api\Subscription( );
		    break;
		    
		    case 'google':
		        $gateway = new Google\Api\Subscription( );        
		    break;
		    
		     case 'authorize.net':
		        $gateway = new Authorize\Api\Subscription( );        
		    break;
		    
		     case 'amazon':
		        $gateway = new Amazon\Api\Subscription( );        
		    break;
		    
		     case 'cybersource':
		        $gateway = new Cybersource\Api\Subscription( );        
		    break;
		    
		     case 'stripe':
		        $gateway = new Stripe\Api\Subscription();        
		    break;
		    default :
		        Error::trigger("No gateway found, Please configure a correct gateway in config file");
		        return;
		    break;
		}
		
		return $gateway;
	}
	
	public static function ApiSubscriptionPlan() {
		
		$config = Config\Payment::getConfig();
		
		switch ($config->gateway) {
		    case 'paypal':
		        $gateway = new Paypal\Api\Subscription\Plan( );
		    break;
		    
		    case 'google':
		        $gateway = new Google\Api\Subscription\Plan( );        
		    break;
		    
		     case 'authorize.net':
		        $gateway = new Authorize\Api\Subscription\Plan( );        
		    break;
		    
		     case 'amazon':
		        $gateway = new Amazon\Api\Subscription\Plan( );        
		    break;
		    
		     case 'cybersource':
		        $gateway = new Cybersource\Api\Subscription\Plan( );        
		    break;
		    
		     case 'stripe':
		        $gateway = new Stripe\Api\Subscription\Plan();        
		    break;
		    default :
		        Error::trigger("No gateway found, Please configure a correct gateway in config file");
		        return;
		    break;
		}
		
		return $gateway;
	}

	public static function simpleSubscription() {
		
		$config = Config\Payment::getConfig();
		
		switch ($config->gateway) {
		    case 'paypal':
		        $gateway = new Paypal\Subscription();
		    break;
		    
		    case 'google':
		        $gateway = new Google\Subscription();        
		    break;
		    
		     case 'authorize.net':
		        $gateway = new Authorize\Subscription();        
		    break;
		    
		     case 'amazon':
		        $gateway = new Amazon\Subscription();        
		    break;
		    
		     case 'cybersource':
		        $gateway = new Cybersource\Subscription();        
		    break;
		    
		     case 'stripe':
		        $gateway = new Stripe\Subscription();        
		    break;
		    default :
		        Messenger::showError("No gateway found, Please configure a correct gateway in config file");
		        return;
		    break;
		}
		
		return $gateway;
	}


	public static function CreditCardProcessor() {
		
		$config = Config\Payment::getConfig();
		
		switch ($config->gateway) {
		    case 'paypal':
		        $gateway = new Paypal\CreditCardProcessor();
		    break;
		    
		    case 'google':
		        $gateway = new Google\CreditCardProcessor();        
		    break;
		    
		     case 'authorize.net':
		        $gateway = new Authorize\CreditCardProcessor();        
		    break;
		    
		     case 'amazon':
		        $gateway = new Amazon\CreditCardProcessor();        
		    break;
		    
		     case 'cybersource':
		        $gateway = new Cybersource\CreditCardProcessor();        
		    break;
		    
		     case 'stripe':
		        $gateway = new Stripe\CreditCardProcessor();        
		    break;
		    default :
		        Error::trigger("No gateway found, Please configure a correct gateway in config file");
		        return;
		    break;
		}
		
		return $gateway;
	}
}