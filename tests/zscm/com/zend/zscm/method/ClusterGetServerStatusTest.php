<?php

require_once 'tests/bootstrap.php';
use com\zend\api\method\ClusterGetServerStatus;
/**
 * ClusterGetServerStatus test case.
 */
class ClusterGetServerStatusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ClusterGetServerStatus
     */
    private $ClusterGetServerStatus;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        // TODO Auto-generated ClusterGetServerStatusTest::setUp()
        $this->ClusterGetServerStatus = new ClusterGetServerStatus();
    }
    
    public function testProcessResponse ()
    {
    	$body = '?xml version="1.0" encoding="UTF-8"?>
<zendServerAPIResponse xmlns="http://www.zend.com/server/api/1.0">
    
  <requestData>
    <apiKeyName>angel.eyes</apiKeyName>
    <method>clusterGetServersStatus</method>
  </requestData>
  
  <responseData>
    <serversList>
      <serverInfo>
        <id>12</id>
        <name>www-01</name>
        <address>https://www-01.local:10082/ZendServer</address>
        <status>OK</status>
        <messageList />
      </serverInfo>
      <serverInfo>
        <id>15</id>
        <name>www-02</name>
        <address>https://www-02.local:10082/ZendServer</address>
        <status>pendingRestart</status>
        <messageList>
          <warning>This server is waiting a PHP restart</warning>
        </messageList>
      </serverInfo>
    </serversList>
  </responseData>
</zendServerAPIResponse>';
    	$response = \Zend_Http_Response::fromString(
'HTTP/1.1 200 OK' . "\r\n" .  
'Content-Type: application/vnd.zend.serverapi+xml; version=3.0' . "\r\n" . 
'Content-Length: ' . strlen($body) . "\r\n" . 
'Host: localhost' . "\r\n\r\n" . $body);
        $this->ClusterGetServerStatus->processResponse($response);
        
        $this->assertType('array', $this->ClusterGetServerStatus->getResult());
        $array = $this->ClusterGetServerStatus->getResult();
        $this->assertType('com\zend\api\response\SystemInfo', $array[0]);
        
    }
    
}

