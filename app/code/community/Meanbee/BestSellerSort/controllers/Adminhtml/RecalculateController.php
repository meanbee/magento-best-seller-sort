<?php
class Meanbee_BestSellerSort_Adminhtml_RecalculateController extends Mage_Adminhtml_Controller_Action
{
    /**
    * Return some checking result
    *
    * @return void
    */
    public function indexAction()
    {
        $timestamp = Mage::getSingleton('core/date')->timestamp(time()) + 10;
        $schedule = Mage::getModel('cron/schedule');
        $schedule->setJobCode('meanbee_bestsellersort_update')
            ->setStatus(Mage_Cron_Model_Schedule::STATUS_PENDING)
            ->setCreatedAt($timestamp)
            ->setScheduledAt($timestamp)
        ;
        $schedule->save();

        $this->_redirectReferer();
    }
}
