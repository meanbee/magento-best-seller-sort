<?php
class Meanbee_AdvancedSort_Test_Config_Base extends EcomDev_PHPUnit_Test_Case_Config {
    /**
     * @test
     */
    public function testClassAliases() {
        $this->assertModelAlias('meanbee_advancedsort/test', 'Meanbee_AdvancedSort_Model_Test');
        $this->assertHelperAlias('meanbee_advancedsort/data', 'Meanbee_AdvancedSort_Helper_Data');
    }

    /**
     * @test
     */
    public function testCodePool() {
        $this->assertModuleCodePool('community');
    }

    /**
     * @test
     */
    public function testModuleVersion() {
        $this->assertModuleVersion('1.0.0');
    }

    /**
     * @test
     */
    public function testCron() {
        $this->assertConfigNodeHasChild('crontab/jobs', 'meanbee_advancedsort_update');
    }
}