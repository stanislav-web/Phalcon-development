<?php
namespace Application\Modules\Rest\Controllers;

/**
 * Class SubscribeController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/SubscribeController.php
 */
class SubscribeController extends ControllerBase {

    /**
     * POST Subscribe action
     */
    public function postAction() {

        $params = $this->rest->getParams();
        $this->response =
            $this->getDI()->get('SubscribeMapper')->create($params);
    }
}