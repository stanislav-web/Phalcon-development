<?php
namespace Application\Aware;

/**
 * CliAwareInterface interface. Command line task's interface
 *
 * @package Application
 * @subpackage Aware
 * @since      PHP >=5.6
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Aware/CliAwareInterface.php
 */
interface CliAwareInterface {

    /**
     * Setup current task configurations
     *
     * @param \Phalcon\Config $config
     * @return \Application\Aware\CliAwareInterface
     */
    public function setConfig(\Phalcon\Config $config);

    /**
     * Get current task configurations
     *
     * @return \Phalcon\Config
     */
    public function getConfig();

    /**
     * Setup file logger
     *
     * @return \Application\Aware\CliAwareInterface
     */
    public function setLogger();

    /**
     * Get logger
     *
     * @return \Phalcon\Logger\Adapter\File
     */
    public function getLogger();

    /**
     * Setup db connection resource
     *
     * @return \Application\Aware\CliAwareInterface
     */
    public function setDb();

    /**
     * Get db adapter
     *
     * @return  \Phalcon\Db\Adapter\Pdo\Mysql
     */
    public function getDb();

    /**
     * Console style helper
     *
     * @return  \Phalcon\Script\Color
     */
    public function styleHelper();
}