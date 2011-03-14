<?php
require_once 'tests/bootstrap.php';

use com\zend\api\response\ServerInfo;
use com\zend\api\method\ClusterAddServer;

class ClusterAddServerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ClusterAddServer
     */
    private $ClusterAddServer;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        $this->ClusterAddServer = new ClusterAddServer();
    }
    public function testGetBodyPayload ()
    {
        $this->markTestIncomplete("getBodyPayload test not implemented");
        $this->ClusterAddServer->getBodyPayload(/* parameters */);
    }
    /**
     * Tests ClusterAddServer->processResponse()
     */
    public function testProcessResponse ()
    {
    	$body = '<?xml version="1.0" encoding="UTF-8"?>
<zendServerAPIResponse xmlns="http://www.zend.com/server/api/1.0">
    
  <requestData>
    <apiKeyName>angel.eyes</apiKeyName>
    <method>clusterAddServer</method>
  </requestData>
  
  <responseData>
    <serverInfo>
      <id>25</id>
      <name>www-05</name>
      <address>https://www-05.local:10082/ZendServer</address>
      <status>OK</status>
      <messageList />
    </serverInfo>
  </responseData>
</zendServerAPIResponse>';

		$response = \Zend_Http_Response::fromString(
			'HTTP/1.1 200 OK' . "\r\n" .  
			'Content-Type: application/vnd.zend.serverapi+xml; version=3.0' . "\r\n" . 
			'Content-Length: ' . strlen($body) . "\r\n" . 
			'Host: localhost' . "\r\n\r\n" . $body
		);

        $this->ClusterAddServer->processResponse($response);
        $this->assertType('com\zend\api\response\ServerInfo', $this->ClusterAddServer->getResult());
    }
}

