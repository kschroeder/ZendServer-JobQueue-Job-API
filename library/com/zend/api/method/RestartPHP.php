<?php

namespace com\zend\api\method;

use com\zend\api\response\ServerInfo;

class RestartPHP extends MethodAbstract
{
private $servers = array();
	
	public function __construct($server)
	{
		if (is_array($server)) {
			$this->servers = $server;
		} else if ($server) {
			$this->servers[] = $server;
		}
	}
	
	public function getRequestMethod()
	{
		return 'POST';
	}
	
	public function getQueryStringPayload ()
    {
    	if (!$this->servers) {
    		return '';
    	}
        $out = array('servers' => array());
        foreach ($this->servers as $server) {
        	$out['servers'][] = $server;
        }
        return http_build_query($out);
    }

	/**
     * @return the $servers
     */
    public function getServers ()
    {
        return $this->servers;
    }

	/**
     * @param array $servers
     */
    public function setServers (array $servers)
    {
        $this->servers = $servers;
    }
    
    public function addServer(ServerInfo $server)
    {
    	$this->servers[] = $server;
    }
    
    public function clearServer()
    {
    	$this->servers = array();
    }

	public function processResponse(\Zend_Http_Response $response)
	{
		$xml = simplexml_load_string($response->getBody());
		if (!$xml->responseData->serversList) {
			throw new MethodException('Invalid XML format');
		}
		$this->result = array();
		foreach ($xml->responseData->serversList as $server) {
			$si = new ServerInfo();
			$si->fromXml($server->serverInfo);
			$this->result[] = $si;
		}
	}	
}