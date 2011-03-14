<?php

namespace com\zend\api\response;

class ServerInfo implements ResponseInterface
{
	
	const STATUS_REMOVED 			= 'removed';
	const STATUS_OK					= 'OK';
    const STATUS_SHUTTING_DOWN		= 'shuttingDown';
    const STATUS_STARTING_UP		= 'startingUp';
    const STATUS_PENDING_RESTART 	= 'pendingRestart';
    const STATUS_RESTARTING			= 'restarting';
    const STATUS_MISCONFIGURED		= 'misconfigured';
    const STATUS_EXTENSION_MISMATCH = 'extensionMismatch';
    const STATUS_DAEMON_MISMATCH	= 'daemonMismatch';
    const STATUS_NOT_RESPONDING		= 'notResponding';
    const STATUS_DISABLED			= 'disabled';
    const STATUS_UNKNOWN			= 'unknown';
	
	
	  private $id;
      private $name;
      private $address;
      private $status;
      private $password;
      private $messageList;
      
      public function __construct($name = null, $address = null, $password = null)
      {
      	  if (strpos($address, 'http://') === false) {
	      	$address = 'http://' . $address . ':10081/ZendServer';
	      }
	      $this->name = $name;
	      $this->address = $address;
	      $this->password = $password;
      }
      
      public function appendToNode(\SimpleXMLElement $e)
      {
      	  $node = $e->addChild('serverInfo');
      	  $node->id = $this->id;
	      $node->name = $this->name;
	      $node->address = $this->address;
	      $node->status = $this->status;
      }
    
	/**
     * @return the $id
     */
    public function getId ()
    {
        return $this->id;
    }

	/**
     * @return the $name
     */
    public function getName ()
    {
        return $this->name;
    }

	/**
     * @return the $address
     */
    public function getAddress ()
    {
        return $this->address;
    }

	/**
     * @return the $status
     */
    public function getStatus ()
    {
        return $this->status;
    }

	/**
     * @param field_type $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

	/**
     * @param field_type $name
     */
    public function setName ($name)
    {
        $this->name = $name;
    }

	/**
     * @param field_type $address
     */
    public function setAddress ($address)
    {
        $this->address = $address;
    }

	/**
     * @param field_type $status
     */
    public function setStatus ($status)
    {
        $this->status = $status;
    }

 	/**
     * @return the $messageList
     */
    public function getMessageList ()
    {
        return $this->messageList;
    }

	/**
     * @param field_type $messageList
     */
    public function setMessageList (MessageList $messageList)
    {
        $this->messageList = $messageList;
    }
	/**
     * @return the $password
     */
    public function getPassword ()
    {
        return $this->password;
    }

	/**
     * @param field_type $password
     */
    public function setPassword ($password)
    {
        $this->password = $password;
    }

    public function fromXml(\SimpleXMLElement $node)
    {
    	$this->setAddress((string)$node->address);
    	$this->setId((string)$node->id);
    	$ml = new MessageList();
    	if ($node->messageList) {
    		$ml->fromXml($node->messageList);
    	}
    	$this->setMessageList($ml);
    	$this->setName((string)$node->name);
    	$this->setPassword((string)$node->password);
    	$this->setStatus((string)$node->status);
    }      
}