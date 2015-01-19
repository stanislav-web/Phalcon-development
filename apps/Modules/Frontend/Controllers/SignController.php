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
     * Ping response as Json
     * @var array
     */
    private $response = [];

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
        $response = [];

        if($this->request->isAjax() === true) {

            if($this->request->isPost() === true) {

                if ($this->security->checkToken()) {

                    // The token is ok, check sign type
                    $type   =   $this->request->getPost('type');
                    if($type === 'signin') {

                        // login
                        $this->login();
                    }
                    else {
                        // register
                        $this->register();
                    }

                }
                else
                {
                    // CSRF protection

                    if ($this->_config->logger->enable)
                        $this->_logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. CSRF attack');

                    $message    =   'Invalid access token! Reload please';
                    $response['message']    =   $message;
                    $this->flashSession->error($message);
                }
            }
            else
            {
                if ($this->_config->logger->enable)
                    $this->_logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. Wrong auth method');

                $message    =   'Wrong way! The data could not be loaded.';
                $response['message']    =   $message;
                $this->flashSession->error($message);
            }

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            $this->response->setJsonContent($this->response);
            $this->response->setStatusCode(200, "OK");

            $this->response->setContentType('application/json', 'UTF-8');

            return $this->response->send();
        }
        else {

            // render the view
            $this->view->pick('error/uncaughtException');

        }
    }

    protected function login() {


        $login = $this->request->getPost('login', 'trim');
        $password = $this->request->getPost('password', 'trim');

$user = (new Users())->findFirst([
    "login = ?0",
    "bind" => [$login]
]);

if (empty($user) === false) {

    if ($this->security->checkHash($password, $user->getPassword()))
    {
        // Check if the "remember me" was selected
        if (isset($remember)) {
            $this->cookies->set('remember', $user->getId(), time() + $this->_config->rememberKeep);
            $this->cookies->set('rememberToken',
                md5($user->getPassword() . $user->getSalt()),
                time() + $this->_config->rememberKeep);
        }

        // set authentication for logged user
        $this->session->set('auth', $user);

        // update auth params
        $user->setDateLastvisit(date('Y-m-d H:i:s'))
            ->setIp($this->request->getClientAddress())
            ->setUa($this->request->getUserAgent())
            ->save();

        $referrer = parse_url($this->request->getHTTPReferer(), PHP_URL_PATH);

        if ($this->_config->logger->enable) {
            $this->_logger->log('Authenticate success from ' . $this->request->getClientAddress());
        }

        // full http redirect to the referrer page
        if ($referrer != $this->request->getURI())
            return $this->response->redirect($referrer);
        else
            return $this->response->redirect('dashboard');
    }
    else
    {
        // Wrong authenticate data (password or login)
        $this->flashSession->error("Wrong authenticate data");

        if ($this->_config->logger->enable) {
            $this->_logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. Wrong authenticate data');
        }

        $this->response->redirect('dashboard/auth');
        $this->view->disable();
    }
} else {
    // user does not exist in database
    $this->flashSession->error("The user not found");


    if ($this->_config->logger->enable)
        $this->_logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. The user ' . $login . ' not found');

    $this->response->redirect('dashboard/auth');
    $this->view->disable();
} 

    }


}

