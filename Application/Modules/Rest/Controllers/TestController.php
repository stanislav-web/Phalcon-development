<?php
namespace Application\Modules\Rest\Controllers;

/**
 * Class TestController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/TestController.php
 */
class TestController extends ControllerBase {

    /**
     * Pages action
     */
    public function getAction() {

        error_reporting(0);
        $this->rest->getUndefinedMethod();
    }
}