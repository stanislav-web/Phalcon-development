<?php
namespace Application\Modules\Frontend\Controllers;

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
     * Login action
     */
    public function loginAction()
    {
        // verify user credentials
        $isAuthenticate = $this->auth->authenticate($this->request->getPost());

        if ($isAuthenticate === true) {

            // send reply to client
            $this->setReply([
                'user' => $this->auth->getUser(),
                'success' => true,
            ]);

        } else {

            // authenticate failed
            $this->setReply(['message' => $this->auth->getError()]);
        }

    }

    /**
     * User authentication verify
     */
    public function verifyAction()
    {
        // check user authenticate
        $AuthService = $this->di->get("AuthService");

        if ($AuthService->isAuth() === true) {

            $this->setReply(array_merge(['success' => true], $AuthService->getAccessToken()));
        }
    }

    /**
     * User registration action
     */
    public function registerAction()
    {
        // required params that to be saved by this user

        $isRegistered = $this->auth->register();

        if ($isRegistered === true) {

            // Success registration
            $user = $this->auth->getUser();

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
        }
    }

    /**
     * Remind access password action
     */
    public function restoreAction()
    {
        // required params that to be saved by this user

        $isRestored = $this->auth->restore($this->engine);

        if ($isRestored === true) {

            $this->setReply([
                'success' => true,
                'message' => $this->auth->getSuccess()
            ]);
        }
        else {
            $this->setReply(['message' => $this->auth->getError()]);
        }
    }

    /**
     * Logout action to destroy user auth data
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