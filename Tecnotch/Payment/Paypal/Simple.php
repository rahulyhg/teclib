<?php
namespace Tecnotch\Payment\Paypal;
$pear_path = realpath(__DIR__ . '/../../../pear/share/pear'); 

        
set_include_path($pear_path . PATH_SEPARATOR . get_include_path());
                 
class Simple extends \Tecnotch\Payment\APayment
{
    public function getFormAction($config) {
        
        if ($config->mode == 'test') {
            return 'https://www.sandbox.paypal.com/cgi-bin/webscr';            
        } else {
            return 'https://www.paypal.com/cgi-bin/webscr';
        }

    }
    
    
    public function execute() {
        
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
        
    
        
        $fieldset->addElement($inputType, 'shopping_url', array(
            'value' => $this->getShoppingUrl()
        )) ->setLabel('shopping_url');
        
         
        
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
        
       
        
        $fieldset->addElement($inputType, 'handling', array(
            'value' => $this->getHandling()
        )) ->setLabel('handling');
        
        $fieldset->addElement($inputType, 'tax_cart', array(
            'value' => $this->getTax()
        )) ->setLabel('tax_cart');
        
        $fieldset->addElement($inputType, 'weight_cart', array(
            'value' => $this->getWeight()
        )) ->setLabel('weight_cart');
        
        $fieldset->addElement($inputType, 'weight_unit', array(
            'value' => $config->weight_unit
        )) ->setLabel('weight_unit');
        
        /* This variable overrides any individual item discount_amount_x values, 
           if present. 
        */
        
        if ($this->getDiscount()) {
            $fieldset->addElement($inputType, 'discount_amount_cart', array(
                'value' => $this->getDiscount()
            )) ->setLabel('discount_amount_cart');    
        }
         
        $fieldset->addElement($inputType, 'amount', array(
            'value' => $this->getTotal()
        )) ->setLabel('amount');
          
        $fieldset->addElement($inputType, 'shipping2', array(
            'value' => $this->getShipping()
        )) ->setLabel('shipping2');
          
       
        /** items */   
          
          
        $n = 0;
        foreach ($this->getItems() as $item) {
           
           $n ++; 
            
           $fieldset->addElement($inputType, 'amount_' . $n, array(
                'value' => $item->getPrice()
           )) ->setLabel('amount_' . $n);
           
     
           $fieldset->addElement($inputType, 'item_name_' . $n, array(
                'value' => $item->getName()
           )) ->setLabel('item_name_' . $n);
           
           $fieldset->addElement($inputType, 'item_number_' . $n, array(
                'value' => $item->getId()
           )) ->setLabel('item_number_' . $n);
           
      

           $fieldset->addElement($inputType, 'quantity_' . $n, array(
                'value' => $item->getQuantity()
           )) ->setLabel('quantity_' . $n);
         
           
           $fieldset->addElement($inputType, 'discount_amount_' . $n, array(
                'value' => $item->getDiscount()
           )) ->setLabel('discount_amount_' . $n);
           
           $fieldset->addElement($inputType, 'tax_' . $n, array(
                'value' => $item->getTax()
           )) ->setLabel( 'tax_' . $n);

           $fieldset->addElement($inputType, 'shipping_' . $n, array(
                'value' => $item->getShipping()
           )) ->setLabel('shipping_' . $n);

           $fieldset->addElement($inputType, 'handling_' . $n, array(
                'value' => $item->getHandling()
           )) ->setLabel('handling_' . $n);
            
        }
                         
        
        foreach ($this->getParams() as $key => $val) {
           $fieldset->addElement($inputType, $key, array(
                'value' => $val
           )) ->setLabel($key);
        }       
                  
        //$fieldset->addElement('submit', null, array('value' => 'Pay'));
        if ($this->getButton()) {
            $fieldset->addElement('submit', null, $this->getButton());    
        }
        
        // Output the form
        return $form;
    }
}
