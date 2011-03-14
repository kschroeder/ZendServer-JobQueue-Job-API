<?php

require_once 'tests/bootstrap.php';

use com\zend\api\response\SystemInfo;
class SystemInfoTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SystemInfo
     */
    private $SystemInfo;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        // TODO Auto-generated SystemInfoTest::setUp()
        $this->SystemInfo = new SystemInfo();
        $xml = simplexml_load_string('<systemInfo>
      <status>OK</status>
      <edition>ZendServerClusterManager</edition>
      <zendServerVersion>6.0.1</zendServerVersion>
      <supportedApiVersions>
        application/vnd.zend.serverapi+xml;version=1.0,
        application/vnd.zend.serverapi+xml;version=1.1,
        application/vnd.zend.serverapi+xml;version=2.0
      </supportedApiVersions>
      <phpVersion>5.4.1</phpVersion>
      <operatingSystem>Linux</operatingSystem>
      <serverLicenseInfo>
        <status>OK</status>
        <orderNumber>ZEND-ORDER-66</orderNumber>
        <validUntil>Sat, 31 Mar 2012 00:00:00 GMT</validUntil>
        <serverLimit>0</serverLimit>
      </serverLicenseInfo>
      <managerLicenseInfo>
        <status>serverLimitExceeded</status>
        <orderNumber>ZEND-ORDER-66</orderNumber>
        <validUntil>Sat, 31 Mar 2012 00:00:00 GMT</validUntil>
        <serverLimit>10</serverLimit>
      </managerLicenseInfo>
      <messageList />
    </systemInfo>
        ');
        $this->SystemInfo->fromXml($xml);
    }
    
    public function testGetStatus ()
    {
    	$this->assertEquals('OK', $this->SystemInfo->getStatus());        
    }
    
    public function testGetEdition ()
    {
        $this->assertEquals('ZendServerClusterManager', $this->SystemInfo->getEdition());
    }
    
    public function testGetZendServerVersion ()
    {
    	$this->assertEquals('6.0.1', $this->SystemInfo->getZendServerVersion());
    }

    public function testGetSupportedApiVersions ()
    {
    	$this->assertEquals(3, count($this->SystemInfo->getSupportedApiVersions()));
        
    }
    
    public function testGetPhpVersion ()
    {
        $this->assertEquals('5.4.1', $this->SystemInfo->getPhpVersion());
    }
    public function testGetOperatingSystem ()
    {
    	$this->assertEquals('Linux', $this->SystemInfo->getOperatingSystem());
    }
    
    public function testGetServerLicenseInfo ()
    {
    	$this->assertType('com\zend\api\response\ServerLicenseInfo', $this->SystemInfo->getServerLicenseInfo());
    }
    
    public function testGetManagerLicenseInfo ()
    {
    	$this->assertType('com\zend\api\response\ManagerLicenseInfo', $this->SystemInfo->getManagerLicenseInfo());
    }
    
    public function testGetMessageList ()
    {
    	$this->assertType('com\zend\api\response\MessageList', $this->SystemInfo->getMessageList());   
    }
    
}

