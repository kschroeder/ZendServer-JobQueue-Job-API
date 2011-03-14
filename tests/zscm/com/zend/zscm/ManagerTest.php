<?php

use com\zend\api\ApiKey;
require_once 'tests/bootstrap.php';

use com\zend\api\Manager;

class ManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Manager
     */
    private $Manager;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        $this->Manager = new Manager();
        $this->Manager->setHost(
        	getenv('ZSCM')?:'192.168.0.242'
        );
        $ak = new ApiKey(
        	'angel.eyes',
        	'9dc7f8c5ac43bb2ab36120861b4aeda8f9bb6c521e124360fd5821ef279fd9c7'
        );
        $this->Manager->setApiKey($ak);
    }
    
    public function testCalculateSignature ()
    {
    	$uri = Zend_Uri_Http::fromString('http://zscm.local:10081/ZendServer/Api/findTheFish');
    	 $res  = $this->Manager->calculateSignature(
    	 	$uri,
    	 	'Zend_Http_Client/1.10',
    	 	'Sun, 11 Jul 2010 13:16:10 GMT'
    	 );
    	 $this->assertEquals('785be59b7728b1bfd6495d610271c5d47ff0737775b09191daeb5a728c2d97c0', $res);
    }
}

