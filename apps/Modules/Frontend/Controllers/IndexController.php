<?php
namespace Modules\Frontend\Controllers;
use Phalcon\Mvc\View;

/**
 * Class IndexController
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
     * Home action. Retrieved response as json
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
     * Contacts,About,Agreement,Help... action
     * Static pages
     */
    public function staticAction()
    {
        // get page to display - param
        $param = $this->dispatcher->getParam('page');
        // setup title
        $this->tag->prependTitle(ucfirst($param).' - ');

        // setup content
        $this->setReply([
            'title'     => ucfirst($param).' - '.$this->engine->getName(),
            'content'   => 'some data - '.$param,
        ]);

        // send response
        if($this->request->isAjax() === true) {
            return $this->getReply();
        }
    }
}

