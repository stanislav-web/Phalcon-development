<?php
namespace Application\Modules\Rest\Controllers;

/**
 * Class UserController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/UserController.php
 */
class UserController extends ControllerBase {

    /**
     * User profile action
     */
    public function accessAction() {

        return $this->rest->setReply(
            $this->getDI()->get('AuthService')->getAccessToken()
        );
    }

}