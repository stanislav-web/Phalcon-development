<?php
namespace Application\Modules;

use Phalcon\DI;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;

/**
 * Rest module. Current provide REST API access
 *
 * @package Application
 * @subpackage Modules
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /Application/Modules/Rest.php
 */
class Rest
{
    /**
     * Current module name
     * @var const
     */
    const MODULE = 'Rest';

    /**
     * Try to catch uncatchable error 500
     *
     * @throws \Application\Modules\Rest\Exceptions\InternalServerErrorException
     */
    public function __construct() {

        $this->catchShutdown();
    }

    /**
     * Register the autoload specific to the current module
     *
     * @access public
     * @return boolean
     */
    public function registerAutoloaders()
    {
        return true;
    }

    /**
     * Registration services for specific module
     *
     * @param \Phalcon\DI $di
     * @access public
     * @return mixed
     */
    public function registerServices($di)
    {
        // Dispatch register
        $di->set('dispatcher', function () use ($di) {

            $eventsManager = $di->getShared('eventsManager');

            $eventsManager->attach('dispatch:beforeException', new \Application\Modules\Rest\Services\Events\BeforeException\NotFoundEvent(), 150);
            $eventsManager->attach("dispatch:beforeDispatchLoop",  new \Application\Modules\Rest\Services\Events\BeforeDispatchLoop\ResolveParamsEvent(), 100);

            $dispatcher = new \Phalcon\Mvc\Dispatcher();


            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Application\Modules\\' . self::MODULE . '\Controllers');
            $dispatcher->setDefaultAction('index');
            return $dispatcher;
        }, true);

        // Registration of component representations (Views)

        $di->set('view', function () {
            $view = (new View())->disable();
            return $view;
        });

        require_once APP_PATH . '/Modules/' . self::MODULE . '/config/services.php';

    }

    /**
     * Shutdown application while uncatchable error founded
     *
     * @throws \Application\Modules\Rest\Exceptions\InternalServerErrorException
     * @uses \Phalcon\DI
     */
    public function catchShutdown() {

        register_shutdown_function(function() {
            $error = error_get_last();
            if(is_null($error) === false) {

                try {
                    DI::getDefault()->get('LogMapper')->save($error['message'].' File: '.$error['file'].' Line:'.$error['line'], 1);
                    throw new InternalServerErrorException();
                }
                catch(InternalServerErrorException $e) {

                    $response =  DI::getDefault()->get('response');
                    $response->setContentType('application/json', 'utf-8')
                        ->setStatusCode($e->getCode(), $e->getMessage())
                        ->setJsonContent(['error' => [
                            'code' => $e->getCode(),
                            'message' => $e->getMessage()
                        ]])->send();
                }
            }
        });
    }
}