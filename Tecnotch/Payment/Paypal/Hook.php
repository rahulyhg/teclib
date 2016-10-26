<?php
namespace Tecnotch\Payment\Paypal;
use Tecnotch as Tecnotch;
use Tecnotch\Logger as Logger;

                 
class Hook implements \Tecnotch\Payment\IHook {
    
    const VALID = 'VERIFIED';
    const INVALID = 'INVALID';

    private $_data;

    private $_localCertificates = true;


    public function getVerificationUrl()
    {
        $config = \Tecnotch\Config\Payment::getConfig();
        if ($config->mode == 'test') {
            return 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';            
        } else {
            return 'https://ipnpb.paypal.com/cgi-bin/webscr';
        }
    }
    
    
    
    /**
     * Verification Function
     * Sends the incoming post data back to paypal using the cURL library.
     *
     * @return bool
     * @throws Exception
     */
    public function verify()
    {
        if ( ! count($_POST)) {
           // Logger::log("Missing POST Data");
            return ;
        }

        $this->_data = $_POST;
        
        //Logger::log("Matching POST Data");
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = [];
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        //Logger::log("Sending to curl");
        // Post the data back to paypal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->getVerificationUrl());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        if ($this->_localCertificates) {
        	//Logger::log("Loading certs");
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . "/cert/cacert.pem");
        }


        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close']);
        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];

        //Logger::log("Http code $http_code");
        if ($http_code != 200) {
            //Logger::log("PayPal responded with http code $http_code");
            die();
        }


        if ( ! ($res)) {
        	//Logger::log("Results not found");
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            //Logger::log("cURL error: [$errno] $errstr");
        }
        curl_close($ch);
        // Check if paypal verfifes the IPN data, and if so, return true.

       //Logger::log($res);


        if ($res == self::VALID) {
        	//Logger::log("Return true");	
            return true;
        } else {
        	//Logger::log("Return false");	
            return false;
        }
    }

    
    public function getData()
    {
        return $this->_data;
    }
    
    public function getTransactionId()
    {
        return $this->_data['txn_id'];
    }
    
    public function getAmount()
    {
        if ($this->_data['txn_type'] == 'subscr_signup') {
            return $this->_data['amount3'];    
        }

        return $this->_data['mc_gross'];
    }   
    
    public function getTrialAmount2()
    {
        return $this->_data['amount2'];    
    }

    public function getTrialAmount()
    {
        return $this->_data['amount1'];    
    }

    public function getCurrency()
    {
        return $this->_data['mc_currency'];
    } 
    
    public function getCustom()
    {
        return $this->_data['custom'];
    }
    
    public function getInvoice()
    {
        return $this->_data['invoice'];
    }
    
    public function getPaymentStatus()
    {
        return $this->_data['payment_status'];
    }
    

    public function getNoOfPayments()
    {
        return $this->_data['recur_times'];
    }
    
    public function getSubscriptionDate()
    {
        return $this->_data['subscr_date'];
    }


    public function verifyPayment()
    {
        $res = $this->verify();
        if ($res === true) {
            if (in_array($this->getPaymentStatus(), array(
                    'Pending',
                    'Completed'
                ))) {
                    return true;
            } else {
                return array('payment_status' => $this->getPaymentStatus());
            }
            
        } else {
            array("verificiation_error" => $res);
        }
    } 
    


    // Check that the payment_status is Completed
	// Check that txn_id has not been previously processed
	// Check that receiver_email is your Primary PayPal email
	// Check that payment_amount/payment_currency are correct
	// Process payment

    public function verifySubscription()
    {   
        $res = $this->verify();

        if ($res === true) {
            if ($this->_data['txn_type'] == 'subscr_signup') {
                if (isset($this->_data['subscr_id'])) {
                    return $this->_data['subscr_id'];
                }
            }
        }

        return false;
    }
}
