<?php

use org\eschrade\job\GetRemoteLinks;
require_once realpath(__DIR__ . '/../../public/bootstrap.php');

/**
 * GetRemoteLinks test case.
 */
class GetRemoteLinksTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var GetRemoteLinks
     */
    private $GetRemoteLinks;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        // TODO Auto-generated GetRemoteLinksTest::setUp()
        $this->GetRemoteLinks = new GetRemoteLinks('http://www.eschrade.com/');
    }

    protected function tearDown ()
    {
        $this->GetRemoteLinks = null;
        parent::tearDown();
    }

    public function testGetLinks ()
    {
    	$this->GetRemoteLinks->job();
        $this->assertTrue(count($this->GetRemoteLinks->getLinks())>0);
    }
}

