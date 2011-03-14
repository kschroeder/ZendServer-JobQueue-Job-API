<?php

require_once 'tests/bootstrap.php';

use com\zend\api\response\ServerLicenseInfo;

/**
 * ServerLicenseInfo test case.
 */
class ServerLicenseInfoTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ServerLicenseInfo
     */
    private $ServerLicenseInfo;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();

        $this->ServerLicenseInfo = new ServerLicenseInfo();
        $e = simplexml_load_string('<serverLicenseInfo>
        <status>OK</status>
        <orderNumber>ZEND-ORDER-66</orderNumber>
        <validUntil>Sat, 31 Mar 2012 00:00:00 GMT</validUntil>
        <serverLimit>0</serverLimit>
      </serverLicenseInfo>');
        $this->ServerLicenseInfo->fromXml($e);
    }
    
    public function testGetStatus ()
    {
    	$this->assertEquals('OK', $this->ServerLicenseInfo->getStatus());
    }
    
    public function testGetOrderNumber ()
    {
        $this->assertEquals('ZEND-ORDER-66', $this->ServerLicenseInfo->getOrderNumber());
    }
    
    public function testGetValidUntil ()
    {
        $this->assertEquals('Sat, 31 Mar 2012 00:00:00 GMT', $this->ServerLicenseInfo->getValidUntil());
    }
    
    public function testGetServerLimit ()
    {
        $this->assertEquals('0', $this->ServerLicenseInfo->getServerLimit());
        
    }
}

