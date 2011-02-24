<?php

require_once '../bootstrap.php';

use com\zend\jobqueue\Manager;

$mgr = new Manager();
$mgr->invoke();