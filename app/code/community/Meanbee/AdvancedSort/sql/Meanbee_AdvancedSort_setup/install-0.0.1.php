<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'qty_ordered', array(
    'type'              => 'int',
    'backend'           => '',
    'frontend_class'    => 'validate-digits',
    'label'             => 'Most Popular',
    'input'             => 'text',
    'class'             => '',
    'source'            => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => false,
    'required'          => false,
    'apply_to'          => '',
    'is_configurable'   => false,
    'note'              => '',
    'used_in_product_listing' => true,
    'used_for_sort_by'        => true
));


$installer->endSetup();