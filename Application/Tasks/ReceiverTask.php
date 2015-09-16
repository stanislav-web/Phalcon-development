<?php
use \Application\Aware\CliAwareInterface;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\CLI\Task;

/**
 * Class ReceiverTask. Do the MySQL backup tables
 *
 * @package Application
 * @subpackage Tasks
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Tasks/ReceiverTask.php
*/
class ReceiverTask extends Task implements CliAwareInterface
{
    /**
     * Task configuration
     *
     * @var \Phalcon\Config $config
     */
    private $config;

    /**
     * Octopussy configuration
     *
     * @var \Octopussy\Services\AppService $receiver
     */
    private $receiver;

    /**
     * Logger
     *
     * @var \Phalcon\Logger\Adapter\File $logger
     */
    private $logger;

    /**
     * Setup current task configurations
     *
     * @param \Phalcon\Config $config
     * @return \Application\Aware\CliAwareInterface
     */
    public function setConfig(\Phalcon\Config $config)  {

        $this->config = $config->cli->{CURRENT_TASK};

        return $this;
    }

    /**
     * Get current task configurations
     *
     * @return \Phalcon\Config
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * Setup file logger
     *
     * @return \Application\Aware\CliAwareInterface
     */
    public function setLogger() {

        $this->logger = new FileAdapter($this->getConfig()->logfile);

        return $this;
    }

    /**
     * Get logger
     *
     * @return \Phalcon\Logger\Adapter\File
     */
    public function getLogger() {
        return $this->logger;
    }

    /**
     * Setup db connection resource
     *
     * @return \Application\Aware\CliAwareInterface
     */
    public function setDb() {}

    /**
     * Get db adapter
     *
     * @return  \Phalcon\Db\Adapter\Pdo\Mysql
     */
    public function getDb() {}

    /**
     * Console style helper
     *
     * @return  \Phalcon\Script\Color
     */
    public function styleHelper() {
        return $this->getDI()->get('color');
    }

    /**
     * Initialize task
     */
    public function mainAction()
    {

        try {

            // init configurations // init logger
            $this->setConfig($this->getDI()->get('config'))->setLogger()->setDb();
            $this->receiver = $this->getDI()->get('Octopussy', [$this->getConfig()]);
            $this->receiver->run();

        }
        catch(\Octopussy\Exceptions\AppException $e) {
            echo $this->styleHelper()->error($e->getMessage());
            $this->logger->log($e->getMessage(), \Phalcon\Logger::CRITICAL);
        }
    }
}