<?php
namespace Application\Services\Security;

use \Phalcon\Text as Randomize;
use \Phalcon\Logger;
use \Phalcon\DI\InjectionAwareInterface;

/**
 * Class AuthService. User authentication, reg, remind, logout, verify actions
 * @package Application\Services
 * @subpackage Views
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Security/AuthService.php
 */
class AuthService implements InjectionAwareInterface {

    /**
     * @const Access token key
     */
    const TOKEN_KEY = 'token';

    /**
     * @const SMS Provider
     */
    const SMS_PROVIDER = 'Nexmo';

    /**
     * @const Max pass length while recovery
     */
    const RECOVERY_PASS_LENGTH = 10;

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Dependency injection container
     *
     * @var \Translate\Translator $translate;
     */
    protected $translate;

    /**
     * User auth error messages
     *
     * @var mixed $error
     */
    protected $error;

    /**
     * User auth success messages
     *
     * @var mixed $success
     */
    protected $success;

    /**
     * Logout. Destroy all user data
     *
     * @return boolean
     */
    public function logout() {

        $session = $this->getDi()->getShared('session');

        // destroy user data
        if($session->has('user')) {

            $this->deleteAccessToken(['user_id' => $session->get('user')['id']]);
            $session->remove('user');
        }

        session_regenerate_id(true);
        return true;
    }

    /**
     * Set user access token
     *
     * @param int $user_id Auth user ID
     * @param string $token Generated token
     * @param int $expire_date Token date expiry
     * @return bool
     */
    public function setAccessToken($user_id, $token, $expire_date) {

        $token = $this->getUserMapper()->setAccessToken($user_id, $token, $expire_date);

        if($token !== false) {
            $this->getDi()->getShared('session')->set(self::TOKEN_KEY, [
                'user_id'       =>  $token->getUserId(),
                'token'         =>  $token->getToken(),
                'expire_date'   =>  $token->getExpireDate()
            ]);
            return true;
        }

        return false;
    }

    /**
     * Get user access token from server session
     *
     * @return array
     */
    public function getAccessTokenFromSession() {

        $session = $this->getDi()->getShared('session');
        return ($session->has(self::TOKEN_KEY) === true) ? $session->get(self::TOKEN_KEY) : [];
    }

    /**
     * Get user access token from header
     *
     * @return array
     */
    public function getAccessTokenFromHeader() {

        $token = $this->getRequest()->getHeader('X_'.strtoupper(self::TOKEN_KEY));
        if(empty($token) === false) {

            $userToken = $this->getUserMapper()->getAccessTokenByCredential(['token' => base64_decode($token)]);
            return ($userToken !== false) ? $userToken->toArray() : [];
        }
        return [];
    }

    /**
     * Get user access token from request
     *
     * @return array
     */
    public function getAccessTokenFromRequest() {

        $token = $this->getRequest()->get(self::TOKEN_KEY, null, '');

        if(empty($token) === true) {
            $token = $this->getDi()->get('dispatcher')->getParam(self::TOKEN_KEY);
        }

        if(empty($token) === false) {

            $userToken = $this->getUserMapper()->getAccessTokenByCredential(['token' => $token]);
            return ($userToken !== false) ? $userToken->toArray() : [];
        }
        return [];
    }

    /**
     * Get user access token by user
     *
     * @return array
     */
    public function getAccessTokenByUserId($user_id) {

        $userToken = $this->getUserMapper()->getAccessTokenByCredential(['user_id' => $user_id]);
        return ($userToken !== false) ? $userToken->toArray() : [];
    }

    /**
     * Get actual user access token
     *
     * @param int $user_id
     * @return array token info
     */
    public function getAccessToken($user_id = null) {

        if(is_null($user_id) === true) {

            $token = $this->getAccessTokenFromSession();
            if(empty($token) === true) {
                $token = $this->getAccessTokenFromRequest();
                if(empty($token) === true) {
                    $token = $this->getAccessTokenFromHeader();
                }
            }
        }
        else {

            $token = $this->getAccessTokenFromSession();
            if(empty($token) === true) {
                $token = $this->getAccessTokenByUserId($user_id);
            }
        }

        return $token;
    }

    /**
     * Delete user access token
     *
     * @param array $credential key => value
     * @return \Phalcon\Mvc\Model
     */
    public function deleteAccessToken(array $credential) {

        $session = $this->getDi()->getShared('session');

        if($session->has(self::TOKEN_KEY)) {
            $session->remove(self::TOKEN_KEY);
        }

        $isDelete = $this->getUserMapper()->deleteAccessTokenByCredential($credential);

        return $isDelete;
    }

    /**
     * Crypt auth token
     *
     * @param int $id user id
     * @param string $salt salt
     *
     * @return string
     */
    public function cryptAccessToken($id, $salt) {

        return md5($id . $salt);
    }

