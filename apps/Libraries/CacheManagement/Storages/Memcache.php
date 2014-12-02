<?php
namespace Libraries\CacheManagement\Storages;
	use Libraries\CacheManagement,
		\Helpers\Node,
		Phalcon\Config;

/**
 * Memcached statistics pool
 * @package Phalcon
 * @subpackage Libraries\CacheManagement
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Libraries/Storages/Memcache.php
 */
class Memcache  implements  CacheManagement\AwareInterface {

	private

		/**
		 * Config memcache
		 * @access private
		 * @var object
		 */
		$_config 	= 	false,

		/**
		 * Resource #ID of connection
		 * @access private
		 * @var bool
	 	 */
		$_connection 	= 	false,

		/**
		 * Server response statuses
		 * @var array
		 */
		$_status		=	[
			100	=>	"Extension %s does not installed",
			101	=>	"Could not Connect to the server %s : %s",
		];

	/**
	 * Init connection to Memcache Server
	 * @param Config $config
	 * @throws CacheManagement\CacheExceptions
	 */
	final public function __construct(Config $config)
	{
		if(!extension_loaded('memcached'))
			throw new CacheManagement\CacheExceptions(printf($this->_status[100], 'memcached'), 100);

		$this->_config	=	$config->cache->memcached;

		if(isset($this->_config))
		{
			$this->_connection = (new \Memcache());
			$this->_connection->connect($this->_config->host, $this->_config->port);
		}

		// if connection lost
		if($this->_connection === false)
			throw new CacheManagement\CacheExceptions(
				printf($this->_status[101],
					$this->_config->host,
					$this->_config->port), 101);
	}

	/**
	 * Get adapter configuration
	 * @return array
	 */
	public function getAdapterConfig()
	{
		return  ini_get_all('memcache');
	}

	/**
	 * Get server status information
	 * @access public
	 * @return array
	 */
	public function getServerStatus()
	{
		return [
			'host'		=>	$this->_config->host,
			'port'		=>	$this->_config->port,
			'stats'		=>	$this->_connection->getStats(),
			'status'	=>	$this->_connection->getServerStatus($this->_config->host, $this->_config->port)
		];
	}

	/**
	 * Get storage information
	 * @access public
	 * @return array
	 */
	public function getStorageStatus()
	{
		return [
			'slabs'	=> 	$this->_connection->getExtendedStats('slabs'),
			'items'	=>	$this->_connection->getExtendedStats('items'),
		];
	}

	/**
	 * Get storage content
	 * @param int $limit limit of records
	 * @access public
	 * @return array|mixed
	 */
	public function getPool($limit = 100)
	{
		$list = [];
		$storage = $this->getStorageStatus();
		foreach($storage['slabs'] as $server => $slabs)
		{
			foreach($slabs AS $slabId => $slabMeta)
			{
				if('active_slabs' == $slabId || "total_malloced" == $slabId) continue;
				try {
					$cdump = $this->_connection->getExtendedStats('cachedump', (int)$slabId, $limit);
				}
				catch (Exception $e) {
					continue;
				}
				foreach($cdump AS $server => $entries)
				{
					if($entries)
					{
						foreach($entries AS $eName => $eData)
						{
							$value = $this->_connection->get($eName);
							$type = gettype($value);
							$value = Node::dataUnserialize($value);
							if(is_object($value) || is_array($value))
							{
								$value = is_object($value)? json_decode(json_encode($value), true): $value;
								$value = Node::arrayMapDeep($value,['\Helpers\Node','dataUnserialize']);
							}
							if($eName != '_PHCM')
								$list[] = [
									'key'   => 	$eName,
									'value' => 	$value,
									'size'	=>	mb_strlen(serialize($value), '8bit'),
									'type'  => 	$type,
								];
						}
					}
				}
			}
		}
		ksort($list);
		return  $list;
	}

	/**
	 * Invalidate all existing items
	 * @param mixed $params
	 * @access public
	 * @return boolean | null
	 */
	public function flushData($params = null)
	{
		$result = $this->_connection->flush();
		if($result)
		{
			$this->getDI()->get('flashSession')->success('Cache data flushed!');
			return true;
		}
		else
		{
			$this->getDI()->get('flashSession')->success('Flush the cache data failed!');
			return false;
		}	}

	/**
	 * Insert new item
	 * @param array $data maybe key => value
	 * @access public
	 * @return boolean | null
	 */
	public function setData(array $data)
	{
		if(isset($data['key']) && isset($data['value']))
			$result = $this->_connection->set($data['key'], $data['value'], MEMCACHE_COMPRESSED);
		return (isset($result)) ? true : false;
	}

	/**
	 * Remove selected item key
	 * @param array $data
	 * @access public
	 * @return boolean | null
	 */
	public function deleteData(array $data)
	{
		if(isset($data['key']))
			$result = $this->_connection->delete($data['key']);

		if($result)
		{
			$this->getDI()->get('flashSession')->success('Cache data #'.$data['key'].' deleted!');
			return true;
		}
		else
		{
			$this->getDI()->get('flashSession')->success('Delete the cache data #'.$data['key'].' failed!');
			return false;
		}
	}
}
