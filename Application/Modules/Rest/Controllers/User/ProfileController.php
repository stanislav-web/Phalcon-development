<?php
namespace Application\Modules\Rest\Controllers\User;

use Application\Modules\Rest\Controllers\ControllerBase;

/**
 * Class ProfileController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers\User
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/User/ProfileController.php
 */
class ProfileController extends ControllerBase {

    /**
     * Get user profile
     */
    public function getAction() {

        return $this->setReply(['Hello, User! Rest work fine :-D']);
    }
}