<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\Users;
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
     * Config service
     *
     * @var \Phalcon\Config $config
     */
    private $config;

    /**
     * Logger service
     *
     * @var  \Phalcon\Logger $logger
     */
    private $logger;

    /**
     * Auth user service
     *
     * @uses \Services\AuthService
     * @var \Phalcon\Di
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
        // load configures
        $this->config = $this->di->get('config');

        if ($this->di->has('LogDbService')) {
            $this->logger = $this->di->get('LogDbService');
        }
        // load user data
        $this->auth = $this->di->get("AuthService", [$this->config, $this->request]);

        // set default page title
        $this->tag->setTitle('Authenticate');
    }

    /**
     * LogIn action
     */
    public function indexAction()
    {
        // logged out before show form
        $this->auth->logout();

        if($this->request->isPost() === true) {

            if ($this->security->checkToken() === true) {

                // The token is ok, verify user credentials

                $this->auth->login(
                    $this->request->getPost('login'),
                    $this->request->getPost('password'),
                    $this->security);

                if ($this->auth->isAuth() === true
                    && $this->auth->hasRole(UserRoles::ADMIN)
                ) {

                    // authenticate success
                    $this->logger->save('Authenticate to CP success from ' . $this->request->getClientAddress(), 5);

                    $referrer = parse_url($this->request->getHTTPReferer(), PHP_URL_PATH);

                    // full http redirect to the referrer page
                    if ($referrer != $this->request->getURI())
                        return $this->response->redirect($referrer);
                    else
                        return $this->response->redirect('dashboard');
                } else {

                    // Wrong authenticate data (password or login)
                    $this->flashSession->error(AuthService::INVALID_AUTH);
                    $this->logger->save('Authenticate to CP failed from ' . $this->request->getClientAddress() . '. Wrong authenticate data', 4);

                    $this->response->redirect('dashboard/auth');
                    $this->view->disable();
                }
            }
            else {
                // CSRF protection. Security token invalid
                $this->logger->save('Invalid token has been catches by ' . $this->request->getClientAddress(), 4);
                $this->flashSession->error(AuthService::INVALID_ACCESS_TOKEN);

                $this->logger->save('Authenticate to CP failed from ' . $this->request->getClientAddress() . '. CSRF attack', 4);
                $this->response->redirect('dashboard/auth');
                $this->view->disable();
            }
        }

        $this->view->setMainView('non-auth-layout');
    }

    /**
     * LogOut action
     */
    public function logoutAction()
    {
        $loggedOut = ($this->auth->logout() === true) ? true : false;

        if($loggedOut === true) {

            // redirect auth form
            return $this->dispatcher->forward([
                'controller' => 'auth',
                'action' => 'index',
            ]);
        }
    }
}

