<?php
namespace Application\Modules\Rest\Events\BeforeException;

use Phalcon\Logger;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * NotFoundEvent
 * Handles not-found controller/actions
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeException
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeException/BeforeException.php
 */
class NotFoundEvent {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Setup Dependency container
     *
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function __construct(\Phalcon\DI\FactoryDefault $di) {
        $this->setDi($di);
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function setDi(\Phalcon\DI\FactoryDefault $di)
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
     * This action track routes before execute any action in the application.
     *
     * @param \Phalcon\Events\Event   $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @param                         $exception
     * @throws \Exception
     */
    public function beforeException(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher, $exception) {

        if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
            $this->throwError($exception);
        }
    }

    /**
     * Throw exception errors
     *
     * @throws \Application\Modules\Rest\Exceptions\NotFoundException
     * @throws \Exception
     */
    private function throwError(\Phalcon\Mvc\Dispatcher\Exception $exception) {

        try {

            $this->getDi()->get('LogMapper')->save($exception->getMessage().' File: '.$exception->getFile().' Line:'.$exception->getLine(), Logger::CRITICAL);
            throw new NotFoundException();
        }
        catch(NotFoundException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}