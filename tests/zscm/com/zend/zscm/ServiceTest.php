<?php

require_once 'tests/bootstrap.php';

use com\zend\api\method\MethodException;
use com\zend\api\ApiKey;
use com\zend\api\response\ServerInfo;
use com\zend\api\Manager;
use com\zend\api\Service;

class ServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Service
     */
    private $Service;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        // TODO Auto-generated ServiceTest::setUp()
        $this->Service = new Service();
        $mgr = new Manager();
        $mgr->setHost(
        	getenv('ZSCM')?:'192.168.0.242'
        );
        $ak = new ApiKey(
        	getenv('ZSCM_API_KEY')?:'kevin',
        	getenv('ZSCM_API_VALUE')?:'59455fb2e117e00bdcf04b37f9942da105e6bfd6a6cccf330fe79c79e89ddd4c'
        );
        $mgr->setApiKey($ak);
        $this->Service->setManager($mgr);
    }
    
    public function testGetSystemInfo ()
    {
        $this->assertType('com\zend\api\response\SystemInfo', $this->Service->getSystemInfo());
    }
    
    public function testClusterAddServer ()
    {
    	$si = new ServerInfo();
    	$si->setName(
    		getenv('ZS_TEST_NAME')?:'localhost'
    	);
    	$si->setAddress(
    		getenv('ZS_TEST_ADDRESS')?:'http://192.168.0.254:10081'
    	);
    	$si->setPassword(
    		getenv('ZS_TEST_PASSWORD')?:'password'
    	);
        $res = $this->Service->clusterAddServer($si);
        $this->assertType('com\zend\api\response\ServerInfo', $res);
    }
    
    public function testClusterGetServerStatus ()
    {
        $ret = $this->Service->clusterGetServerStatus();
        $this->assertType('array', $ret);
        $this->assertType('com\zend\api\response\ServerInfo', $ret[0]);
        
        $ret2 = $this->Service->clusterGetServerStatus($ret[0]->getId());
        $this->assertType('array', $ret2);
        $this->assertType('com\zend\api\response\ServerInfo', $ret2[0]);
        $this->assertEquals($ret[0]->getId(), $ret2[0]->getId());
    }
    
    public function testClusterDisableServer ()
    {
        $ret = $this->Service->clusterGetServerStatus();
        $this->assertType('array', $ret);
        $this->assertType('com\zend\api\response\ServerInfo', $ret[0]);
        $res = $this->Service->clusterDisableServer($ret[0]);
        $this->assertEquals($res->getStatus(), ServerInfo::STATUS_DISABLED);
    }

    public function testClusterEnableServer ()
    {
        $ret = $this->Service->clusterGetServerStatus();
        $this->assertType('array', $ret);
        $this->assertType('com\zend\api\response\ServerInfo', $ret[0]);
        $res = $this->Service->clusterEnableServer($ret[0]);
        $this->assertTrue($res->getStatus() != ServerInfo::STATUS_DISABLED);
    }

    public function testRestartPHP ()
    {
    	$ret = $this->Service->restartPHP();
        $this->assertType('array', $ret);
        $this->assertType('com\zend\api\response\ServerInfo', $ret[0]);
        $this->assertTrue($ret->getStatus() == ServerInfo::STATUS_PENDING_RESTART || $ret->getStatus() == ServerInfo::STATUS_RESTARTING);
    }

    public function testConfigurationExport ()
    {
        // TODO Auto-generated ServiceTest->testConfigurationExport()
        $this->markTestIncomplete(
        "configurationExport test not implemented");
        $this->Service->configurationExport(/* parameters */);
    }
    /**
     * Tests Service->configurationImport()
     */
    public function testConfigurationImport ()
    {
        // TODO Auto-generated ServiceTest->testConfigurationImport()
        $this->markTestIncomplete(
        "configurationImport test not implemented");
        $this->Service->configurationImport(/* parameters */);
    }
    
    public function testClusterRemoveServer ()
    {
        $ret = $this->Service->clusterGetServerStatus();
        $this->assertType('array', $ret);
        $this->assertType('com\zend\api\response\ServerInfo', $ret[0]);
        
        $this->assertTrue($this->Service->clusterRemoveServer($ret[0]));
    }
    
    public function testAuth()
    {
    	$apiKey = new ApiKey(
    		$this->Service->getManager()->getApiKey()->getName(),
    		'asdfasdgas'
    	);
    	$this->Service->getManager()->setApiKey($apiKey);
    	try {
    		$this->Service->getSystemInfo();
    	} catch (MethodException $e) {
    		return;
    	}
    	$this->assertTrue(false, 'An Unauthorized exception was expected');
    }
}

