<?php

namespace com\zend\api\method;

class ConfigurationExport extends MethodAbstract
{
	public function processResponse(\Zend_Http_Response $response)
	{
		$this->result = $response->getBody();
	}
}