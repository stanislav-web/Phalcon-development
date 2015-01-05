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
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeException(Event $event, MvcDispatcher $dispatcher, $exception)
    {

        if ($exception instanceof DispatcherException) {


            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:

                return (new Response())->redirect(array(
                        "for"       => "not-found",
                        'module'     => 'Frontend',
                        'controller' => 'errors',
                        'action'     => 'notFound'
                    ));
            }
        }

        return (new Response())->redirect(array(
            "for"           => "error",
            'module'        => 'Frontend',
            'controller'    => 'errors',
            'action'        => 'uncaughtException'
        ));

        return false;
    }
}