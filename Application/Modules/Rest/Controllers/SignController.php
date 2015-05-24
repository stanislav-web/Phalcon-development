<?php
namespace Application\Modules\Rest\Controllers;

/**
 * Class SignController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/SignController.php
 */
class SignController extends ControllerBase {

    /**
     * GET Authentication
     */
    public function getAction() {

        $params = $this->rest->getParams();
        $this->response =
            $this->getDI()->get('RestSecurityService')->authenticate($params,
                $this->rest->getResolver()->getRules()->skip);
    }

    /**
     * POST Registration
     */
    public function postAction() {

        $params = $this->rest->getParams();

        $this->response =
            $this->getDI()->get('RestSecurityService')->register($params,
                $this->rest->getResolver()->getRules()->skip);
    }

    /**
     * PUT Restore access
     */
    public function putAction() {

        $params = $this->rest->getParams();

        $this->response =
            $this->getDI()->get('RestSecurityService')->restore($params,
                $this->rest->getResolver()->getRules()->skip);
    }

    /**
     * DELETE Logout
     */
    public function deleteAction() {

        $params = $this->rest->getParams();

        $this->response =
            $this->getDI()->get('RestSecurityService')->logout($params);
    }
}