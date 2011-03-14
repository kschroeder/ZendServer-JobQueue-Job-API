<?php

namespace com\zend\api\method;

use com\zend\api\response\ServerInfo;

class ClusterEnableServer extends MethodAbstract
{
	private $server;
	
    public function getBodyPayload ()
    {
    	if (!$this->server instanceof ServerInfo) {
    		throw new MethodException('A server must be specified in order to enable it');
    	}
    	return http_build_query(
    		array(
    			'serverId'	=> $this->server->getId()
    		)
    	);
    }

	/**
     * @return the $server
     */
    public function getServer ()
    {
        return $this->server;
    }

	/**
     * @param field_type $server
     */
    public function setServer ($server)
    {
        $this->server = $server;
    }

	public function __construct(ServerInfo $srv = null)
	{
		$this->server = $srv;
	}
	
	public function processResponse(\Zend_Http_Response $response)
	{
		$data = simplexml_load_string($response->getBody());
		$this->result = new ServerInfo();
		$this->result->fromXml(
			$data->responseData->serverInfo
		);
	}	
	
}