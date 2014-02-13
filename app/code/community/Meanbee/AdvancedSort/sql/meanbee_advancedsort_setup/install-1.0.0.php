<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', Meanbee_AdvancedSort_Helper_Data::ATTRIBUTE_NAME_QTY_ORDERED, array(
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

// Schedule the task to run right away.
$timestamp = Mage::getSingleton('core/date')->gmtTimestamp()+10;
$schedule = Mage::getModel('cron/schedule');
$schedule->setJobCode('meanbee_advancedsort_update')
    ->setStatus(Mage_Cron_Model_Schedule::STATUS_PENDING)
    ->setCreatedAt($timestamp)
    ->setScheduledAt($timestamp)
;
$schedule->save();
$installer->endSetup();
