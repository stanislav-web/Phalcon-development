<?php
namespace Application\Modules\Frontend\Controllers;

use Application\Models\Users;
use Phalcon\Mvc\View;
use Phalcon\Text as Randomize;
use SMSFactory\Run;

/**
 * Class SignController
 *
 * @package    Application\Modules\Frontend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Frontend/Controllers/SignController.php
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
     *
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();

        // assign translate service
        $this->translate->assign('sign');

        if($this->request->isAjax() === true) {

            // enable access to data via AJAX POST in this Controller
            $this->access = true;

        }
        else {

            // render the view
            $this->view->pick('error/uncaughtException');

        }
    }

    /**
     * loginAction() Check auth action
     *
     * @access public
     * @return null
     */
    public function loginAction() {

        if($this->access === true) {

            if ($this->security->checkToken()) {

                // verify user credentials
                $this->auth->login(
                    $this->request->getPost('login'),
                    $this->request->getPost('password'),
                    $this->security);

                if ($this->auth->isAuth() === true) {

                    // authenticate success

                    if ($this->config->logger->enable) {
                        $this->logger->notice('Authenticate success from ' . $this->request->getClientAddress());
                    }

                    // send reply to client
                    $this->setReply(['user' => $this->auth->getUser(),'success' => true]);

                } else {

                    // authenticate failed
                    foreach ($this->auth->getErrors() as $error) {
                        $this->setReply(['message' => $this->translate->translate($error)]);
                    }
                    if ($this->config->logger->enable) {
                        $this->logger->warning('Authenticate failed from ' . $this->request->getClientAddress());
                    }
                }
            }
            else {
                // security token invalid
                $this->setReply(['message' => $this->translate->translate('INVALID_TOKEN')]);
            }
        }
        return $this->getReply();
    }

    /**
     * registerAction() User registration action action
     *
     * @access public
     * @return null
     */
    public function registerAction() {

        if($this->access === true) {

            if($this->security->checkToken()) {

                // required params that to be saved by this user

                $user = new Users();

                $register =
                    $user->setLogin($this->request->getPost('login', 'trim'))
                        ->setPassword($this->security->hash($this->request->getPost('password', 'trim')))
                        ->setName($this->request->getPost('name', 'trim', ''))
                        ->setSalt($this->security->getSessionToken())
                        ->setIp($this->request->getClientAddress())
                        ->setUa($this->request->getUserAgent())
                        ->setToken(md5($this->request->getPost('login', 'trim') . $this->security->getSessionToken() . $this->request->getUserAgent()));

                if($register->save()) {

                    // user created

                    $this->token = md5($register->getLogin() . $this->security->getSessionToken() . $this->request->getUserAgent());

                    // setup user cookies and send to client for update
                    $this->cookies->set('token',    $this->token, time() + ($this->config->rememberKeep), '/', $this->engine->getHost(), false, false);
                    $this->session->set('token',    $this->token);
                    $this->session->set('user',     $register->toArray());

                    // update auth params

                    if ($this->config->logger->enable) {
                        $this->logger->notice('Registration success from ' . $this->request->getClientAddress().'. User: '.$register->getLogin());
                    }

                    $this->isAuthenticated = true;

                    // send reply to client
                    $this->setReply([
                        'user'  => [
                            'id'        =>  $register->getId(),
                            'login'     =>  $register->getLogin(),
                            'name'      =>  $register->getName(),
                            'surname'   =>  $register->getSurname(),
                            'state'     =>  $register->getState(),
                            'rating'    =>  $register->getRating(),
                            'date_registration' =>  $user->getDateRegistration(),
                            'date_lastvisit'    =>  $user->getDateLastvisit()
                        ],
                        'success'   => true,
                    ]);
                }
                else {

                    // get an error
                    foreach($user->getMessages() as $message) {

                        $this->setReply(['message' => $message->getMessage()]);
                    }
                }
            }
            else
            {
                // If CSRF request was broken

                if ($this->config->logger->enable)
                    $this->logger->warning('Registration failed from ' . $this->request->getClientAddress() . '. CSRF attack');

                $this->setReply(['message' => $this->translate->translate('INVALID_TOKEN')]);
            }
        }

        return $this->getReply();
    }

    /**
     * restoreAction() Remind access password action
     *
     * @access public
     * @return null
     */
    public function restoreAction() {

        if($this->access === true) {

            if($this->security->checkToken()) {

                // find user by login
                $login = $this->request->getPost('login', 'trim');

                $user = (new Users())->findFirst([
                    "login = ?0",
                    "bind" => [$login],
                ]);

                if(empty($user) === false) {

                    // user founded restore access by login, generate password
                    $password = Randomize::random(Randomize::RANDOM_ALNUM, 16);

                    if(filter_var($login, FILTER_VALIDATE_EMAIL) !== false) {

                        // send recovery mail

                        $mailer = $this->di->get('MailService');
                        $status = $mailer->createMessageFromView('emails/restore_password', [
                            'login'     => $user->getLogin(),
                            'name'      => $user->getName(),
                            'password'  => $password,
                            'site'      =>  $this->engine->getHost()
                        ])->to($user->getLogin(), $user->getName())
                        ->subject(sprintf($this->translate->translate('PASSWORD_RECOVERY_SUBJECT'), $this->engine->getHost()))->send();


                        if($status === 1) {

                            $this->setReply([
                                'success' => true,
                                'message' => $this->translate->translate('PASSWORD_RECOVERY_SUCCESS')
                            ]);

                        }
                        else {
                            $this->setReply([
                                'message' => $this->translate->translate('PASSWORD_RECOVERY_FAILED')
                            ]);
                        }
                    }
                    else
                    {
                        // phone number, use SMS service

                        //$sms = new Run();
                        //$sms->call('Provider');
                    }

                }
                else {

                    if($this->config->logger->enable)
                        $this->logger->warning('Restore failed from ' . $this->request->getClientAddress() . '. Attempt to restore: ' . $login);

                    // user does not exist in database
                    $this->setReply(['message' => $this->translate->translate('NOT_FOUND')]);

                }
            }
            else
            {
                // If CSRF request was broken

                if ($this->config->logger->enable)
                    $this->logger->warning('Remind access failed from ' . $this->request->getClientAddress() . '. CSRF attack');

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

        if($this->request->isAjax() === false) {
            $this->response->redirect('/');
        }
        else {

            $status = ($this->auth->logout() === true) ? true : false;
            $this->setReply(['success' => $status]);
        }

        return $this->getReply();
    }


    /**
     * User authentication verify
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function verifyAction() {

        // Check user authenticate
        $AuthService = $this->di->get("AuthService", [$this->config, $this->request]);
        if($AuthService->isAuth() === true) {
            $this->setReply(['success' => true]);
        }

        return $this->getReply();
    }
}