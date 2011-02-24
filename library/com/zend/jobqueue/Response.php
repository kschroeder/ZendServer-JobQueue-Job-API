<?php

namespace com\zend\jobqueue;

class Response
{
	
	private $jobNumber;
	private $queueUrl;
	
	public function getJobNumber()
	{
		return $this->jobNumber;
	}
	
	public function getQueueUrl()
	{
		return $this->queueUrl;
	}
	
	public function setJobNumber($num)
	{
		$this->jobNumber = $num;
	}
	
	public function setQueueUrl($name)
	{
		$this->queueUrl = $name;
	}
	
}