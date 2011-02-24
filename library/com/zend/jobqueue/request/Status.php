<?php

namespace com\zend\jobqueue\request;

class Status implements RequestInterface
{
	
	private $jobId;
	
	public function __construct($job)
	{
		$this->jobId = $job;
	}
	
	public function getJobId()
	{
		return $this->jobId;
	}
	
}