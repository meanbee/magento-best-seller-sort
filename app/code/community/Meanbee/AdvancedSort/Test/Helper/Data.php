<?php

class Meanbee_AdvancedSort_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case {

    /** @var Meanbee_AdvancedSort_Helper_Data */
    protected $_obj = null;

    public function setUp() {
        $this->_obj = Mage::helper('meanbee_advancedsort');
    }

    public function tearDown() {
        $this->_obj = null;
    }

    /**
     * @test
     */
    public function testObjectConstructed() {
        $this->assertInstanceOf('Meanbee_AdvancedSort_Helper_Data', $this->_obj);
    }

    /**
     * @test
     * @loadFixture
     */
    public function testGetQtyOrderedAge() {
        $this->assertEquals(40, $this->_obj->getQtyOrderedAge());
    }
}