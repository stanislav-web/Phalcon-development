<?php
namespace Plugins\Dispatcher;

use Phalcon\Events\Event;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

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
	public function beforeException(Event $event, MvcDispatcher $dispatcher, Exception $exception)
	{
		if($exception instanceof DispatcherException)
		{
			switch ($exception->getCode())
			{
				case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
				case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
					$dispatcher->forward(array(
						'controller' => 'errors',
						'action' => 'notFound'
					));
					return false;
			}
		}
		$dispatcher->forward(array(
			'controller' => 'errors',
			'action'     => 'uncaughtException'
		));
		return false;
	}
}