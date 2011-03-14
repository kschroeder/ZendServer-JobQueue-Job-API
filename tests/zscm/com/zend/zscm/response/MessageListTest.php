<?php

require_once 'tests/bootstrap.php';
use com\zend\api\response\MessageList;

class MessageListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MessageList
     */
    private $MessageList;
    
    protected function setUp ()
    {
        parent::setUp();
        $this->MessageList = new MessageList();
        $e = simplexml_load_string('<messageList>
          <warning>This server is waiting a PHP restart</warning>
        </messageList>');
        $this->MessageList->fromXml($e);
    }
    public function testGetMessages ()
    {
    	$messages = $this->MessageList->getMessages();
    	$this->assertType('array', $messages);
    	$this->assertGreaterThan(0, count($messages));
    	$this->assertType('com\zend\api\response\Message', $messages[0]);
    }
}

