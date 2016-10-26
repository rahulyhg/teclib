<?php
namespace Tecnotch\Payment\Paypal;
use \Tecnotch\Payment as Payment;

$pear_path = realpath(__DIR__ . '/../../../pear/share/pear'); 
 
set_include_path($pear_path . PATH_SEPARATOR . get_include_path());
                 
class Subscription extends Payment\ASubscription implements Payment\ISubscription
{
    public function getFormAction($config) {
        
        if ($config->mode == 'test') {
            return 'https://www.sandbox.paypal.com/cgi-bin/webscr';            
        } else {
            return 'https://www.paypal.com/cgi-bin/webscr';
        }

    }
    

    
    public function execute() {

        $this
            ->setParam('cmd', '_xclick-subscriptions')
            ->setParam('no_shipping', 1)
            ->setParam('src', 1)
            ->setParam('sra', 1);

        
        $inputType = "hidden";
        
        $config = \Tecnotch\Config\Payment::getConfig();
        
        // Load the main class
        require_once 'HTML/QuickForm2.php';

        $attribs['action'] = $this->getFormAction($config);
        
        // Instantiate the HTML_QuickForm2 object
        $form = new \HTML_QuickForm2('paypal', 'post', $attribs);

        // Set defaults for the form elements
        $form->addDataSource(new \HTML_QuickForm2_DataSource_Array(array(
            'name' => 'Tecnotch Dev.'
        ))) ;
        
        // Add some elements to the form
        
        
        $fieldset = $form->addElement('fieldset');
            
            
        
        
        
        $fieldset->addElement($inputType, 'charset', array(
            'value' => 'utf-8'
        )) ->setLabel('charset');
        
            
        $fieldset->addElement($inputType, 'notify_url', array(
            'value' => $this->getNotifyUrl()
        )) ->setLabel('notify_url');
        
        $fieldset->addElement($inputType, 'return', array(
            'value' => $this->getReturnUrl()
        )) ->setLabel('return');
        
        $fieldset->addElement($inputType, 'cancel_return', array(
            'value' => $this->getCancelUrl()
        )) ->setLabel('cancel_return');
        
        $fieldset->addElement($inputType, 'currency_code', array(
            'value' => $config->currency
        )) ->setLabel('currency_code');
       
         
       
        
        $fieldset->addElement($inputType, 'invoice', array(
            'value' => $this->getInvoice()
        )) ->setLabel('invoice');
        
        
        $fieldset->addElement($inputType, 'business', array(
            'value' => $config->merchant_email
        )) ->setLabel('business');
        
    
        
       
        
        $fieldset->addElement($inputType, 'first_name', array(
            'value' => $this->getFirstName()
        )) ->setLabel('first_name');
        
        $fieldset->addElement($inputType, 'last_name', array(
            'value' => $this->getLastName()
        )) ->setLabel('last_name');
        
        $fieldset->addElement($inputType, 'address1', array(
            'value' => $this->getStreet()
        )) ->setLabel('address1');
        
       
        $fieldset->addElement($inputType, 'city', array(
            'value' => $this->getCity()
        )) ->setLabel('city');
        
        $fieldset->addElement($inputType, 'state', array(
            'value' => $this->getState()
        )) ->setLabel('state');
        
        $fieldset->addElement($inputType, 'zip', array(
            'value' => $this->getZip()
        )) ->setLabel('zip');
        
        $fieldset->addElement($inputType, 'night_phone_a', array(
            'value' => $this->getPhone(1, 3)
        )) ->setLabel('night_phone_a');
        
        $fieldset->addElement($inputType, 'night_phone_b', array(
            'value' => $this->getPhone(3, 3)
        )) ->setLabel('night_phone_b');
        
        $fieldset->addElement($inputType, 'night_phone_c', array(
            'value' => $this->getPhone(7, 4)
        )) ->setLabel('night_phone_c');
        
        $fieldset->addElement($inputType, 'email', array(
            'value' => $this->getEmail()
        )) ->setLabel('email');
        
 
         /** items */   
          
          
        foreach ($this->getItems() as $item) {
           
            /* subscription related vars */

            $fieldset->addElement($inputType, 'item_name', array(
                'value' => $item->getName()
            )) ->setLabel('Susbcription plan name');



            /* tenures */
            $fieldset->addElement($inputType, 'a3', array(
                'value' => $item->getPrice()
            )) ->setLabel('Amount');

            $fieldset->addElement($inputType, 'p3', array(
                'value' => $item->getOccurrences()
            )) ->setLabel('Occurences/Repeat every ...');

            $fieldset->addElement($inputType, 't3', array(
                'value' => $item->getInterval()
            )) ->setLabel('Timeperiod/Interval');

            /** handling no of payments **/

            if ($item->getNoOfPayments()) {
                $fieldset->addElement($inputType, 'srt', array(
                    'value' => $item->getNoOfPayments()
                )) ->setLabel('Total No of payments');
            }

            /** handling trial period  */
            if ($item->getTrialInterval()) {

                $fieldset->addElement($inputType, 'a1', array(
                    'value' => $item->getTrialPrice()
                )) ->setLabel('Trial Price');

                $fieldset->addElement($inputType, 'p1', array(
                    'value' => $item->getTrialOccurrences()
                )) ->setLabel('How many time trial occurs in d,m or y');

                $fieldset->addElement($inputType, 't1', array(
                    'value' => $item->getTrialInterval()
                )) ->setLabel('Trial to occurr on d, m or y');


                if ($item->getTrial2Interval()) {
                     
                    $fieldset->addElement($inputType, 'a2', array(
                        'value' => $item->getTrial2Price()
                    )) ->setLabel('Trial 2 Price');

                    $fieldset->addElement($inputType, 'p2', array(
                        'value' => $item->getTrial2Occurrences()
                    )) ->setLabel('How many time trial 2 occurs in d,m or y');

                    $fieldset->addElement($inputType, 't2', array(
                        'value' => $item->getTrial2Interval()
                    )) ->setLabel('Trial 2 to occurr on d, m or y');

                }
            }

        }



       

        /** custom params **/        
        foreach ($this->getParams() as $key => $val) {
           $fieldset->addElement($inputType, $key, array(
                'value' => $val
           )) ->setLabel($key);
        }       
                  
        if ($this->getButton()) {
            $fieldset->addElement('submit', null, $this->getButton());    
        }
        
        // Output the form
        return $form;
    }
}
