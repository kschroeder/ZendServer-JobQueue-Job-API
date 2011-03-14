<?php

namespace com\zend\api\response;

class ManagerLicenseInfo implements ResponseInterface
{
	private $status;
    private $orderNumber;
    private $validUntil;
    private $serverLimit;
	/**
     * @return the $status
     */
    public function getStatus ()
    {
        return $this->status;
    }

	/**
     * @return the $orderNumber
     */
    public function getOrderNumber ()
    {
        return $this->orderNumber;
    }

	/**
     * @return the $validUntil
     */
    public function getValidUntil ()
    {
        return $this->validUntil;
    }

	/**
     * @return the $serverLimit
     */
    public function getServerLimit ()
    {
        return $this->serverLimit;
    }

	/**
     * @param field_type $status
     */
    public function setStatus ($status)
    {
        $this->status = $status;
    }

	/**
     * @param field_type $orderNumber
     */
    public function setOrderNumber ($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

	/**
     * @param field_type $validUntil
     */
    public function setValidUntil ($validUntil)
    {
        $this->validUntil = $validUntil;
    }

	/**
     * @param field_type $serverLimit
     */
    public function setServerLimit ($serverLimit)
    {
        $this->serverLimit = $serverLimit;
    }

    public function fromXml(\SimpleXMLElement $node)
    {
    	$this->setStatus((string)$node->status);
    	$this->setOrderNumber((string)$node->orderNumber);
    	$this->setValidUntil((string)$node->validUntil);
    	$this->setServerLimit((string)$node->serverLimit);
    }
    
}