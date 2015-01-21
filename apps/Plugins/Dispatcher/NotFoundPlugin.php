<?php
namespace Plugins\Dispatcher;

use Phalcon\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Phalcon\Http\Response;

/**
 * NotFoundPlugin
 *
 * Handles not-found controller/actions
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
                    'namespace'     => 'Modules\Frontend\Controllers',
                    'controller'    => 'Error',
                    'action'        => 'notFound'
                ]
            );

            return $event->isStopped();
        }

        // Handle other exceptions.
        $dispatcher->forward([
                'module'        => 'Frontend',
                'namespace'     => 'Modules\Frontend\Controllers',
                'controller'    => 'Error',
                'action'        => 'uncaughtException'
            ]
        );

        return $event->isStopped();
    }
}