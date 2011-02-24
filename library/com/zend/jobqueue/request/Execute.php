<?php

namespace com\zend\jobqueue\request;
use com\zend\jobqueue\JobAbstract;

class Execute implements RequestInterface
{
	
	private $job;
	
	public function __construct(JobAbstract $job)
	{
		$this->job = $job;
	}
	
	/**
	 * 
	 * @return JobAbstract
	 */
	
	public function getJob()
	{
		return $this->job;
	}
	
}