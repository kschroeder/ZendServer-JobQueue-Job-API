<?php

namespace com\zend\jobqueue\codec;

class EncryptedCodec implements CodecInterface
{
	
	private $key;
	private $cipher;
	private $mode;
	private $rand;
	
	public function __construct($key, $cipher = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_ECB, $rand = MCRYPT_RAND)
	{
		$this->key		= $key;
		$this->cipher 	= $cipher;
		$this->mode 	= $mode;
		$this->rand 	= $rand;
	}
	
    public function decode ($string)
    {
        $iv_size = mcrypt_get_iv_size($this->cipher, $this->mode);
	    $iv = mcrypt_create_iv($iv_size, $this->rand);
	    $string = base64_decode($string);
	    $decrypt = mcrypt_decrypt($this->cipher, $this->key, $string, $this->mode, $iv);
	    return unserialize($decrypt);
    }
	
    public function encode ($object)
    {
	    $iv_size = mcrypt_get_iv_size($this->cipher, $this->mode);
	    $iv = mcrypt_create_iv($iv_size, $this->rand);
	    $enc = mcrypt_encrypt($this->cipher, $this->key, serialize($object), $this->mode, $iv);
        return base64_encode($enc);
    }

	
}