<?php

$installer = $this;

$installer->startSetup();

$installer->updateAttribute('catalog_product', Meanbee_BestSellerSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED, array(
    'visible' => true
));

$installer->endSetup();
