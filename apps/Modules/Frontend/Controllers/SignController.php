<?php
namespace Modules\Frontend\Controllers;
use Phalcon\Mvc\View;
use Models\Users;

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
                    // If CSRF request was broken

                    if ($this->config->logger->enable)
                        $this->logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. CSRF attack');

                    $this->message('Invalid access token! Reload please');
                }
            }
            else
            {
                // if the request is different from POST

                if ($this->config->logger->enable)
                    $this->logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. Wrong auth method');

                $this->message('Wrong way! The data could not be loaded.');
            }

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            $this->response->setJsonContent($this->responseMsg);
            $this->response->setStatusCode(200, "OK");

            $this->response->setContentType('application/json', 'UTF-8');

            return $this->response->send();
        }
        else {

            // render the view
            $this->view->pick('error/uncaughtException');

        }
    }

    /**
     * Logout action to destroy user auth data
     *
     * @access public
     * @return null
     */
    public function logoutAction() {

        // destroy auth data
        $this->clearUserData();
        if($this->request->isAjax() === false) {
            $this->response->redirect('/');
        }
        else {

            // As Json string
            $this->responseMsg = [
                'success'   =>  true
            ];

            $this->response->setJsonContent($this->responseMsg);
            $this->response->setStatusCode(200, "OK");

            $this->response->setContentType('application/json', 'UTF-8');

            return $this->response->send();
        }
    }

    /**
     * Authorization to customer area
     */
    protected function login() {

        // destroy previous session user data

        // get post data
        $login = $this->request->getPost('login', 'trim');
        $password = $this->request->getPost('password', 'trim');

        $user = (new Users())->findFirst([
            "login = ?0",
            "bind" => [$login]
        ]);

        if(empty($user) === false) {

            // user founded, check password
            if($this->security->checkHash($password, $user->getPassword()))
            {
                $data = md5($user->getPassword() . $user->getSalt().$this->request->getUserAgent());

                // setup user cookies and send to client for update

                $this->cookies->set('token', $data, time() + ($this->config->rememberKeep), '/', $this->engine->getHost(), false, false);

                // set authentication user data for logged user

                $this->session->set('user', $user);

                // update auth params
                $user->setDateLastvisit(date('Y-m-d H:i:s'))
                    ->setIp($this->request->getClientAddress())
                    ->setUa($this->request->getUserAgent())
                    ->save();

                if ($this->config->logger->enable) {
                    $this->logger->log('Authenticate success from ' . $this->request->getClientAddress());
                }

                // success

                $this->responseMsg = [
                    'user' =>   $user->toArray(),
                    'token' =>  $data,
                    'success'   =>  true
                ];
            }
            else
            {

                if($this->config->logger->enable) {
                    $this->logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. Wrong authenticate data');
                }

                // wrong authenticate data (password or login)
                $this->message('Wrong authenticate data');
            }
        }
        else
        {
            if($this->config->logger->enable)
                $this->logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. The user ' . $login . ' not found');

            // user does not exist in database
            $this->message('The user not found');
        }
    }

    /**
     * Setup response message
     *
     * @param string $message
     * @return null
     */
    protected function message($message) {

        $this->responseMsg['message']    =   $message;
        $this->flashSession->error($message);
    }

}

