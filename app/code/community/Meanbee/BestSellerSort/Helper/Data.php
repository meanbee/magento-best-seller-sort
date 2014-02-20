<?php

class Meanbee_BestSellerSort_Helper_Data extends Mage_Core_Helper_Abstract
{
    const ATTRIBUTE_NAME_QTY_ORDERED = 'bestseller';
    const XML_PATH_QTY_ORDERED_AGE   = 'meanbee_bestsellersort/general/qty_ordered_age';

    /**
     * Get age of orders that should be looked for when updating qty ordered values.
     * @return int
     */
    public function getQtyOrderedAge() {
        return (int) Mage::getStoreConfig(self::XML_PATH_QTY_ORDERED_AGE);
    }
}
