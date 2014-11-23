<?php
namespace Libraries\CacheManagement\Storages;
	use Libraries\CacheManagement,
		Phalcon\Config;

/**
 * Apc statistics pool
 * @package Phalcon
 * @subpackage Libraries\CacheManagement
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Libraries/Storages/Apc.php
 */
class Apc  implements  CacheManagement\AwareInterface {

	private

		/**
		 * Config memcache
		 * @access private
		 * @var object
		 */
		$_config 	= 	false,

		/**
		 * Server response statuses
		 * @var array
		 */
		$_status		=	[
			100	=>	"Extension %s does not installed",
		];

	/**
	 * Initialize apc config
	 * @return \Phalcon\Db\Adapter\PDO
	 */
	public function initialize()
	{
		if(!extension_loaded('apc'))
			throw new CacheManagement\CacheExceptions(printf($this->_status[100], 'apc'), 100);

		$this->_config	=	 false;
	}

	/**
	 * Get adapter configuration
	 * @return array
	 */
	public function getAdapterConfig()
	{
		return  ini_get_all('apc');
	}

	/**
	 * Get server status information
	 * @access public
	 * @return array
	 */
	public function getServerStatus()
	{

	}

	/**
	 * Get storage information
	 * @access public
	 * @return array
	 */
	public function getStorageStatus()
	{

	}

	/**
	 * Get storage content
	 * @param int $limit limit of records
	 * @access public
	 * @return array|mixed
	 */
	public function getPool($limit = 100)
	{
		return [];
	}

	/**
	 * Invalidate all existing items
	 * @param mixed $params
	 * @access public
	 * @return boolean | null
	 */
	public function flushData($params = null)
	{

	}

	/**
	 * Insert new item
	 * @param array $data maybe key => value
	 * @access public
	 * @return boolean | null
	 */
	public function setData(array $data)
	{

	}

	/**
	 * Remove selected item key
	 * @param array $data
	 * @access public
	 * @return boolean | null
	 */
	public function deleteData(array $data)
	{

	}
}
