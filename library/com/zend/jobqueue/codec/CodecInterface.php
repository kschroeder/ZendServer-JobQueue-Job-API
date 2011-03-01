<?php

namespace com\zend\jobqueue\codec;

interface CodecInterface
{
	public function encode($object);
	public function decode($string);
	
}