<?php

require_once 'tests/bootstrap.php';

use com\zend\api\response\ServerInfoList;

class ServerInfoListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ServerInfoList
     */
    private $ServerInfoList;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        $this->ServerInfoList = new ServerInfoList();
        $e = simplexml_load_string('<serversList>
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
    </serversList>');
        $this->ServerInfoList->fromXml($e);
    }
    public function testGetServers ()
    {
        $srvrs = $this->ServerInfoList->getServers();
        $this->assertType('array', $srvrs);
        $this->assertGreaterThan(0, count($srvrs));
        $this->assertType('com\zend\api\response\ServerInfo', $srvrs[0]);
    }
    
}

