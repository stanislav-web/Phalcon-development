<?php
namespace Modules\Frontend\Controllers;
use Phalcon\Mvc\View;
use Modules\Frontend\Forms;

/**
 * Class SignController
 * @package    Frontend
 * @subpackage    Modules\Frontend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Controllers/SignController.php
 */
class SignController extends ControllerBase
{

    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * indexAction() Check auth action
     * @access public
     * @return null
     */
    public function indexAction()
    {
        exit('sdsds');
    }

}

