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

    protected $private  =   false;

    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();

        if($this->user !== null) {

            $this->private = true;
        }
        else {
            $this->response->redirect('/');
        }
    }

    /**
     * indexAction() Check auth action
     * @access public
     * @return null
     */
    public function indexAction()
    {
        $this->tag->prependTitle(ucfirst($this->user->getName()).' - ');

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            $this->response->setJsonContent([
                'title'     =>  ucfirst($this->user->getName()).' - '.$this->engine->getName(),
                'user'      =>  $this->user->toArray()
            ]);

            $this->response->setStatusCode(200, "OK");
            $this->response->setContentType('application/json', 'UTF-8');

            return $this->response->send();
        }

        //var_dump($this->user); exit;
    }
}

