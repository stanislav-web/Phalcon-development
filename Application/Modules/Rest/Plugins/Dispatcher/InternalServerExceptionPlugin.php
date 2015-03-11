<?php
namespace Application\Modules\Rest\Plugins\Dispatcher;

use Application\Modules\Rest\Exceptions\InternalServerErrorException;
use \Phalcon\Http\Response;

/**
 * InternalServerExceptionPlugin
 * Handles server's 500 Internal Server Errors
 *
 * @package Application\Modules\Rest\Plugins
 * @subpackage Dispatcher
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Plugins/Dispatcher/InternalServerExceptionPlugin.php
 */
class InternalServerExceptionPlugin
{
    /**
     * Shutdown application while uncatchable error founded
     *
     * @throws \Application\Modules\Rest\Exceptions\InternalServerErrorException
     */
    public function shutdown() {

        return register_shutdown_function(function() {
            $error = error_get_last();

            if(is_null($error) === false) {
                try {
                    throw new InternalServerErrorException();
                }
                catch(\RuntimeException $e) {

                    $response = new Response();

                    $response->setContentType('application/json', 'utf-8')
                        ->setStatusCode($e->getCode(), $e->getMessage())
                        ->setJsonContent(['code' => $e->getCode(), 'message' => $e->getMessage()])->send();
                }
            }
        });
    }
}