    /**
     * Generate random string
     *
     * @return string
     */
    public function randomString() {
        return Randomize::random(Randomize::RANDOM_ALNUM, self::RECOVERY_PASS_LENGTH);
    }

    /**
     * Get user data
     *
     * @param array $credentials
     * @return array
     */
    public function getUser(array $credentials = []) {

        $session = $this->getDi()->getShared('session');

        if($session->has('user') === true) {

            $user =   $session->get('user');
        }
        else {

            $fetchUser = $this->getUserMapper()->getOne($credentials);
            $user = ($fetchUser !== false) ? $fetchUser->toArray() : [];
        }
        return $user;
    }

    /**
     * Check user role
     *
     * @param int $role
     * @return bool
     */
    public function hasRole($role) {

        return ((int)$this->getUser()['role'] === (int)$role) ? true : false;
    }

    /**
     * is User authorized
     *
     * @return bool
     */
    public function isAuth() {

        $user   = $this->getUser();
        $access = $this->getAccessToken();

        if((isset($access['token']) === true &&  isset($user['id']) === true)
            && $access['token'] === $this->cryptAccessToken($user['id'], $user['salt'])) {

            if(strtotime($access['expire_date']) > time()) {

                return true;
            }
            else {

                // remove token from database
                $this->deleteAccessToken(['user_id' => $user['id']]);

                return false;
            }
        }

        return $this->setError('INVALID_ACCESS_TOKEN');
    }

    /**
     * Send recovery email
     *
     * @param \Application\Models\Users $user
     * @param string $password
     * @param \Application\Models\Engines $engine
     * @return int
     * @throws \Phalcon\Exception
     */
    private function sendRecoveryMail(\Application\Models\Users $user, $password, \Application\Models\Engines $engine) {

        $mailer = $this->getMailer();

        $this->getDi()->getShared('ViewService',[$engine])->define();

        $status = $mailer->createMessageFromView('emails/restore_password_email', [
            'login'     => $user->getLogin(),
            'name'      => $user->getName(),
            'password'  => $password,
            'site'      => $engine->getHost(),
            'sitename'  => $engine->getName()
        ])->priority(1)->to($user->getLogin(), $user->getName())
            ->subject(sprintf($this->getTranslator()->translate('PASSWORD_RECOVERY_SUBJECT'), $engine->getHost()))->send();

        return $status;
    }

    /**
     * Send recovery SMS
     *
     * @param \Application\Models\Users $user
     * @param string $password
     * @param \Application\Models\Engines $engine
     * @return mixed
     * @throws \Phalcon\Exception
     */
    private function sendRecoverySMS(\Application\Models\Users $user, $password, \Application\Models\Engines $engine) {

        $template =  "Hello, ".$user->getName()."! Your temporary generated password is: ".$password.". Best regards, ".ucfirst($engine->getName());
        $status = $this->getSmsService()->call(self::SMS_PROVIDER)->setRecipient($user->getLogin())->send($template);

        return $status;
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Get config plugin
     *
     * @return \Phalcon\Config
     */
    public function getConfig() {
        return $this->getDi()->get('config');
    }

    /**
     * Get user mapper
     *
     * @return \Application\Services\Mappers\UserMapper
     */
    public function getUserMapper() {
        return $this->getDi()->get('UserMapper');
    }

    /**
     * Get translate service
     *
     * @return \Application\Services\Advanced\TranslateService
     */
    public function getTranslator() {
        return $this->getDI()->getShared('TranslateService')->assign('sign');
    }

    /**
     * Get mailer service
     *
     * @return \Application\Services\Mail\MailSMTPService
     */
    public function getMailer() {
        return $this->getDi()->get('MailService');
    }

    /**
     * Get security plugin
     *
     * @return \Phalcon\Security
     */
    public function getSecurity() {
        return $this->getDi()->get('security');
    }

    /**
     * Get Request data service
     *
     * @return \Phalcon\Http\Request
     */
    public function getRequest() {
        return $this->getDi()->get('request');
    }

    /**
     * Get SMS service
     *
     * @return \SMSFactory\Sender
     */
    public function getSmsService() {
        return $this->getDi()->get('SMS');
    }

    /**
     * Set auth error message
     *
     * @param string $message
     * @return false
     */
    public function setError($message) {

        $this->error = (is_array($message) === false) ? $this->getTranslator()->translate($message)
            : implode('. '.PHP_EOL, array_map(function($message) {
                return $this->getTranslator()->translate($message->getMessage());
        },$message));

        $this->getDi()->get('LogMapper')->save($this->error. ' IP: '.$this->getRequest()->getClientAddress(), Logger::WARNING);
        return false;
    }

    /**
     * Get auth error messages
     *
     * @return array
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Set auth success message
     *
     * @param string $message
     * @return true
     */
    public function setSuccess($message) {
        $this->success = $this->getTranslator()->translate($message);
        return true;
    }

    /**
     * Get auth success messages
     *
     * @return array
     */
    public function getSuccess() {
        return $this->success;
    }
}