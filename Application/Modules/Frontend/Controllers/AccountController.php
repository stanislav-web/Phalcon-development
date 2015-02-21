<?php
namespace Application\Modules\Frontend\Controllers;

use Phalcon\Mvc\View;

/**
 * Class AccountController
 *
 * @package    Application\Modules\Frontend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Frontend/Controllers/AccountController.php
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
        // add translate section
        $this->translate->assign('account');
    }

    /**
     * indexAction() Check auth action
     * @access public
     * @return null
     */
    public function indexAction()
    {

        if($this->auth->isAuth() === true) {

            $user = $this->auth->getUser();

            $this->tag->prependTitle(ucfirst($user['name']).' - ');

            // setup content
            $this->setReply([
                'title'     => $user['name'] .' - '.$this->engine->getName(),
                'user'      => $user,
            ]);
        }
        else {

            return $this->response->redirect('/');
        }
    }
}

