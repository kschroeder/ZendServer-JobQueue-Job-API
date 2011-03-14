<?php

namespace com\zend\api\response;

class MessageList implements ResponseInterface
{
	
	private $messages = array();
	
    public function getMessages ()
    {
        return $this->messages;
    }

    public function setMessages ($messages)
    {
        $this->messages = $messages;
    }
    
    public function addMessages ($message)
    {
        $this->messages[] = $message;
    }
    
    public function clearMessages()
    {
    	$this->messages = array();
    }

	public function fromXml(\SimpleXMLElement $node)
	{
		foreach ($node as $message){
			$msg = new Message();
    		$msg->fromXml($message);
    		$this->messages[] = $msg;
    	}
    
	}
}