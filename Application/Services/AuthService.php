<?php
namespace Application\Services;

use Application\Models\UserRoles;
use \Phalcon\DI\InjectionAwareInterface;
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
     * @const TOKEN_KEY
     */
    const TOKEN_KEY = 'token';

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
     * User auth error
     *
     * @var array $error
     */
    protected $error = '';

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
     * Get Response data service
     *
     * @return \Phalcon\Http\Response
     */
    public function getResponse() {
        return $this->getDi()->get('response');
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
     * Set auth error messages
     *
     * @param string $message
     * @param string $code
     */
    public function setError($message) {
        $this->error = $this->getTranslator()->translate($message);
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
     * Authenticate user from credentials
     *
     * @param array $credentials
     * @return boolean
     */
    public function authenticate(array $credentials)
    {
        $this->logout();

        // get user from database
        $user = $this->getUser(['login' => $credentials['login']]);

        if (empty($user) === false) {

            if($this->getSecurity()->checkHash($credentials['password'], $user['password'])) {

                // user founded, password checked. Set auth token

                $token = $this->cryptToken($user['id'],
                    $this->getSecurity()->getSessionToken(),
                    $this->getRequest()->getUserAgent()
                );

                // setup token to storage
                $this->setAccessToken($user['id'], $token, (time() + $this->getConfig()->rememberKeep));

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
                return false;
            }
        }
        else {
            $this->setError('USER_NOT_FOUND');
            return false;
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

            // setup token to storage
            $this->setAccessToken($user->getId(), $token, (time() + $this->getConfig()->rememberKeep));

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

                $this->setAccessToken($session->get('user')['id'], $session->get('token')['token'], (time() - $this->getConfig()->rememberKeep));

                $session->remove(self::TOKEN_KEY);
            }

            $session->remove('user');
        }

        if($this->isAuth() === false) {
            return true;
        }
        else {
            return false;
        }
    }
}