<?php
namespace Application\Modules\Frontend\Controllers;

use Application\Models\Users;
use Phalcon\Logger;
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
        // assign translate service
        $this->translate->assign('sign');

        if ($this->request->isAjax() === true) {

            // enable access to data via AJAX POST in this Controller
            $this->access = true;

        } else {

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
    public function loginAction()
    {

        if ($this->access === true) {

            if ($this->security->checkToken() === true) {

                // verify user credentials
                $login = $this->auth->authenticate($this->request->getPost());

                if ($login === true) {

                    // authenticate success
                    $this->logger->save('Authenticate success from ' . $this->request->getClientAddress(), 5);

                    // send reply to client
                    $this->setReply([
                        'user' => $this->auth->getUser(),
                        'success' => true,
                    ]);

                } else {

                    // authenticate failed
                    $this->setReply(['message' => $this->auth->getError()]);
                    $this->logger->save('Authenticate failed from ' . $this->request->getClientAddress(), 4);
                }
            } else {
                // security token invalid
                $this->setReply(['message' => $this->translate->translate('INVALID_REQUEST_TOKEN')]);

                $this->logger->save('Invalid token has been catches by ' . $this->request->getClientAddress(), 4);
            }
        }
    }

    /**
     * User authentication verify
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function verifyAction()
    {

        // Check user authenticate
        $AuthService = $this->di->get("AuthService");

        if ($AuthService->isAuth() === true) {

            $this->setReply(array_merge(['success' => true], $AuthService->getAccessToken()));
        }
    }

    /**
     * registerAction() User registration action action
     *
     * @access public
     * @return null
     */
    public function registerAction()
    {

        if ($this->access === true) {

            if ($this->security->checkToken()) {

                // required params that to be saved by this user

                $isRegistered = $this->auth->register();

                if ($isRegistered === true) {
                    // Success registration
                    $user = $this->auth->getUser();

                    $this->logger->save('Registration success from ' . $this->request->getClientAddress() . '. User: ' . $user['id'], 5);

                    $this->setReply([
                        'user' => [
                            'id' => $user['id'],
                            'login' => $user['login'],
                            'name' => $user['name'],
                            'surname' => $user['surname'],
                            'state' => $user['state'],
                            'rating' => $user['rating'],
                            'date_registration' => $user['date_registration'],
                            'date_lastvisit' => $user['date_lastvisit']
                        ],
                        'success' => true,
                    ]);
                } else {

                    // Failed registration

                    $this->setReply(['message' => $this->auth->getError()]);
                    $this->logger->save('Registration failed from ' . $this->request->getClientAddress(), 4);
                }
            } else {

                // If CSRF request was broken

                $this->setReply(['message' => $this->translate->translate('INVALID_REQUEST_TOKEN')]);
                $this->logger->save('Registration failed from ' . $this->request->getClientAddress() . '. CSRF attack', 4);
            }
        }
    }

    /**
     * restoreAction() Remind access password action
     *
     * @access public
     * @return null
     */
    public function restoreAction()
    {

        if ($this->access === true) {

            if ($this->security->checkToken()) {

                // find user by login
                $login = $this->request->getPost('login', 'trim');

                $user = (new Users())->findFirst([
                    "login = ?0",
                    "bind" => [$login],
                ]);

                if (empty($user) === false) {

                    // user founded restore access by login, generate password
                    $password = Randomize::random(Randomize::RANDOM_ALNUM, 16);

                    if (filter_var($login, FILTER_VALIDATE_EMAIL) !== false) {

                        // send recovery mail

                        $mailer = $this->di->get('MailService');
                        $status = $mailer->createMessageFromView('emails/restore_password', [
                            'login' => $user->getLogin(),
                            'name' => $user->getName(),
                            'password' => $password,
                            'site' => $this->engine->getHost()
                        ])->to($user->getLogin(), $user->getName())
                            ->subject(sprintf($this->translate->translate('PASSWORD_RECOVERY_SUBJECT'), $this->engine->getHost()))->send();


                        if ($status === 1) {

                            $this->setReply([
                                'success' => true,
                                'message' => $this->translate->translate('PASSWORD_RECOVERY_SUCCESS')
                            ]);

                        } else {
                            $this->setReply([
                                'message' => $this->translate->translate('PASSWORD_RECOVERY_FAILED')
                            ]);
                        }
                    } else {
                        // phone number, use SMS service

                        //$sms = new Run();
                        //$sms->call('Provider');
                    }

                } else {

                    // user does not exist in database
                    $this->setReply(['message' => $this->translate->translate('NOT_FOUND')]);

                    $this->logger->save('Restore failed from ' . $this->request->getClientAddress() . '. Attempt to restore: ' . $login, 4);

                }
            } else {
                // If CSRF request was broken

                $this->setReply(['message' => $this->translate->translate('INVALID_REQUEST_TOKEN')]);

                $this->logger->save('Remind access failed from ' . $this->request->getClientAddress() . '. CSRF attack', 4);
            }
        }

    }

    /**
     * Logout action to destroy user auth data
     *
     * @access public
     * @return null
     */
    public function logoutAction()
    {

        if ($this->request->isAjax() === false) {
            $this->response->redirect('/');
        } else {

            $loggedOut = ($this->auth->logout() === true) ? true : false;
            $this->setReply(['success' => $loggedOut]);
        }

    }
}