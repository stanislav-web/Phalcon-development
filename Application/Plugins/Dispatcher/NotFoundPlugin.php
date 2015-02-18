<?php
namespace Application\Plugins\Dispatcher;

use Phalcon\Events\Event;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;

/**
 * NotFoundPlugin
 * Handles not-found controller/actions
 *
 * @package Application
 * @subpackage Plugins
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Plugins/Debugger/Develop.php
 */
class NotFoundPlugin
{
    /**
     * This action is executed before execute any action in the application.
     *
     * @param Event            $event      Event object.
     * @param MvcDispatcher    $dispatcher Dispatcher object.
     * @param DispatcherException $exception  Exception object.
     *
     * @return bool
     */
    public function beforeException(Event $event, MvcDispatcher $dispatcher, $exception)
    {

        if ($exception instanceof DispatcherException) {

            // Handle 404 exceptions

            $dispatcher->forward([
                    'module'        => 'Frontend',
                    'namespace'     => 'Application\Modules\Frontend\Controllers',
                    'controller'    => 'Error',
                    'action'        => 'notFound'
                ]
            );

            return $event->isStopped();
        }

        // save to log
        \Phalcon\DI::getDefault()->get('LogDbService')->save($exception->getMessage(), \Phalcon\Logger::CRITICAL);

        if (APPLICATION_ENV === 'production') { // production

            // Handle other exceptions.
            $dispatcher->forward([
                    'module' => 'Frontend',
                    'namespace' => 'Application\Modules\Frontend\Controllers',
                    'controller' => 'Error',
                    'action' => 'uncaughtException'
                ]
            );

            return $event->isStopped();
        }
    }
}