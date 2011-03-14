<?php

use com\zend\api\ApiKey;
use com\zend\api\response\ServerInfo;
use com\zend\api\method\ClusterAddServer;
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
$apiKey = new ApiKey('kevin', '59455fb2e117e00bdcf04b37f9942da105e6bfd6a6cccf330fe79c79e89ddd4c');
$mgr->setApiKey($apiKey);
$mgr->setHost('192.168.0.242');
$addServer = new ClusterAddServer(
	new ServerInfo('local', 'http://192.168.0.254:10081', 'password')
);
$mgr->call($addServer);