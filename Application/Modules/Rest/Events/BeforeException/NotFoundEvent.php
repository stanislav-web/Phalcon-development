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
     * This action track routes before execute any action in the application.
     *
     * @param \Phalcon\Events\Event   $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @param                         $exception
     * @throws \Exception
     */
    public function beforeException(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher, $exception) {

        if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
            throw new NotFoundException();
        }
    }
}