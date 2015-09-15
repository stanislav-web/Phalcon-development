<?php
namespace Application\Modules\Rest\Controllers;

/**
 * Class ReceiverController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/ReceiverController.php
 */
class ReceiverController extends ControllerBase {

    /**
     * @var \Octopussy\Services\AppService
     */
    public $octopussy;

    public function getAction() {
        echo 'GET Detected';
    }

    /**
     * Test upload
     */
    public function postAction() {

        $this->octopussy = $this->getDI()->get('Octopussy');
        $this->octopussy->run();

        exit;
    }
}