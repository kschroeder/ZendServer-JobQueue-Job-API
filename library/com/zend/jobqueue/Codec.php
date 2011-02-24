<?php

namespace com\zend\jobqueue;

class Codec implements CodecInterface
{
	
	public function encode($object)
	{
		return base64_encode(serialize($object));
	}
	
	public function decode($string)
	{
		return unserialize(base64_decode($string));
	}
	
}