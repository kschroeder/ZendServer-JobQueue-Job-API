<?php

namespace com\zend\api\method;

use com\zend\api\response\ServerInfo;

class ClusterAddServer extends MethodAbstract
{
	
	/**
	 * 
	 * @var ServerInfo
	 */
	
	private $server;
	private $processed = false;
	
	
    public function getBodyPayload ()
    {
    	if (!$this->server instanceof ServerInfo) {
    		throw new MethodException('A ServerInfo object must be added before the request is sent');
    	}
    	
    	$out = array(
    		'serverName' 	=> $this->server->getName(),
    		'serverUrl'		=> $this->server->getAddress(),
    		'guiPassword'	=> $this->server->getPassword(),
    		'doRestart'		=> 'TRUE'
    	);
    	return http_build_query($out);
    }

	public function processResponse(\Zend_Http_Response $response)
	{
		if ($this->processed) {
			return;
		}
		$this->processed = true;
		$data = simplexml_load_string($response->getBody());
		$this->result = new ServerInfo();
		$this->result->fromXml(
			$data->responseData->serverInfo
		);
	}

	public function __construct(ServerInfo $srv = null)
	{
		$this->server = $srv;
	}
	
	public function postCallback()
	{
		if ($this->manager->getResponse()->getStatus() == 503) { // ZSCM temporarily locked
			sleep(10);
			$this->manager->call($this);
		}
	}
	
	public function setServer(ServerInfo $srv)
	{
		$this->server = $srv;
	}
	
}