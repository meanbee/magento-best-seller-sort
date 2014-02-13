<?php
class Meanbee_AdvancedSort_Adminhtml_RecalculateController extends Mage_Adminhtml_Controller_Action
{
    /**
    * Return some checking result
    *
    * @return void
    */
    public function indexAction()
    {
        Mage::log('WHY', null, 'ashsmith.log', true);
        $timestamp = Mage::getSingleton('core/date')->gmtTimestamp()+10;
        $schedule = Mage::getModel('cron/schedule');
        $schedule->setJobCode('meanbee_advancedsort_update')
            ->setStatus(Mage_Cron_Model_Schedule::STATUS_PENDING)
            ->setCreatedAt($timestamp)
            ->setScheduledAt($timestamp)
        ;
        $schedule->save();

        $this->_redirectReferer();
    }
}