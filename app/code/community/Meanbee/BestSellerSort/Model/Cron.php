<?php
class Meanbee_BestSellerSort_Model_Cron
{
    public function updateProductsWithQuantitiesOrdered()
    {
        Mage::getModel('meanbee_bestsellersort/attributes')->updateQtyOrdered();
    }
}
