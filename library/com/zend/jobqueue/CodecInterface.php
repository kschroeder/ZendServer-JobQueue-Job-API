<?php

namespace com\zend\jobqueue;

interface CodecInterface
{
	public function encode($object);
	public function decode($string);
	
}