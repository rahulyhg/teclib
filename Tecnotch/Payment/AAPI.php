<?php
namespace Tecnotch\Payment;

abstract class AAPI extends APayment implements IAPI {
	
    public function getOrderDiscountPerItem()
    {
        if (!$this->getDiscount()) {
            return 0;
        }

        //if discount given on order instead of items then divide it equally to items
        $items = 0;
        
        foreach ($this->getItems() as $item) {
            $items += $item->getQuantity();
        }

        return $this->getDiscount() / $items;
            
    }

    public function getTotal() {

        $total = $this->getSubTotal()
         + $this->getShippingHandling()
         + $this->getTax();
          
         
        return $total;
    }
}
