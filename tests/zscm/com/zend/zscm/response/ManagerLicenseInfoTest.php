<?php

require_once 'tests/bootstrap.php';

use com\zend\api\response\ManagerLicenseInfo;


class ManagerLicenseInfoTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ManagerLicenseInfo
     */
    private $ManagerLicenseInfo;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();

        $this->ManagerLicenseInfo = new ManagerLicenseInfo();
        $e = simplexml_load_string('<serverLicenseInfo>
        <status>OK</status>
        <orderNumber>ZEND-ORDER-66</orderNumber>
        <validUntil>Sat, 31 Mar 2012 00:00:00 GMT</validUntil>
        <serverLimit>0</serverLimit>
      </serverLicenseInfo>');
        $this->ManagerLicenseInfo->fromXml($e);
    }
    
    public function testGetStatus ()
    {
    	$this->assertEquals('OK', $this->ManagerLicenseInfo->getStatus());
    }
    
    public function testGetOrderNumber ()
    {
        $this->assertEquals('ZEND-ORDER-66', $this->ManagerLicenseInfo->getOrderNumber());
    }
    
    public function testGetValidUntil ()
    {
    	$this->assertEquals('Sat, 31 Mar 2012 00:00:00 GMT', $this->ManagerLicenseInfo->getValidUntil());
    }
    
    public function testGetServerLimit ()
    {
    	$this->assertEquals('0', $this->ManagerLicenseInfo->getServerLimit());
    }
    
}

