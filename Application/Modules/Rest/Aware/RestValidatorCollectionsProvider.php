<?php
namespace Application\Modules\Rest\Aware;
use Phalcon\DI\InjectionAwareInterface;

/**
 * RestValidatorCollectionsProvider. Rest API Provide validation services
 *
 * @package Application\Modules\Rest
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Rest/Aware/RestValidatorCollectionsProvider.php
 */
abstract class RestValidatorCollectionsProvider {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Setup validators
     *
     * @param array $validators
     */
    public function __construct(array $validators) {
        $this->setValidators($validators);
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Get dispatcher instance
     *
     * @return \Phalcon\Mvc\Dispatcher
     */
    public function getDispatcher()
    {
        return $this->getDi()->getShared('dispatcher');
    }

    /**
     * Get api config
     *
     * @return \Phalcon\Config
     */
    public function getConfig()
    {
        return $this->getDi()->get('RestConfig')->api;
    }
}