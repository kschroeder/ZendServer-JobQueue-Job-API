<?php

namespace com\zend\api\response;

class ServerInfoList implements ResponseInterface
{

	private $servers = array();
	
    public function getServers ()
    {
        return $this->servers;
    }
    
    public function setServers ($servers)
    {
        $this->servers = $servers;
    }
    
    public function addServer(ServerInfo $s)
    {
    	$this->servers[] = $s;
    }
    
    public function clearServers()
    {
    	$this->servers = array();
    }

	public function fromXml(\SimpleXMLElement $e)
	{
		foreach ($e as $node) {
			$s = new ServerInfo();
			$s->fromXml($node);
			$this->servers[] = $s;
		}
	}
	
}