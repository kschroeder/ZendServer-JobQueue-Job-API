<?php

namespace com\zend\api\method;

class Generic extends MethodAbstract
{
	protected $payload;
	protected $requestMethod = 'GET';
	protected $queryString;
		
	public function setApiName($name)
	{
		$this->apiName = $name;
	}
	
	public function setRequestMethod($method)
	{
		$this->requestMethod = $method;
	}
	
	public function getQueryStringPayload()
	{
		return $this->queryString;
	}
	
	public function setQueryStringPayload($urlEncoded)
	{
		$this->queryString = $urlEncoded;
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
		return $this->payload;
	}
	
	public function processResponse(\Zend_Http_Response $response)
	{
		$this->result = new \com\zend\api\response\Generic();
		$response = $response->getBody();
		if (($xml = simplexml_load_string($response)) instanceof \SimpleXMLElement) {
			$this->result->setResponse($xml->responseData->asXml());
		} else {
			$this->result->setResponse($response);
		}
	}
}