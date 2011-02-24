<?php

namespace com\zend\jobqueue;

abstract class JobAbstract
{
	private $name = null;
	private $schedule = null;
	private $scheduleTime = null;
	private $url;
		
	public abstract function job();
		
	public final function run()
	{
		$this->job();
	}
	
	public final function setJobName($name)
	{
		$this->name = $name;
	}
	
	public final function getJobName()
	{
		return $this->name;
	}
	
	public final function setJobSchedule($time)
	{
		$this->schedule = $time;
	}
	
	public final function getJobSchedule()
	{
		return $this->schedule;
	}
	
	public final function setJobExecutionTime($time)
	{
		$this->scheduleTime = $time;
	}
	
	public final function getJobExecutionTime()
	{
		return $this->scheduleTime;
	}
	
	public final function setJobQueueUrl($url)
	{
		$this->url = $url;
	}
	
	
	public final function getJobQueueUrl()
	{
		return $this->url;
	}
	
	
	public function execute()
	{
		$mgr = new Manager();
		return $mgr->sendJobQueueRequest($this);
	}
	
}