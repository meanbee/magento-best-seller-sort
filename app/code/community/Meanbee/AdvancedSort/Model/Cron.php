<?php
class Meanbee_AdvancedSort_Model_Cron
{
    public function updateProductsWithQuantitiesOrdered()
    {
        Mage::getModel('meanbee_advancedsort/attributes')->updateQtyOrdered();
    }
}
