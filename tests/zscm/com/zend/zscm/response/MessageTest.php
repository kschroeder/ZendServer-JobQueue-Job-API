<?php

require_once 'tests/bootstrap.php';

use com\zend\api\response\Message;

class MessageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Message
     */
    private $Message;

    protected function setUp ()
    {
        parent::setUp();

        $this->Message = new Message();
        $e = simplexml_load_string('
          <warning>This server is waiting a PHP restart</warning>');
        $this->Message->fromXml($e);
    }
    public function testGetType ()
    {
        $this->assertEquals('warning', $this->Message->getType());
        
    }
    /**
     * Tests Message->getMessage()
     */
    public function testGetMessage ()
    {
    	$this->assertEquals('This server is waiting a PHP restart', $this->Message->getMessage());
    }
}

