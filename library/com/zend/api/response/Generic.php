<?php

namespace com\zend\api\response;

class Generic implements ResponseInterface
{
	
	protected $response;
	
    public function getResponse()
    {
        return $this->response;
    }
	
    public function setResponse($response)
    {
    	$this->response = $response;
    }
}