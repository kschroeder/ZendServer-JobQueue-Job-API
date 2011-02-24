<?php

namespace org\eschrade\job;

use com\zend\jobqueue\JobAbstract;

class GetRemoteLinks extends JobAbstract
{
	
	private $url;
	private $links = array();
	
	public function __construct($url)
	{
		$this->url = $url;
	}
	
	public function getLinks()
	{
		return $this->links;
	}
	
	public function getUrl()
	{
		return $this->url;
	}
	
	public function job()
	{
		
		$http = new \Zend_Http_Client($this->url);
		$response = $http->request();
		$selector = new \Zend_Dom_Query();
		$selector->setDocumentHtml(
			$response->getBody()
		);
		foreach ($selector->query('a') as $result) {
			if ($result->getAttribute('href')) {
				$this->links[] = $result->getAttribute('href');
			}
		}
	}
}