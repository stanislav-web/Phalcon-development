<?php
namespace Libraries\CacheManagement;

/**
 * AwareInterface. Implementing rules necessary functionality for cache classes
 * @package Phalcon
 * @subpackage  Libraries\CacheManagement
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource apps/Libraries/CacheManagement/AwareInterface.php
 */
interface AwareInterface {

	/**
	 * Get adapter configuration
	 * @return array
	 */
	public function getAdapterConfig();

	/**
	 * Get server information
	 * @return array
	 */
	public function getServerStatus();

	/**
	 * Get storage information
	 * @return array
	 */
	public function getStorageStatus();

	/**
	 * Get storage content
	 * @param int $limit limit of records
	 * @return array | mixed
	 */
	public function getPool($limit = 100);

	/**
	 * Invalidate all existing items
	 * @param mixed $params
	 * @return boolean | null
	 */
	public function flushData($params);

	/**
	 * Set item to storage
	 * @param array $data
	 * @return boolean | null
	 */
	public function setData(array $data);

	/**
	 * Delete item from storage
	 * @param array $data
	 * @return boolean | null
	 */
	public function deleteData(array $data);

}