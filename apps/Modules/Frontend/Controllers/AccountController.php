<?php
namespace Modules\Frontend\Controllers;
use Phalcon\Mvc\View;

/**
 * Class AccountController
 * @package    Frontend
 * @subpackage    Modules\Frontend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Controllers/AccountController.php
 */
class AccountController extends ControllerBase
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
        if($this->isAuthenticated === false) {
            return $this->response->redirect('/');
        }

        $this->tag->prependTitle(ucfirst($this->user->getName()).' - ');

        // setup content
        $this->setReply([
            'title'     => $this->user->getName() .' - '.$this->engine->getName(),
            'user'      => $this->user->toArray(),
        ]);

        // send response
        if($this->request->isAjax() === true) {
            return $this->getReply();
        }

    }
}

