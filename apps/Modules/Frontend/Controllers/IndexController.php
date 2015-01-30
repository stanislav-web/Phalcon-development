<?php
namespace Modules\Frontend\Controllers;
use Models\Pages;
use Phalcon\Mvc\View;

/**
 * Class IndexController
 *
 * @package    Frontend
 * @subpackage    Modules\Frontend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Controllers/IndexController.php
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
     * @uses Modules\Frontend\Controllers\ControllerBase::setReply <- array
     * @uses Modules\Frontend\Controllers\ControllerBase::getReply -> json
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
     * @uses Modules\Frontend\Controllers\ControllerBase::setReply <- array
     * @uses Modules\Frontend\Controllers\ControllerBase::getReply -> json
     * @uses Models\Pages
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

