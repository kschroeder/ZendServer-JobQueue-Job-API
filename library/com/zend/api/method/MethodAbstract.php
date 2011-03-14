<?php

namespace com\zend\api\method;

use com\zend\api\Manager;

abstract class MethodAbstract
{
	/**
	 * 
	 * @var com\zend\api\Manager
	 */
	
	protected $manager;
	
	protected $apiName;
	protected $result;
	
	public function getQueryStringPayload() {}
	public function getBodyPayload() {}
	public function postCallback() {}
	
	public abstract function processResponse(\Zend_Http_Response $response);
	
	public function getResult()
	{
		return $this->result;
	}
	
	public function getRequestMethod()
	{
		return 'GET';
	}
	
	public function getApiName()
	{
		if (!$this->apiName) {
			$class = get_class($this);
			$class = substr($class, strrpos($class, '\\') + 1);
			$this->apiName = \lcfirst($class);
		}
		return $this->apiName;
	}
	
	public function setManager(Manager $mgr)
	{
		$this->manager = $mgr;
	}
	
	public function getManager()
	{
		return $this->mgr;
	}
	
}