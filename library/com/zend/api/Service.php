<?php

namespace com\zend\api;

use com\zend\api\method\RestartPHP;

use com\zend\api\method\ClusterEnableServer;

use com\zend\api\method\ClusterDisableServer;

use com\zend\api\method\ClusterRemoveServer;

use com\zend\api\response\ServerInfo;

use com\zend\api\method\ClusterAddServer;

use com\zend\api\method\ClusterGetServerStatus;

use com\zend\api\method\GetSystemInfo;

class Service
{
	
	private static $defaultMgr;
	private $mgr;
	
	public static function setDefaultManager(Manager $mgr)
	{
		self::$defaultMgr = $mgr;
	}
	
	public function setManager(Manager $mgr)
	{
		$this->mgr = $mgr;
	}
	
	public function getManager()
	{
		if ($this->mgr instanceof Manager) {
			return $this->mgr;
		}
		return self::$defaultMgr;
	}
	
	public function getSystemInfo()
	{
		$si = new GetSystemInfo();
		return $this->getManager()->call($si)->getResult();
	}

	public function clusterGetServerStatus($servers = null)
	{
		$serverStatus = new ClusterGetServerStatus($servers);
		return $this->getManager()->call($serverStatus)->getResult();
	}

	public function clusterAddServer(ServerInfo $srv)
	{
		$addServer = new ClusterAddServer($srv);
		return $this->getManager()->call($addServer)->getResult();
	}

	public function clusterRemoveServer(ServerInfo $srv)
	{
		$removeServer = new ClusterRemoveServer($srv);
		return $this->getManager()->call($removeServer)->getResult();
	}

	public function clusterDisableServer(ServerInfo $srv)
	{
		$disableServer = new ClusterDisableServer($srv);
		return $this->getManager()->call($disableServer)->getResult();
	}

	public function clusterEnableServer(ServerInfo $srv)
	{
		$enableServer = new ClusterEnableServer($srv);
		return $this->getManager()->call($enableServer)->getResult();
	}

	public function restartPHP($srv = null)
	{
		$restartPHP = new RestartPHP($srv);
		return $this->getManager()->call($restartPHP)->getResult();
	}

	public function configurationExport()
	{
		
	}

	public function configurationImport()
	{
		
	}
	
	
}