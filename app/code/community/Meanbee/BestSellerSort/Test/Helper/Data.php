<?php

class Meanbee_BestSellerSort_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case {

    /** @var Meanbee_BestSellerSort_Helper_Data */
    protected $_obj = null;

    public function setUp() {
        $this->_obj = Mage::helper('meanbee_bestsellersort');
    }

    public function tearDown() {
        $this->_obj = null;
    }

    /**
     * @test
     */
    public function testObjectConstructed() {
        $this->assertInstanceOf('Meanbee_BestSellerSort_Helper_Data', $this->_obj);
    }

    /**
     * @test
     * @loadFixture
     */
    public function testGetQtyOrderedAge() {
        $this->assertEquals(40, $this->_obj->getQtyOrderedAge());
    }
}