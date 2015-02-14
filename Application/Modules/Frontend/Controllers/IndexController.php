<?php
namespace Application\Modules\Frontend\Controllers;

use Application\Models\Pages;
use Phalcon\Mvc\View;

/**
 * Class IndexController
 *
 * @package    Application\Modules\Frontend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Frontend/Controllers/IndexController.php
 */
class IndexController extends ControllerBase
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

        // send response
        if($this->request->isAjax() === true) {
            return $this->getReply();
        }
    }

    /**
     * Static page action.
     *
     * @uses Application\Modules\Frontend\Controllers\ControllerBase::setReply <- array
     * @uses Application\Modules\Frontend\Controllers\ControllerBase::getReply -> json
     * @uses Application\Models\Pages
     *
     * @return void
     */
    public function staticAction()
    {
        // get page to display - param
        $param = $this->dispatcher->getParam('page');

        if($param !== null) {

            // get page from database
            $page = Pages::findFirst([
                "alias = ?0",
                "bind" => [$param]
            ]);

            if($page !== null) {

                // setup title
                $this->tag->prependTitle(ucfirst($page->getTitle()).' - ');

                // setup content
                $this->setReply([
                    'title'     =>  ucfirst($page->getTitle()).' - '.$this->engine->getName(),
                    'content'   =>  $page->getContent(),
                ]);
            }
        }

        // send response
        if($this->request->isAjax() === true) {
            return $this->getReply();
        }
    }
}

