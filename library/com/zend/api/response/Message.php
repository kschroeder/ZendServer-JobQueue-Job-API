<?php

namespace com\zend\api\response;

class Message implements ResponseInterface
{
	
	private $type;
	private $message;
	
	/**
     * @return the $type
     */
    public function getType ()
    {
        return $this->type;
    }

	/**
     * @return the $message
     */
    public function getMessage ()
    {
        return $this->message;
    }

	/**
     * @param field_type $type
     */
    public function setType ($type)
    {
        $this->type = $type;
    }

	/**
     * @param field_type $message
     */
    public function setMessage ($message)
    {
        $this->message = $message;
    }

	public function __construct($type = null, $message = null)
	{
		$this->type = $type;
		$this->message = $message;
	}
	
	public function fromXml(\SimpleXMLElement $node)
	{
		
		$this->type = (string)$node->getName();
		$this->message = (string)$node;
	}
}