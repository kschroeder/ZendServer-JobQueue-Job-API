<?php

use com\zend\api\method\Generic;
use com\zend\api\Manager;
use com\zend\api\ApiKey;

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

set_include_path(
		realpath(__DIR__ . '/../../library')
		. PATH_SEPARATOR
		. get_include_path()
);

$method = new Generic();
$method->setApiName('monitorGetIssuesListPredefinedFilter');
// $method->setApiName('getSystemInfo');
$method->setQueryStringPayload(
	http_build_query(
		array(
			'filterId'	=> 'All Open Events'
		)
	)
);

$mgr = new Manager();
$apiKey = new ApiKey('test', '0bc011a2731ae6c69df9086a72290ffa5e57da60c3a0ba589d721987b7442126');
$mgr->setApiKey($apiKey);
$mgr->setHost('192.168.0.248');
$mgr->call($method);

var_dump($method->getResult()->getResponse());