<?php
namespace Application\Services;

use \Phalcon\Text as Randomize;
use \Phalcon\DI\InjectionAwareInterface;
use Application\Models\UserRoles;
use Application\Models\Users;
use Application\Models\UserAccess;


/**
 * Class AuthService. User authentication, reg, remind, logout, verify actions
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/AuthService.php
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
     * @var array $error
     */
    protected $error = '';

    /**
     * User auth success messages
     *
     * @var array $error
     */
    protected $success = '';

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
     * Get translate service
     *
     * @return \Translate\Translator
     */
    public function getTranslator() {
        return $this->getDI()->getShared('TranslateService')->assign('sign');
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
     * Get logger service
     *
     * @return \Application\Services\LogDbService
     */
    public function getLogger() {
        if($this->getDi()->has('LogDbService')) {

            return $this->getDi()->get('LogDbService');
        }
    }

    /**
     * Get mailer service
     *
     * @return \Application\Services\MailSMTPService
     */
    public function getMailer() {
        if($this->getDi()->has('MailService')) {

            return $this->getDi()->get('MailService');
        }
    }

    /**
     * Get security plugin
     *
     * @return \Phalcon\Security
     */
    public function getSecurity() {
        return $this->getDi()->getShared('security');
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
     * Get Response data service
     *
     * @return \Phalcon\Http\Response
     */
    public function getResponse() {
        return $this->getDi()->get('response');
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
     * Get dependency container
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Set auth error message
     *
     * @param string $message
     * @return false
     */
    public function setError($message) {
        $this->error = $this->getTranslator()->translate($message);

        $this->getLogger()->save($this->error. ' IP: '.$this->getRequest()->getClientAddress(), \Phalcon\Logger::WARNING);
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

    /**
     * Authenticate user from credentials
     *
     * @param array $credentials
     * @return boolean
     */
    public function authenticate(array $credentials)
    {
        $this->logout();

        if($this->getSecurity()->checkToken() === true) {

            // get user from database
            $user = $this->getUser(['login' => $credentials['login']]);

            if (empty($user) === false) {

                if($this->getSecurity()->checkHash($credentials['password'], $user['password'])) {

                    // user founded, password checked. Set auth token

                    $token = $this->cryptToken($user['id'],
                        $this->getSecurity()->getSessionToken(),
                        $this->getRequest()->getUserAgent()
                    );

                    session_regenerate_id(true);

                    // setup token to storage
                    $this->setAccessToken($user['id'], $token, (time() + $this->getConfig()->cache->lifetime));

                    // update auth params

                    $userUpdate = new Users();

                    $userUpdate->setIp($this->getRequest()->getClientAddress())
                        ->setUa($this->getRequest()->getUserAgent())
                        ->setSalt($this->getSecurity()->getSessionToken())
                        ->save();

                    // save data to session
                    $this->getDi()->getShared('session')->set('user', [
                        'id'        =>  $user['id'],
                        'name'      =>  $user['name'],
                        'surname'   =>  $user['surname'],
                        'role'      =>  $user['role'],
                        'state'     =>  $user['state'],
                        'salt'      =>  $userUpdate->getSalt(),
                        'rating'    =>  $user['rating'],
                    ]);

                    return true;
                }
                else {

                    $this->setError('INVALID_AUTH_DATA');
                }
            }
            else {
                $this->setError('USER_NOT_FOUND');
            }
        }
        else {
            // security token invalid
            $this->setError('INVALID_REQUEST_TOKEN');
        }
    }

    /**
     * Register new user from credentials
     *
     * @return boolean
     */
    public function register()
    {
        // required params that to be saved by this user

        $user = new Users();

        $register =
            $user->setLogin($this->getRequest()->getPost('login','trim', ''))
                ->setPassword($this->getSecurity()->hash($this->getRequest()->getPost('password', 'trim')))
                ->setName($this->getRequest()->getPost('name', 'trim', ''))
                ->setSalt($this->getSecurity()->getSessionToken())
                ->setRole(UserRoles::USER)
                ->setIp($this->getRequest()->getClientAddress())
                ->setUa($this->getRequest()->getUserAgent());

        if($register->save()) {

            // register successful

            $token = $this->cryptToken($user->getId(),
                $this->getSecurity()->getSessionToken(),
                $this->getRequest()->getUserAgent()
            );

            session_regenerate_id(true);

            // setup token to storage
            $this->setAccessToken($user->getId(), $token, (time() + $this->getConfig()->cache->lifetime));

            // save data to session
            $this->getDi()->getShared('session')->set('user', $user->toArray());

            return true;
        }
        else {

            // get an error
            foreach($user->getMessages() as $message) {

                $this->setError($message->getMessage());
            }

            return false;
        }
    }

    /**
     * Restore user data
     *
     * @param \Application\Models\Engines $engine
     * @return bool
     * @throws \Phalcon\Exception
     */
    public function restore(\Application\Models\Engines $engine)
    {
        // required params that to be saved by this user

        $login = $this->getRequest()->getPost('login', 'trim');

        $user = (new Users())->findFirst([
            "login = ?0",
            "bind" => [$login],
        ]);

        if (empty($user) === false) {

            // user founded restore access by login, generate password
            $password = Randomize::random(Randomize::RANDOM_ALNUM, self::RECOVERY_PASS_LENGTH);

            // update password in Db

            $updatePassword = $user->setPassword($this->getSecurity()->hash($password));

            if($updatePassword->update() === true) {

                if (filter_var($user->getLogin(), FILTER_VALIDATE_EMAIL) !== false) {

                    // restore by email

                    $status = $this->sendRecoveryMail($user, $password, $engine);

                    if ($status === 1) {
                        return $this->setSuccess('PASSWORD_RECOVERY_SUCCESS');

                    } else {
                        return $this->setError('PASSWORD_RECOVERY_FAILED');
                    }
                }
                else {

                    // restore by SMS

                    $status = $this->sendRecoverySMS($user, $password, $engine);

                    if(isset($status['success']) === true) {
                        return $this->setSuccess('PASSWORD_RECOVERY_SUCCESS');
                    }
                    else {
                        return $this->setError('PASSWORD_RECOVERY_FAILED');
                    }
                }
            }
            else {

                // get an error
                foreach($updatePassword->getMessages() as $message) {

                    $this->setError($message->getMessage());
                }
                return false;
            }
        }
        else {
            return $this->setError('USER_NOT_FOUND');
        }
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

        // get storage service
        $session = $this->getDi()->getShared('session');

        $userAccess = new UserAccess();

        $requestDb = $userAccess->setUserId($user_id)->setToken($token)->setExpireDate($expire_date);

        if($requestDb->save() === true) {

            $session->set(self::TOKEN_KEY, [
                'user_id'       =>  $user_id,
                'token'         =>  $token,
                'expire_date'   =>  $expire_date
            ]);

            return true;
        }

        return false;
    }

    /**
     * Get user access token
     *
     * @return array token info
     */
    public function getAccessToken() {

        // get token from session
        if($this->getDi()->get('session')->has(self::TOKEN_KEY) === true) {

            $token =   $this->getDi()->getShared('session')->get(self::TOKEN_KEY);
        }
        else {

            $token = base64_decode($this->getRequest()->getHeader('X_TOKEN'));

            $userAccess = new UserAccess();
            $token = $userAccess->findFirst([
                "token = ?0",
                "bind" => [$token],
            ]);

            $token = ($token !== false) ? $token->toArray() : [];
        }

        return $token;
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

            $requestDb = (new Users())->findFirst([
                "".key($credentials)." = ?0",
                "bind" => [$credentials[key($credentials)]],
            ]);

            $user = ($requestDb !== false) ? $requestDb->toArray() : [];
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

        $session = $this->getDi()->getShared('session');

        if($session->has('user') === true) {

            return ((int)$session->get('user')['role'] === (int)$role) ? true : false;
        }
        else {
            return false;
        }
    }

    /**
     * is User authorized
     *
     * @return bool
     */
    public function isAuth() {

        // access ok
        $session = $this->getDi()->getShared('session');

        if($session->has('user') === true) {

            $access = $this->getAccessToken();

            if($access['token'] === $this->cryptToken($session->get('user')['id'], $session->get('user')['salt'],
                    $this->getRequest()->getUserAgent())) {

                if($access['expire_date'] > time()) {

                    return true;
                }
                else {

                    // drop access token. Auth has expired
                    return false;
                }
            }
            else {

                $this->setError('INVALID_ACCESS_TOKEN');

                return false;
            }
        }
        else {
            return false;
        }
    }

    /**
     * Crypt auth token
     *
     * @param int $id User Id
     * @param string $security security temp token
     * @param string $ua User Agent
     *
     * @return string
     */
    public function cryptToken($id, $security, $ua) {

        return md5($id . $security . $ua);
    }

    /**
     * Logout. Destroy all user data
     *
     * @return boolean
     */
    public function logout() {

        $session = $this->getDi()->getShared('session');
        $this->getResponse()->resetHeaders();

        // destroy user data
        if($session->has('user')) {

            if($session->has(self::TOKEN_KEY)) {

                $this->setAccessToken($session->get('user')['id'], $session->get('token')['token'], (time() - $this->getConfig()->cache->lifetime));

                $session->remove(self::TOKEN_KEY);
            }

            $session->remove('user');
        }

        session_regenerate_id(true);

        if($this->isAuth() === false) {
            return true;
        }
        else {
            return false;
        }
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
}