<?php
namespace Modules\Frontend\Controllers;
use Models\Users;
use Phalcon\Mvc\View;

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
     * Access state
     * @var bool $access
     */
    protected $access = false;

    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();

        // assign transalte service
        $this->translate->assign('sign');

        if($this->request->isAjax() === true) {

            if ($this->request->isPost() === true) {

                // enable access to data via AJAX POST in this Controller
                $this->access = true;
            }
            else
            {
                // if the request is different from POST

                if ($this->config->logger->enable)
                    $this->logger->error('Could not resolve request ' . $this->request->getClientAddress() . '. Wrong auth method');

                $this->setReply(['message' => $this->translate->translate('INVALID_REQUEST')]);
            }
        }
        else {

            // render the view
            $this->view->pick('error/uncaughtException');

        }
    }

    /**
     * loginAction() Check auth action
     * @access public
     * @return null
     */
    public function loginAction() {

        if($this->access === true) {

            if($this->security->checkToken()) {

                $login = $this->request->getPost('login', 'trim');
                $password = $this->request->getPost('password', 'trim');

                $user = (new Users())->findFirst([
                    "login = ?0",
                    "bind" => [$login],
                ]);

                if(empty($user) === false) {

                    if($this->security->checkHash($password, $user->getPassword())) {

                        // user founded, password checked. Set auth token
                        $this->token = md5($user->getId() . $this->security->getSessionToken() . $this->request->getUserAgent());

                        // setup user cookies and send to client for update
                        $this->cookies->set('token',    $this->token, time() + ($this->config->rememberKeep), '/', $this->engine->getHost(), false, false);
                        $this->session->set('token',    $this->token);
                        $this->session->set('user',     $user->toArray());

                        // update auth params
                        $user->setDateLastvisit(date('Y-m-d H:i:s'))
                            ->setSalt($this->security->getSessionToken())
                            ->setToken($this->token)
                            ->setIp($this->request->getClientAddress())
                            ->setUa($this->request->getUserAgent())
                            ->save();

                        if ($this->config->logger->enable) {
                            $this->logger->log('Authenticate success from ' . $this->request->getClientAddress());
                        }

                        $this->isAuthenticated = true;

                        // send reply to client
                        $this->setReply([
                            'user'  => [
                                'id'        =>  $user->getId(),
                                'login'     =>  $user->getLogin(),
                                'name'      =>  $user->getName(),
                                'surname'   =>  $user->getSurname(),
                                'state'     =>  $user->getState(),
                                'rating'    =>  $user->getRating(),
                                'surname'   =>  $user->getSurname(),
                                'date_registration' =>  $user->getDateRegistration(),
                                'date_lastvisit'    =>  $user->getDateLastvisit()
                            ],
                            'success'   => true,
                        ]);
                    }
                    else
                    {
                        // wrong authenticate data (password or login)
                        if($this->config->logger->enable) {
                            $this->logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. Wrong authenticate data');
                        }

                        $this->setReply(['message'   => $this->translate->translate('WRONG_DATA')]);
                    }
                }
                else
                {

                    if($this->config->logger->enable)
                        $this->logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. The user ' . $login . ' not found');

                    // user does not exist in database
                    $this->setReply(['message' => $this->translate->translate('NOT_FOUND')]);
                }
            }
            else
            {
                // If CSRF request was broken

                if ($this->config->logger->enable)
                    $this->logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. CSRF attack');

                $this->setReply(['message' => $this->translate->translate('INVALID_TOKEN')]);
            }
        }

        return $this->getReply();
    }

    /**
     * registerAction() user Registration action action
     * @access public
     * @return null
     */
    public function registerAction() {

        if($this->access === true) {

            if($this->security->checkToken()) {

                exit('OK');
            }
            else
            {
                // If CSRF request was broken

                if ($this->config->logger->enable)
                    $this->logger->error('Authenticate failed from ' . $this->request->getClientAddress() . '. CSRF attack');

                $this->setReply(['message' => $this->translate->translate('INVALID_TOKEN')]);
            }
        }

        return $this->getReply();
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
            $this->reply    =   [];
            $this->setReply(['success' => true]);
        }

        return $this->getReply();
    }


    /**
     * User authentication verify
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function verifyAction() {

        if($this->isAuthenticated === true) {
            $this->setReply(['success' => true]);
        }
        else {
            $this->setReply([false]);
        }

        return $this->getReply();
    }

    /**
     * Clear all auth user data
     *
     * @access protected
     * @return null
     */
    protected function clearUserData() {

        $this->user = null;

        // destroy session data
        if($this->session->has('user')) {
            $this->session->remove('user');
        }

        if($this->session->has('token')) {
            $this->session->remove('token');
        }

        // destroy cookies
        if($this->cookies->has('token')) {
            $this->cookies->get('token')->delete();
        }

        $this->response->resetHeaders();
    }
}

