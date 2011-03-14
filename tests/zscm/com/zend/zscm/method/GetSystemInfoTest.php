<?php

require_once 'tests/bootstrap.php';
use com\zend\api\method\GetSystemInfo;
use com\zend\api\Service;
/**
 * GetSystemInfo test case.
 */
class GetSystemInfoTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var GetSystemInfo
     */
    private $GetSystemInfo;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        // TODO Auto-generated GetSystemInfoTest::setUp()
        $this->GetSystemInfo = new GetSystemInfo();
    }
    /**
     * Tests GetSystemInfo->processResponse()
     */
    public function testProcessResponse ()
    {
    	$body = '<?xml version="1.0" encoding="UTF-8"?>
<zendServerAPIResponse xmlns="http://www.zend.com/server/api/1.0">
  <requestData>
    <apiKeyName>angel.eyes</apiKeyName>
    <method>getSystemInfo</method>
  </requestData>
  <responseData>
    <systemInfo>
      <status>OK</status>
      <edition>
        ZendServerClusterManager
      </edition>
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
  </responseData>
</zendServerAPIResponse>';
    	$response = \Zend_Http_Response::fromString(
'HTTP/1.1 200 OK' . "\r\n" .  
'Content-Type: application/vnd.zend.serverapi+xml; version=3.0' . "\r\n" . 
'Content-Length: ' . strlen($body) . "\r\n" . 
'Host: localhost' . "\r\n\r\n" . $body);
        $this->GetSystemInfo->processResponse($response);
        
        $this->assertType('com\zend\api\response\SystemInfo', $this->GetSystemInfo->getResult());
        $this->assertType('com\zend\api\response\ServerLicenseInfo', $this->GetSystemInfo->getResult()->getServerLicenseInfo());
        $this->assertType('com\zend\api\response\ManagerLicenseInfo', $this->GetSystemInfo->getResult()->getManagerLicenseInfo());
    }
}

