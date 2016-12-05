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

        /* @var $soldCollection Mage_Reports_Model_Mysql4_Product_Collection */
        $soldCollection = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty($this->_getFromDate($helper->getQtyOrderedAge()), $this->_getToday())
            ->addFieldToFilter('sku', array('notnull' => true));

        foreach($soldCollection as $product) {
            $product->setData(Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED, -((int)$product->getData('ordered_qty')));
            $resource->saveAttribute($product, Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED);
        }

        /**
         * Next loop through configurable products and set their sold counts to
         * the negative sum of their associated products.
         */
        $configurableCollection = Mage::getResourceModel('catalog/product_collection')
              ->addFieldToFilter('type_id', array('eq' => Mage_Catalog_Model_Product_Type_Configurable::TYPE_CODE));

        $childrenIds = array();
        foreach ($configurableCollection as $parent) {
            $childrenIds[$parent->getId()] = $parent->getTypeInstance()->getUsedProductIds();
        }
        $flatChildrenIds = array();
        array_walk_recursive($childrenIds,
                             function($id) use (&$flatChildrenIds) { $flatChildrenIds[] = $id; }
                            );
        $children = Mage::getResourceModel('catalog/product_collection')
                  ->addAttributeToSelect(Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED)
                  ->addFieldToFilter('entity_id', array('in' => $flatChildrenIds));
        foreach ($configurableCollection as $parent) {
            $total = 0;
            foreach ($childrenIds[$parent->getId()] as $childId) {
                $total -= $children->getItemById($childId)->getData(Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED);
            }
            $parent->setData(Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED, $total);
            $resource->saveAttribute($parent, Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED);
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
