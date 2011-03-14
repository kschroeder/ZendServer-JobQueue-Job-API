<?php

namespace com\zend\api\method;

use com\zend\api\response\ServerInfo;

use com\zend\api\response\ServerInfoList;

class ConfigurationImport extends MethodAbstract
{
	private $dataFileContents;

    /* (non-PHPdoc)
     * @see com\zend\api\method.MethodAbstract::getRequestMethod()
     */
    public function getRequestMethod ()
    {
    	return 'POST';        
    }

	/**
     * @return the $dataFileContents
     */
    public function getDataFileContents ()
    {
        return $this->dataFileContents;
    }

	/**
     * @param field_type $dataFileContents
     */
    public function setDataFileContents ($dataFileContents)
    {
        $this->dataFileContents = $dataFileContents;
    }

	public function preprocessClient (\Zend_Http_Client $client)
    {
    	$client->setFileUpload(uniqid() . '.zcfg', 'configFile', $this->dataFileContents, 'application/vnd.zend.serverconfig');
    }

	public function processResponse(\Zend_Http_Response $response)
	{
		$xml = simplexml_load_string($response->getBody());
		if (!$xml->responseData->serversList) {
			throw new MethodException('Invalid XML format');
		}
		$this->result = array();
		foreach ($xml->responseData->serversList as $server) {
			$si = new ServerInfo();
			$si->fromXml($server->serverInfo);
			$this->result[] = $si;
		}
	}
}