<?php

namespace com\zend\api\method;

class Generic extends MethodAbstract
{
	protected $payload;
	protected $requestMethod = 'GET';
	
	public function setRequestMethod($method)
	{
		$this->requestMethod = $method;
	}
	
	public function getRequestMethod()
	{
		return $this->requestMethod;
	}
	
	public function setBodyPayload($payload)
	{
		$this->payload = $payload;
	}
	
	public function getBodyPayload()
	{
		if (!$this->payload) {
			throw new MethodException('Payload not specified');
		}
		return $this->payload;
	}
	
	public function processResponse(\Zend_Http_Response $response)
	{
		$this->result = new com\zend\api\response\Generic();
		$this->result->setResponse($response->getBody());
	}
}