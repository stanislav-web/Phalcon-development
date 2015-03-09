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
            $this->response->setStatusCode(401, 'Unauthorized')->send();
        }
    }

    /**
     * User authentication verify
     */
    public function verifyAction()
    {
        // check user authenticate
        $AuthService = $this->getDI()->get("AuthService");

        if ($AuthService->isAuth() === true) {

            $this->setReply([
                'success' => true,
                $AuthService->getAccessToken()
            ]);
        }
        else {
            $this->response->setStatusCode(401, 'Unauthorized')->send();
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

            $this->setReply([
                'user' => $this->auth->getUser(),
                'success' => true,
            ]);
        } else {

            // Failed registration

            $this->setReply(['message' => $this->auth->getError()]);
            $this->response->setStatusCode(401, 'Unauthorized')->send();
        }
    }

    /**
     * Remind access password action
     */
    public function restoreAction()
    {
        // required params that to be saved by this user

        $isRestored = $this->auth->restore();

        if ($isRestored === true) {

            $this->setReply([
                'success' => true,
                'message' => $this->auth->getSuccess()
            ]);
        }
        else {
            $this->setReply(['message' => $this->auth->getError()]);
            $this->response->setStatusCode(401, 'Unauthorized')->send();
        }
    }

    /**
     * Logout action to destroy user auth data
     */
    public function logoutAction()
    {
        if($this->request->isDelete()) {

            $this->setReply(['success' => $this->auth->logout()]);
        }
        else {
            $this->response->setStatusCode(403, 'Access Forbidden')->send();
        }
    }
}