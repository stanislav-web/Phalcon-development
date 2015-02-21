<?php
namespace Application\Modules\Frontend\Controllers;

use Phalcon\Mvc\View;

/**
 * Class TransactionController
 *
 * @package    Application\Modules\Frontend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Frontend/Controllers/TransactionController.php
 */
class TransactionController extends ControllerBase
{

    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
    }

    /**
     * Home action.
     *
     * @uses Application\Modules\Frontend\Controllers\ControllerBase::setReply <- array
     * @uses Application\Modules\Frontend\Controllers\ControllerBase::getReply -> json
     *
     * @return void
     */
    public function indexAction()
    {
        // setup content
        $this->setReply([
            'title'     => $this->engine->getName(),
            'content'   => 'some data',
        ]);
    }
}

