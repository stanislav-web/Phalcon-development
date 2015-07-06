<?php
namespace Application\Modules\Rest\Controllers;

use \Phalcon\Mvc\Controller;

/**
 * Class ControllerBase
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/ControllerBase.php
 */
class ControllerBase extends Controller
{
    /**
     * Rest service
     *
     * @var \Application\Modules\Rest\Services\RestService $rest
     */
    protected $rest;

    /**
     * Response data (override)
     *
     * @var array $response
     */
    protected $response = [];

    /**
     * Event before routes execute
     */
    public function beforeExecuteRoute()
    {
        $this->rest =  $this->getDI()->get("RestService");
        $this->rest->getResolver()->filter($this->request)->validate();
    }

    /**
     * Send response collection put from controllers
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function afterExecuteRoute()
    {
        $this->rest->getResolver()->resolve($this->response);
        $this->rest->response()->send();
    }

    /**
     * Garbage clean
     */
    public function afterDispatch() {
        unset($this->rest);
    }
}
