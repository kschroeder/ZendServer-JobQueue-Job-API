<?php

require_once 'tests/bootstrap.php';

use com\zend\api\response\ServerInfo;

class ServerInfoTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ServerInfo
     */
    private $ServerInfo;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        $this->ServerInfo = new ServerInfo();
        $e = simplexml_load_string('<serverInfo>
        <id>12</id>
        <name>www-01</name>
        <address>https://www-01.local:10082/ZendServer</address>
        <status>OK</status>
        <messageList />
      </serverInfo>');
        $this->ServerInfo->fromXml($e);
    }

    public function testGetId ()
    {
    	$this->assertEquals('12', $this->ServerInfo->getId());
    }
    
    public function testGetName ()
    {
        $this->assertEquals('www-01', $this->ServerInfo->getName());
    }
    
    public function testGetAddress ()
    {
        $this->assertEquals('https://www-01.local:10082/ZendServer', $this->ServerInfo->getAddress());
    }

    public function testGetStatus ()
    {
    	$this->assertEquals('OK', $this->ServerInfo->getStatus());
    }
}

