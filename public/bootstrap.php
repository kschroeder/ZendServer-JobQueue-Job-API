<?php

use com\zend\jobqueue\Manager;
use com\zend\jobqueue\codec\EncryptedCodec;
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(__DIR__ . '/../library'),
    realpath(__DIR__ . '/../jobs'),
    get_include_path(),
)));

Manager::setDefaultUrl('local://localhost/q/');
