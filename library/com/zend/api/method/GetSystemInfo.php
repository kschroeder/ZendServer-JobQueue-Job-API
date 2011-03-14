<?php

namespace com\zend\api\method;

use com\zend\api\response\MessageList;

use com\zend\api\response\Message;

use com\zend\api\response\ManagerLicenseInfo;

use com\zend\api\response\ServerLicenseInfo;

use com\zend\api\response\SystemInfo;

class GetSystemInfo extends MethodAbstract
{

	
    public function processResponse(\Zend_Http_Response $response)
    {
    	$xml = simplexml_load_string($response->getBody());
    	$data = $xml->responseData->systemInfo;
    	if (!$data) {
    		throw new MethodException('Invalid XML format');
    	}
    	$si = new SystemInfo();
    	$si->fromXml($data);
    	
    	$sli = new ServerLicenseInfo();
    	$sli->fromXml($data->serverLicenseInfo);
    	   	
    	$si->setServerLicenseInfo($sli);
    	
    	$mli = new ManagerLicenseInfo();
    	$mli->fromXml($data->managerLicenseInfo);
    	
    	$si->setManagerLicenseInfo($mli);
    	
    	$msgLst = new MessageList();
    	$msgLst->fromXml($data->messageList);
    	
    	$si->setMessageList($msgLst);
    	
    	$this->result = $si;
    }
	
}