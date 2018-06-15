<?php
class Meanbee_BestSellerSort_Model_Attributes extends Mage_Core_Model_Abstract
{
    /**
     * @return $this
     */
    public function updateQtyOrdered()
    {
        /** @var Mage_Catalog_Model_Resource_Product $resource */
        $resource = Mage::getResourceSingleton('catalog/product');

        /** @var Meanbee_BestSellerSort_Helper_Data $helper */
        $helper = Mage::helper('meanbee_bestsellersort');

        /**
         * We need to ensure all product have zero-values first
         *
         * - Avoids old data affecting results
         * - Avoids nulls being shown before all products when ordered ascendingly
         */
        $productCollection = Mage::getResourceModel('catalog/product_collection')
                           ->addAttributeToFilter(Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED,
                               array('neq' => 0)
                           );

        foreach($productCollection as $product) {
            $product->setData(Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED, 0);
            $resource->saveAttribute($product, Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED);
        }

        /**
         * Now go through sold products and set sold counts in qty_ordered
         * We convert to negative numbers so that with the default ordering of ASC,
         * the most popular products are shown first
         */

        $productIds = Mage::getModel('catalog/product')->getCollection()->getAllIds();
        /* @var $soldCollection Mage_Reports_Model_Mysql4_Product_Collection */
        $soldCollection = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty($this->_getFromDate($helper->getQtyOrderedAge()), $this->_getToday());

        foreach($soldCollection as $product) {
            // check if the product still exists as it could have been removed in the meantime
            if (in_array($product->getEntityId(), $productIds)) {
                $product->setData(Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED, -((int)$product->getData('ordered_qty')));
                $resource->saveAttribute($product, Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED);
            }
        }

        $this->_updateFlatProductTable(Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED);

        return $this;
    }

    /**
     * @param $attributeCode
     * @return $this
     */
    protected function _updateFlatProductTable($attributeCode)
    {
        $indexer = Mage::getResourceModel('catalog/product_flat_indexer');
        $attribute = $indexer->getAttribute($attributeCode);

        foreach (Mage::app()->getStores() as $store) {
            $indexer->updateAttribute($attribute, $store->getId());
        }

        return $this;
    }

    /**
     * @param $period
     * @return string
     */
    protected function _getFromDate($period)
    {
        $date = new Zend_Date();
        $date->subDay($period);
        return $date->getIso();
    }

    /**
     * @return string
     */
    protected function _getToday()
    {
        $date = new Zend_Date();
        return $date->getIso();
    }
}
