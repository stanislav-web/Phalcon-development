<?php
namespace Application\Services\Cache;

use \Phalcon\Cache\Frontend\Data;
use \Phalcon\Cache\Backend\Apc as OpCodeStorage;

/**
 * Class OpCodeService. Opcode cache storage
 *
 * @package Application\Services
 * @subpackage Cache
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Cache/OpCodeService.php
 */
class OpCodeService {

    /**
     * Global config
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
     * Cache data key
     *
     * @var string
     */
    private $key = '';

    /**
     * Init configurations
     *
     * @param \Phalcon\Config $config
     */
    public function __construct(\Phalcon\Config $config) {

        $this->setConfig($config->cache);

        if($config->cache->code === false) {
            $this->getOpStorage()->flush();
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
     * Set cache value into opcode cache storage
     *
     * @param mixed $object
     * @param string $key
     * @param bool $cached
     * @return mixed cached object
     */
    public function set($value, $key, $cached = false)
    {
        if(is_null($this->getConfig()) === false
            && $this->getConfig()->code === true
            && $cached === true) {

            $this->key = $key;
            $this->getOpStorage()->save($this->key, $value);

        }

        return $value;
    }

    /**
     * Check if key is exist in opcode cache
     *
     * @param string $key
     * @return bool
     */
    public function exists($key) {

        if($this->getOpStorage()->exists($key) === true) {
            $this->cached = true;
            return true;
        }
        return false;
    }

    /**
     * Get value from opcode cache storage
     *
     * @param string $key
     * @return mixed
     */
    public function get($key) {

        $this->key = $key;

        return $this->getOpStorage()->get($key);
    }

    /**
     * Get the opcode cache storage
     *
     * @return \Phalcon\Cache\Backend\Apc
     */
    public function getOpStorage() {

        return new OpCodeStorage(new Data(["lifetime" => $this->getConfig()->lifetime]), [
                "prefix"    =>  $this->getConfig()->prefix,
            ]
        );
    }

    /**
     * Return opcode cache lifetime
     *
     * @return int
     */
    public function getLifetime() {
        return $this->getConfig()->lifetime;
    }

    /**
     * Return opcode cache hot key
     *
     * @return string
     */
    public function getKey() {

        return (empty($this->key) === false) ? $this->key : null;
    }

    /**
     * Truncate opcode cache data
     *
     * @return boolean
     */
    public function flush() {
        return $this->getOpStorage()->flush();
    }

    /**
     * Return opcode cache data state
     *
     * @return boolean
     */
    public function isCached() {
        return $this->cached;
    }
}