<?php

namespace com\zend\api;

use com\zend\api\method\MethodException;

use com\zend\api\method\MethodAbstract;

class Manager
{
	/**
	 * 
	 * @var Zend_Uri_Http
	 */
	
	private $uri;
	
	/**
	 * 
	 * @var ApiKey
	 */
	private $apiKey;

	private $timeout = 60;
	
	private $postCallback;
	
	private $response;

    /**
     * @return \Zend_Http_Response $response
     */
    public function getResponse ()
    {
        return $this->response;
    }

	/**
     * @return the $timeout
     */
    public function getTimeout ()
    {
        return $this->timeout;
    }

	/**
     * @param field_type $timeout
     */
    public function setTimeout ($timeout)
    {
        $this->timeout = $timeout;
    }

	public function getApiKey ()
    {
        return $this->apiKey;
    }

    public function setApiKey (ApiKey $apiKey)
    {
        $this->apiKey = $apiKey;
    }

	public function setHost($host, $callZscm = true)
	{
		$uri = $callZscm ? 'ZendServerManager' : 'ZendServer'; 
		
		$this->setBaseUri(
			'http://'
			. $host
			. ':10081/'
			. $uri
			. '/Api/'		
		);
		
	}
		
	public function getHost()
	{
		if ($this->uri instanceof \Zend_Uri_Http) {
			return $this->uri->getHost();
		}
		return null;
	}
	
	public function setBaseUri($uri)
	{
		$this->uri = \Zend_Uri_Http::fromString($uri);
	}
	
	public function getBaseUri()
	{
		return $this->uri;
	}
	
	public function call(MethodAbstract $method)
	{
		if (!$this->uri instanceof \Zend_Uri_Http) {
			throw new ManagerException('A URI or hostname MUST be provided before calling');
		}
		$method->setManager($this);
		
		$client = $this->createHttpClient($method);
		
		// Allow the method to force POST for all requests
		if ($method->getRequestMethod() == 'POST') {
			$client->setMethod('POST');
		}
		$this->response = $client->request();
		$method->postCallback();
		
		$responseCode = substr($this->response->getStatus(), 0, 1);
		switch ($responseCode) {
			case 2:
				$method->processResponse(
					$this->response
				);
				break;
			case 4:
				$e = simplexml_load_string($this->response->getBody());
				if ($e->errorData->errorMessage) {
					throw new MethodException((string)$e->errorData->errorMessage);
				} else {
					throw new MethodException('Unknown Error');
				}
				break;
			case 5:
				throw new MethodException('Internal Server Error');
				break;
			default:
				throw new MethodException('Unknown Error Code');
				break;
		}
		
		return $method;
	}
	
	public function calculateSignature(\Zend_Uri_Http $uri, $userAgent, $date)
	{
		if (!$this->apiKey instanceof ApiKey) {
			throw new ManagerException('API key has not been specified');
		}
		$host = $uri->getHost();
		if ($uri->getPort() != '80') {
			$host .= ':' . $uri->getPort();
		}
		$sigSrc = $host
		   . ':'
		   . $uri->getPath()
		   . ':'
		   . $userAgent
		   . ':'
		   . $date;
		return hash_hmac('sha256', $sigSrc, $this->apiKey->getValue());   
	}
	
	public function createHttpClient(MethodAbstract $method)
	{
		
		$userAgent = 'Zend API Agent';
		$uri = clone $this->uri;
		
		$uri->setPath($uri->getPath() . $method->getApiName());
			
		$uri->setQuery(
			$method->getQueryStringPayload()
		);
		
		$client = new \Zend_Http_Client(
			$uri->getUri(),
			array(
				'useragent' => $userAgent,
				'timeout' => $this->timeout,
			)
		);
		
		$body = $method->getBodyPayload();
		$client->setRawData(
			$body
		);
		if ($body) {
			$client->setMethod('POST');
			$client->setHeaders('Content-type', 'application/x-www-form-urlencoded');
		}

		$date = gmdate('D, d M Y H:i:s e');
		$date = str_replace('UTC', 'GMT', $date);
		$client->setHeaders('Date', $date);
		$client->setHeaders('Accept', 'application/vnd.zend.serverapi+xml;version=1.0');
		
		if (!$this->apiKey instanceof ApiKey) {
			throw new ManagerException('API key has not been specified');
		}
		
		$sig = $this->calculateSignature(
			$client->getUri(),
			$userAgent,
			$date
		);
		
		$client->setHeaders(
			'X-Zend-Signature',
			sprintf('%s; %s', $this->apiKey->getName(), $sig)
		);
		
		return $client;
	}
}