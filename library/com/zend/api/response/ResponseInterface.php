<?php

namespace com\zend\api\response;

interface ResponseInterface
{
	
	public function fromXml(\SimpleXMLElement $e);
	
}