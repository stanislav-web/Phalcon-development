<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\UserRoles;
use Phalcon\Mvc\Controller;
use Application\Services\AuthService;
/**
 * Class AuthController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP > = 5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/AuthController.php
 */
class AuthController extends Controller
{
    /**
     * @var \Application\Services\AuthService
     */
    private $auth;

    /**
     * initialize() Initial all global objects
     *
     * @access public
     * @return null
     */
    public function initialize()
    {
        // define user auth service
        $this->auth = $this->di->get("AuthService");

        // set default page title
        $this->tag->setTitle('Authenticate');
    }

    /**
     * Login action
     */
    public function indexAction() {

        if($this->request->isPost() === true) {

            // verify user credentials
            $isAuthenticate = $this->auth->authenticate($this->request->getPost());

            if ($isAuthenticate === true
                && $this->auth->hasRole(UserRoles::ADMIN) === true) {

                // send reply to client
                $referrer = parse_url($this->request->getHTTPReferer(), PHP_URL_PATH);

                // full http redirect to the referrer page
                if ($referrer != $this->request->getURI()) {
                    return $this->response->redirect($referrer);
                }
                else {
                    return $this->response->redirect('dashboard');
                }
            } else {

                // wrong authenticate data
                $this->flashSession->error($this->auth->getError());
                $this->response->redirect('dashboard/auth');
                $this->view->disable();
            }
        }
        else {
            // logged out before show form
            $this->auth->logout();
            $this->view->setMainView('non-auth-layout');
        }
    }

    /**
     * Logout action
     */
    public function logoutAction()
    {

        $isLoggedOut = ($this->auth->logout() === true) ? true : false;

        if($isLoggedOut === true) {

            // redirect auth form
            return $this->dispatcher->forward([
                'controller' => 'auth',
                'action' => 'index',
            ]);
        }
    }
}

