<?php

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

set_include_path(
	realpath(__DIR__ . '/../library')
	. PATH_SEPARATOR
	. get_include_path()
);
