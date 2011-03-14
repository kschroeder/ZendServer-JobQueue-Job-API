<?php

use com\zend\api\method\RestartPhp;
use com\zend\api\ApiKey;
use com\zend\api\response\ServerInfo;
use com\zend\api\Manager;
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

set_include_path(
	realpath(__DIR__ . '/../../library')
	. PATH_SEPARATOR
	. get_include_path()
);

// start API calls

$mgr = new Manager();
$apiKey = new ApiKey('kevin', 'b562c7a6a46a9495df03e0b2c083f3ccfdb0de606b1abab05d056898fd6f410b');
$mgr->setApiKey($apiKey);
$mgr->setHost('192.168.0.246');

$restart = new RestartPhp();
$mgr->call($restart);