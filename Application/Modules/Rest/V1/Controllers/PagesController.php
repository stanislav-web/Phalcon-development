<?php
namespace Application\Modules\Rest\V1\Controllers;

/**
 * Class PagesController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/PagesController.php
 */
class PagesController extends ControllerBase {

    /**
     * Pages action
     */
    public function indexAction() {
        $this->rest->setMessage(
            $this->getDI()->get('PageMapper')->read()->toArray()
        );
    }
}