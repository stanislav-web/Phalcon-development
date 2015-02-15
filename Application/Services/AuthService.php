<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;
use Application\Models\Users;

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
     * Config app
     *
     * @var \Phalcon\Config $config;
     */
    protected $config;

    /**
     * Access token
     *
     * @var string $token;
     */
    protected $token;

    /**
     * Request
     *
     * @var \Phalcon\Http\Request  $request;
     */
    protected $request;

    /**
     * User data
     *
     * @var array $user;
     */
    protected $user = [];

    /**
     * User auth errors
     *
     * @var array $errors;
     */
    protected $errors = [];

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
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Config load
     *
     * @param \Phalcon\Config $config
     * @param \Phalcon\Http\Request $request
     */
    public function __construct(\Phalcon\Config $config, \Phalcon\Http\Request $request) {

        $this->config = $config;
        $this->request = $request;
    }


    public function register(array $credentials) {


    }

    /**
     * Login to system
     *
     * @param string $login
     * @param string $password
     * @param \Phalcon\Security $security
     * @return array user data
     */
    public function login($login, $password, \Phalcon\Security $security) {

        // get user from database
        $user = $this->getUser(['login' => $login]);

        if(empty($user) === false) {

            if($security->checkHash($password, $user->getPassword())) {

                // user founded, password checked. Set auth token
                $this->token = $this->cryptToken(
                    $user->getId(),
                    $security->getSessionToken(),
                    $this->request->getUserAgent()
                );

                // setup token to storage
                $this->setAccessToken($this->token);

                // update auth params
                $user->setSalt($security->getSessionToken())
                    ->setToken($this->token)
                    ->setIp($this->request->getClientAddress())
                    ->setUa($this->request->getUserAgent())
                    ->save();

                // save data to session
                $this->di->getShared('session')->set('user', $user->toArray());

                return $user;

            }
            else {
                // error. Wrong auth param
                $this->errors[] =   'WRONG_DATA';
            }
        }
        else  {
            // error. User does not exist in database
            $this->errors[] =   'NOT_FOUND';
        }
    }

    /**
     * Check user role
     * 
     * @param int $role
     * @return bool
     */
    public function hasRole($role) {

        $session = $this->di->getShared('session');
        if($session->has('user') === true) {

            return ($session->get('user')['role'] === $role) ? true : false;
        }
        else {
            return false;
        }
    }

    /**
     * Get auth error messages
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Get user auth data
     *
     * @param array $credentials field=value
     * @param boolean $asArray get as Array
     * @return mixed
     */
    public function getUser(array $credentials = [], $asArray = false) {

        if(empty($credentials) === true) {

            // get user data from session
            $session = $this->di->getShared('session');

            if($session->has('user') === true) {
                $this->user =   $session->get('user');
            }
        }

        // get user data
        if(empty($this->user) === true) {

            $this->user = (new Users())->findFirst([
                "".key($credentials)." = ?0",
                "bind" => [$credentials[key($credentials)]],
            ]);
            if($asArray === true) {
                $this->user->toArray();
            }
        }
        return $this->user;
    }

    /**
     * Get user access token
     *
     * @return string
     */
    public function getAccessToken() {

        // get access token from header
        if($this->request === null) {
            $this->request = $this->di->get('request');
        }
        $token = $this->request->getHeader('X_TOKEN');

        if(empty($token) === false) {

            // need to decrypt token from header
            $token = $this->di->get('crypt')->decryptBase64($token, $this->config->cookieCryptKey);
        }
        // get token from session
        else if($this->di->getShared('session')->has(self::TOKEN_KEY) === true) {

            $token =   $this->di->getShared('session')->get(self::TOKEN_KEY);
        }
        // get token from cookies
        else if($this->di->getShared('cookies')->has(self::TOKEN_KEY) === true) {
            $token =   $this->di->getShared('cookies')->get(self::TOKEN_KEY)->getValue();
        }

        return $token;
    }

    /**
     * Set user access token
     *
     * @param string $token
     * @return string
     */
    public function setAccessToken($token) {

        // get storage services
        $cookies = $this->di->getShared('cookies');
        $session = $this->di->getShared('session');

        // set data to storages
        $cookies->set(self::TOKEN_KEY, $token, time() + ($this->config->rememberKeep), '/', $this->request->getHttpHost(), false, false);
        $session->set(self::TOKEN_KEY, $token);
    }

    /**
     * is User authorized
     *
     * @return bool
     */
    public function isAuth() {

        // access ok
        $token = $this->getAccessToken();
        $session = $this->di->getShared('session');

        if($session->has('user') === true) {

            if($token === $this->cryptToken($session->get('user')['id'], $session->get('user')['salt'], $this->request->getUserAgent())) {

                return true;
            }
            else {
                $this->errors[] =   'WRONG_USER_TOKEN';
                return false;
            }
        }
        else
            return false;
    }

    /**
     * Crypt auth token
     *
     * @param int $id User Id
     * @param string $security security (hash) token
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

        $session = $this->di->getShared('session');
        $cookies = $this->di->getShared('cookies');

        // destroy session data
        if($session->has('user')) {
            $session->remove('user');
        }

        if($session->has(self::TOKEN_KEY)) {
            $session->remove(self::TOKEN_KEY);
        }

        // destroy cookies
        if($cookies->has(self::TOKEN_KEY)) {
            $cookies->get(self::TOKEN_KEY)->delete();
        }

        // reset all headers
        $this->di->getShared('response')->resetHeaders();

        if($this->isAuth() === false) {
            return true;
        }
        else {
            return false;
        }

    }
}