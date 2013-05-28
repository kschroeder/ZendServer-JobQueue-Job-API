<?php

namespace com\zend\jobqueue;

use com\zend\jobqueue\codec\Codec;

use com\zend\jobqueue\codec\CodecInterface;

use com\zend\jobqueue\request\RequestInterface;

use com\zend\jobqueue\request\Status;

use com\zend\jobqueue\request\Queue;

use com\zend\jobqueue\request\Execute;

class Manager
{
	
	private static $defaultUrl;
	
	/**
	 * 
	 * @var com\zend\jobqueue\codec\CodecInterface
	 */
	
	private static $defaultCodec;

	/**
	 * 
	 * @var com\zend\jobqueue\codec\Codec
	 */
	private $codec;
	
	public static function setDefaultUrl($url)
	{
		self::$defaultUrl = $url;
	}
	
	public function __construct()
	{
		if (self::$defaultUrl === null) {
			self::$defaultUrl = $_SERVER['HTTP_HOST'];
		}
	}
	
	
	/**
	 * 
	 * @return com\zend\jobqueue\codec\CodecInterface
	 */
	
	public function getCodec()
	{
		 
		if (!$this->codec instanceof CodecInterface) {
			$this->codec = self::$defaultCodec instanceof CodecInterface?self::$defaultCodec:new Codec();
		}
		return $this->codec;
	}
	
	public function setCodec(CodecInterface $codec)
	{
		$this->codec = $codec;
	}
	
	public static function setDefaultCodec(CodecInterface $codec)
	{
		self::$defaultCodec = $codec;
	}
	
	public function invoke()
	{
		
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'Zend Server Job Queue') === 0) {
			$params = \ZendJobQueue::getCurrentJobParams();
			if (!isset($params['obj'])) {
				return new Exception('Job Queue execution request must be invoked only through the Job Queue');
			}
			echo $this->getCodec()->encode($this->executeJob($params['obj']));
		} else {
			$data = file_get_contents('php://input');		
			$obj = $this->getCodec()->decode($data);
			if ($obj instanceof Queue) {
				$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				echo $this->getCodec()->encode($this->createJob($obj->getJob(), $url));
			} else if ($obj instanceof Status) {
				echo $this->getCodec()->encode($this->getJobFromQueue($obj->getJobId()));
			} else if ($obj instanceof RequestInterface && method_exists($obj, 'invoke')) {
				 echo $this->getCodec()->encode($obj->invoke());
			} else {
				echo $this->getCodec()->encode(
					new Exception('Job Queue must be invoked with a Request object')
				);
			}
		}
	}
	
	/**
	 * 
	 * @param com\zend\jobqueue\JobAbstract $job
	 * @throws Exception
	 * @return Response
	 */
	
	public function sendJobQueueRequest(JobAbstract $job)
	{
		$url = $job->getJobQueueUrl()?:self::$defaultUrl;
		if (strpos($url, 'local://') === 0 || $job->getJobQueueBinding()) {
			return $this->createJob($job, $url);
		}
		$req = new Queue($job);
		$response = $this->sendApiRequest($req, $url);
		if (!$response instanceof Response) {
			throw new Exception('Unable to get a properly formatted response from the server');
		}
		return $response;
	}
	
	protected function sendApiRequest(RequestInterface $req, $url)
	{
		 
		$http = new \Zend_Http_Client($url);
		$http->setMethod('POST');
		$http->setRawData($this->getCodec()->encode( $req ));
		
		$response = $this->getCodec()->decode(
			$http->request()->getBody()
		);
		
		return $response;
		
	}
	
	public function getJobFromQueue($id)
	{
		$jq = new \ZendJobQueue();
		$job = $jq->getJobStatus($id);
		$status = $job['status'];
		if ($status == \ZendJobQueue::STATUS_OK) {
			$output = \Zend_Http_Response::fromString($job['output']);
			
			$response = $this->getCodec()->decode(
				$output->getBody()
			);
			if ($response instanceof \Exception) {
				throw $response;
			}
			return $response;
		}
		return null;
	}
	
	public function getCompletedJob(Response $res)
	{
		$req = new Status($res->getJobNumber());
		return $this->sendApiRequest($req, $res->getQueueUrl());
	}
	
	public function executeJob($obj)
	{
	
		$obj = $this->getCodec()->decode($obj);
		if ($obj instanceof Execute) {
			try {
	        	$job = $obj->getJob();
	        	$job->run();
	        	
	            \ZendJobQueue::setCurrentJobStatus(\ZendJobQueue::OK);
	            return $job;
			} catch (\Exception $e) {
	        	zend_monitor_set_aggregation_hint(get_class($obj) . ': ' . $e->getMessage());
	            zend_monitor_custom_event('Failed Job', $e->getMessage());
	            \ZendJobQueue::setCurrentJobStatus(\ZendJobQueue::FAILED);
	            return $e;
	        }
		}
		$e = new Exception('Job must be passed via a RequestExecute object');
		\ZendJobQueue::setCurrentJobStatus(\ZendJobQueue::OK);
		return $e;
	}
	
	public function createJob(JobAbstract $obj, $queueUrl)
	{
		if ($obj->getJobQueueBinding()){
			$q = new \ZendJobQueue($obj->getJobQueueBinding());
		} else {
			$q = new \ZendJobQueue();
		}
		$qOptions = array(
			'name' => $obj->getJobName()?:get_class($obj)
		);
		if ($obj->getJobExecutionTime()) {
			$qOptions['schedule_time'] = $obj->getJobExecutionTime();
		} else if ($obj->getJobSchedule()) {
			$qOptions['schedule'] = $obj->getJobSchedule();
		}  
		$jobReq = new Execute($obj);
		$num = $q->createHttpJob(
			str_replace('local://', 'http://', $queueUrl),
			array(
				'obj' => $this->getCodec()->encode($jobReq)
			),
			$qOptions
		);
		
		$response = new Response();
		$response->setJobNumber($num);
		
		if (strpos($queueUrl, 'local://') === 0) {
			$response->setQueueUrl(str_replace('local://', 'http://', $queueUrl));
		} else {
			$url =  (isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS'] == "on")?'https':'http';
			$url .= '://';
			$url .= $_SERVER['SERVER_NAME']?$_SERVER['SERVER_NAME']:php_uname('n');
			$url .= ':';
			$url .= $_SERVER['SERVER_PORT'];
			$url .= $_SERVER['REQUEST_URI'];
			$uri = \Zend_Uri_Http::fromString($url);
			$response->setQueueUrl(
				$uri->getUri()
			);
		}
		return $response;
		
	}
}
