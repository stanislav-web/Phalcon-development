<?php
namespace Application\Modules\Rest\V1\Controllers;

use \Phalcon\Mvc\Controller;
use \Phalcon\Http\Response\Exception as RestException;

/**
 * Class ControllerBase
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/ControllerBase.php
 */
class ControllerBase extends Controller
{
    /**
     * Rest service
     *
     * @var \Application\Modules\Rest\Services\JsonRestService $rest
     */
    protected $rest;

    /**
     * Event before routes execute
     */
    public function beforeExecuteRoute()
    {

        try {

            // define Rest service
            $this->rest = $this->getDI()->get("JsonRestService");
            $this->rest->validate()->setDebug(false)->useRestrictAccess();
        }
        catch(RestException $e) {

            $this->rest->setStatusMessage($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Send response collection put from controllers
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function afterExecuteRoute()
    {
        $this->rest->response();
    }
}
