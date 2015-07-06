<?php
namespace Application\Modules\Rest\Controllers;

/**
 * Class FilesController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/FilesController.php
 */
class FilesController extends ControllerBase {

    /**
     * POST Upload action
     */
    public function postAction() {

        $params = $this->rest->getParams();

        $this->response =
            $this->getDI()->get('FileMapper')->append($this->request->getUploadedFiles(), $params);
    }
}