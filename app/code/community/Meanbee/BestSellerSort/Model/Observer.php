<?php

class Meanbee_BestSellerSort_Model_Observer {
    public function catalogProductSaveBefore($observer) {
        $qtyOrdered = $observer->getDataObject()->getQtyOrdered();
        if($qtyOrdered || $qtyOrdered === "0") {
            return;
        }
        $observer->getDataObject()->setQtyOrdered(0);
    }
}