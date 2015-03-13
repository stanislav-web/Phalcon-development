<?php
namespace Application\Modules\Rest\Plugins\Dispatcher;

use \Phalcon\Events\Event;
use \Phalcon\Mvc\Dispatcher as MvcDispatcher;
use \Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use \Phalcon\Http\Response\Exception as RestException;
use \Phalcon\Http\Response;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * NotFoundExceptionPlugin
 * Handles server's 404 Error
 *
 * @package Application\Modules\Rest\Plugins
 * @subpackage Dispatcher
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Plugins/Dispatcher/NotFoundExceptionPlugin.php
 */
class NotFoundExceptionPlugin
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

            try {
                throw new NotFoundException();
            }
            catch(RestException $e) {
                $response = new Response();

                $response->setContentType('application/json', 'utf-8')
                    ->setStatusCode($e->getCode(), $e->getMessage())
                    ->setJsonContent(['code' => $e->getCode(), 'message' => $e->getMessage()])->send();
                return $event->isStopped();
            }
        }
    }
}