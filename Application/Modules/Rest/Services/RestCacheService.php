<?php
namespace Application\Modules\Rest\Services;

use \Phalcon\Cache\Frontend\Data;
use \Phalcon\Cache\Backend\Memcache;

/**
 * Class RestCacheService. Rest module cache service
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/RestCacheService.php
 */
class RestCacheService {

    /**
     * Rest config
     *
     * @var \Phalcon\Config $config
     */
    private $config;

    /**
     * Cache data state
     *
     * @var bool
     */
    private $cached = false;

    /**
     * Init configurations
     *
     * @param \Phalcon\Config $config
     */
    public function __construct(\Phalcon\Config $config) {

        $this->setConfig($config->cache);

        if($config->cache->enable === false) {
            $this->getStorage()->flush();
        }
    }

    /**
     * Get cache configuration
     *
     * @return \Phalcon\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set cache configuration
     *
     * @param \Phalcon\Config $config
     */
    private function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * Set cache value into cache storage
     *
     * @param mixed $object
     * @param string $key
     * @param bool $cached
     * @return mixed cached object
     */
    public function set($value, $key, $cached = false)
    {
        if(is_null($this->getConfig()) === false
            && $this->getConfig()->enable === true
            && $cached === true) {

            $this->getStorage()->save(md5($key), $value);
        }

        return $value;
    }

    /**
     * Check if key is exist in cache
     *
     * @param string $key
     * @return bool
     */
    public function exists($key) {

        if($this->getStorage()->exists(md5($key)) === true) {
            $this->cached = true;
            return true;
        }
        return false;
    }

    /**
     * Get value from cache storage
     * @param string $key
     * @return mixed
     */
    public function get($key) {
        return $this->getStorage()->get(md5($key));
    }

    /**
     * Get the cache storage
     *
     * @return \Phalcon\Cache\Backend\Memcache
     */
    public function getStorage() {

        return new Memcache(new Data(["lifetime" => $this->getConfig()->lifetime]),
            [
                "prefix"    =>  $this->getConfig()->prefix,
                "host"      =>  $this->getConfig()->memcached->host,
                "port"      =>  $this->getConfig()->memcached->port
            ]
        );
    }

    /**
     * Return cache data state
     *
     * @return boolean
     */
    public function isCached() {

        return $this->cached;
    }
}