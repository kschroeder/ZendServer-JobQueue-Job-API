<?php

namespace com\zend\api\response;

class SystemInfo implements ResponseInterface
{
	private $status;
	private $edition;
	private $zendServerVersion;
    private $supportedApiVersions;
    private $phpVersion;
    private $operatingSystem;
    /**
     * @var ServerLicenseInfo
     */
    private $serverLicenseInfo;
    /**
     * @var ManagerLicenseInfo
     */
    private $managerLicenseInfo;
    
    private $messageList;
	/**
     * @return the $status
     */
    public function getStatus ()
    {
        return $this->status;
    }

	/**
     * @return the $edition
     */
    public function getEdition ()
    {
        return $this->edition;
    }

	/**
     * @return the $zendServerVersion
     */
    public function getZendServerVersion ()
    {
        return $this->zendServerVersion;
    }

	/**
     * @return the $supportedApiVersions
     */
    public function getSupportedApiVersions ()
    {
        return $this->supportedApiVersions;
    }

	/**
     * @return the $phpVersion
     */
    public function getPhpVersion ()
    {
        return $this->phpVersion;
    }

	/**
     * @return the $operatingSystem
     */
    public function getOperatingSystem ()
    {
        return $this->operatingSystem;
    }

	/**
     * @return the $serverLicenseInfo
     * @return ServerLicenseInfo;
     */
    public function getServerLicenseInfo ()
    {
        return $this->serverLicenseInfo;
    }

	/**
     * @return the $managerLicenseInfo
     * @return ManagerLicenseInfo;
     */
    public function getManagerLicenseInfo ()
    {
        return $this->managerLicenseInfo;
    }

	/**
     * @return the $messageList
     */
    public function getMessageList ()
    {
        return $this->messageList;
    }

	/**
     * @param field_type $status
     */
    public function setStatus ($status)
    {
        $this->status = $status;
    }

	/**
     * @param field_type $edition
     */
    public function setEdition ($edition)
    {
        $this->edition = $edition;
    }

	/**
     * @param field_type $zendServerVersion
     */
    public function setZendServerVersion ($zendServerVersion)
    {
        $this->zendServerVersion = $zendServerVersion;
    }

	/**
     * @param field_type $supportedApiVersions
     */
    public function setSupportedApiVersions ($supportedApiVersions)
    {
        $this->supportedApiVersions = $supportedApiVersions;
    }

	/**
     * @param field_type $phpVersion
     */
    public function setPhpVersion ($phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }

	/**
     * @param field_type $operatingSystem
     */
    public function setOperatingSystem ($operatingSystem)
    {
        $this->operatingSystem = $operatingSystem;
    }

	/**
     * @param ServerLicenseInfo $serverLicenseInfo
     * 
     */
    public function setServerLicenseInfo (ServerLicenseInfo $serverLicenseInfo)
    {
        $this->serverLicenseInfo = $serverLicenseInfo;
    }

	/**
     * @param ServerLicenseInfo $managerLicenseInfo
     
     */
    public function setManagerLicenseInfo (ManagerLicenseInfo $managerLicenseInfo)
    {
        $this->managerLicenseInfo = $managerLicenseInfo;
    }

	/**
     * @param field_type $messageList
     */
    public function setMessageList ($messageList)
    {
        $this->messageList = $messageList;
    }

    public function fromXml(\SimpleXMLElement $node)
	{
		
    	$this->setStatus((string)$node->status);
    	$this->setEdition((string)$node->edition);
    	$this->setZendServerVersion((string)$node->zendServerVersion);
    	$this->setSupportedApiVersions(explode(',', (string)$node->supportedApiVersions));
    	$this->setPhpVersion((string)$node->phpVersion);
    	$this->setOperatingSystem((string)$node->operatingSystem);
    	return $this;
	}
}