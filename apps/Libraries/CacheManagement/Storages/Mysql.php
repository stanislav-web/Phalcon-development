<?php
namespace Libraries\CacheManagement\Storages;

use Libraries\CacheManagement;
use Phalcon\Config;
use Phalcon\Mvc\Model\Resultset\Simple as ResultSet;

/**
 * MySQL statistics pool
 * @package Phalcon
 * @subpackage Libraries\CacheManagement
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Libraries/Storages/Mysql.php
 */
class Mysql extends \Phalcon\Mvc\Model
    implements CacheManagement\AwareInterface
{

    private

        /**
         * Config memcache
         * @access private
         * @var object
         */
        $_config = false,

        /**
         * Connection manager
         * @access private
         * @var bool
         */
        $_connection = false,

        /**
         * Cache object to save getRows data
         * @access private
         * @var bool
         */
        $_cache = false,

        /**
         * Server response statuses
         * @var array
         */
        $_status = [
        100 => "Extension %s does not installed",
        101 => "Could not Connect to the %s server %s : %s",
    ];

    /**
     * Get connection to MySQL Server
     * @return \Phalcon\Db\Adapter\PDO
     */
    public function initialize()
    {
        if (!extension_loaded('PDO'))
            throw new CacheManagement\CacheExceptions(printf($this->_status[100], 'PDO'), 100);

        $this->_config = $this->getDI()->get('config');

        $this->_connection = $this->getReadConnection();
        // if not current model connection
        if (!$this->_connection)
            throw new CacheManagement\CacheExceptions(
                printf($this->_status[101],
                    $this->_config->database->adapter,
                    $this->_config->database->host,
                    $this->_config->database->port), 101);

        // checking cache
        $this->_cache = $this->_config->cache->enable;
    }

    /**
     * Get adapter configuration
     * @return array
     */
    public function getAdapterConfig()
    {
        return ini_get_all('mysql');
    }

    /**
     * Get server status information
     * @access public
     * @return array
     */
    public function getServerStatus()
    {
        $result = null;

        if ($this->_cache === true) {
            $dbCache = $this->getDI()->get('dbCache');
            $key = md5(__METHOD__);
            $result = $dbCache->get($key);
        }

        if ($result === null) {
            $phql = "SHOW GLOBAL STATUS";
            $query = new Resultset(null, null, $this->_connection->query($phql), $this->_cache);
            $result = $query->toArray();
            $result = \Helpers\Node::arrayToPair($result);
            if ($this->_cache === true) $dbCache->save($key, $result);
        }
        $result = array_merge($result, (array)$this->_config->database, (array)$this->getStorageStatus());

        return $result;
    }

    /**
     * Get storage information
     * @access public
     * @return array
     */
    public function getStorageStatus()
    {
        $result = null;

        if ($this->_cache === true) {
            $dbCache = $this->getDI()->get('dbCache');
            $key = md5(__METHOD__);
            $result = $dbCache->get($key);
        }

        if ($result === null) {
            $phql = "SHOW VARIABLES";
            $query = new Resultset(null, null, $this->_connection->query($phql), $this->_cache);
            $result = $query->toArray();
            $result = \Helpers\Node::arrayToPair($result);
            if ($this->_cache === true) $dbCache->save($key, $result);
        }
        return $result;
    }

    /**
     * Get storage content
     * @param int $limit limit of records
     * @access public
     * @return array|mixed
     */
    public function getPool($limit = 100)
    {
        // MySQl doesn't support query cache viewer
        return false;
    }

    /**
     * Defragmentation of sql cache
     * @param mixed $params
     * @access public
     * @return boolean | null
     */
    public function flushData($params = null)
    {
        $phql = "FLUSH QUERY CACHE";

        $query = $this->_connection->query($phql);
        $result = $query->execute();

        if ($result) {
            $this->getDI()->get('flashSession')->success('Cache data flushed!');
            return true;
        } else {
            $this->getDI()->get('flashSession')->success('Flush the cache data failed!');
            return false;
        }
    }

    /**
     * Reset MySQL cache
     * @param array $data
     * @access public
     * @return boolean | null
     */
    public function deleteData(array $data = [])
    {
        $phql = "RESET QUERY CACHE";

        $query = $this->_connection->query($phql);
        $result = $query->execute();
        if ($result) {
            $this->getDI()->get('flashSession')->success('Cache data deleted!');
            return true;
        } else {
            $this->getDI()->get('flashSession')->success('Delete the cache data failed!');
            return false;
        };
    }

    /**
     * Insert Items
     * @deprecated but don't need to remove
     * @param array $data maybe key => value
     * @access public
     * @return boolean | null
     */
    public function setData(array $data)
    {
    }

}
