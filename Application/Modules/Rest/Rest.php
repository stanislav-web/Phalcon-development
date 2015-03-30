<?php
namespace Application\Modules;

use Phalcon\DI;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Application\Modules\Rest\Services\RestExceptionHandler;
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
     * Register the autoload specific to the current module
     */
    public function registerAutoloaders($di)  {

        register_shutdown_function([$this, 'catchShutdown'], $di);
    }

    /**
     * Registration services for specific module
     *
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function registerServices(\Phalcon\DI\FactoryDefault $di)
    {
        // Dispatch register

        $di->setShared('dispatcher', function () use ($di) {

            $eventsManager = $di->getShared('eventsManager');
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Application\Modules\\' . self::MODULE . '\Controllers');
            $dispatcher->setDefaultAction('index');
            return $dispatcher;
        });

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
     * @param \Phalcon\DI\FactoryDefault $di
     * @throws \Application\Modules\Rest\Exceptions\InternalServerErrorException
     */
    public function catchShutdown($di) {

        $di->getShared('dispatcher');
        if((is_null($error = error_get_last()) === false)) {
            try {

                $di->get('LogMapper')
                    ->save($error['message'].' File: '.$error['file'].' Line:'.$error['line'], 1);

                throw new InternalServerErrorException();
            }
            catch(InternalServerErrorException $e) {

                //$exception = new RestExceptionHandler($di);
                //$exception->handle($e)->send();

                $di->get('response')->setContentType('application/json', 'utf-8')
                    ->setStatusCode($e->getCode(), $e->getMessage())
                    ->setJsonContent(['error' => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ]])->send();
            }
        }
    }
}