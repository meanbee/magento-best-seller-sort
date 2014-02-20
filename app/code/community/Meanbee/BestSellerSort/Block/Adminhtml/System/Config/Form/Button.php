<?php
class Meanbee_BestSellerSort_Block_Adminhtml_System_Config_Form_Button extends Mage_Adminhtml_Block_System_Config_Form_Field {
    /*
     * Set template
     */
    protected function _construct() {
        parent::_construct();
        $this->setTemplate('meanbee/bestsellersort/system/config/recalculate_button.phtml');
    }

    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        return $this->_toHtml();
    }

    /**
     * Return ajax url for button
     *
     * @return string
     */
    public function getRecalculateUrl() {
        return $this->getUrl('adminhtml/recalculate/index');
    }

    /**
     * Generate button html
     *
     * @return string
     */
    public function getButtonHtml() {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'meanbee_bestsellersort_button',
                'label'     => $this->helper('adminhtml')->__('Recalculate Popular Products'),
                'onclick'   => "javascript:setLocation('" . $this->getRecalculateUrl() ."'); return false;"
            ));

        return $button->toHtml();
    }
}
