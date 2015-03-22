<?php
namespace Application\Modules\Rest\V1\Controllers;

/**
 * Class UsersController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/UsersController.php
 */
class UsersController extends ControllerBase {

    /**
     * User's list action
     */
    public function indexAction() {

        $this->rest->setMessage(
            $this->getDI()->get('UserMapper')->read()->toArray()
        );
    }

    /**
     * User auth action
     */
    public function authAction() {

        $params = $this->rest->getValidator()->getParams();

        $this->rest->setMessage(
            $this->rest->getDI()->get('RestSecurityService')->authenticate(
                $params['login'], $params['password']
            )
        );
    }
}