<?php
namespace Application\Modules\Rest\Aware;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Security\Random;

/**
 * RestSecurityProvider. Rest API Security rules provider
 *
 * @package Application\Modules\Rest
 * @subpackage Aware
 * @since      PHP >=5.6
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Rest/Aware/RestSecurityProvider.php
 */
abstract class RestSecurityProvider implements InjectionAwareInterface {

    /**
     * @const Max pass length while recovery
     */
    const RECOVERY_PASS_LENGTH = 10;

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi(\Phalcon\DiInterface $di)
    {
        $this->di = $di;
    }

    /**
     * Get api config
     *
     * @return \Phalcon\Config
     */
    public function getConfig() {
        return $this->getDi()->get('RestConfig')->api;
    }

    /**
     * Get request plugin
     *
     * @return \Phalcon\Http\Request
     */
    public function getRequest() {
        return $this->getDi()->getShared('request');
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
     * Get sms service
     *
     * @return \SMSFactory\Sender
     */
    public function getSmsService() {
        return $this->getDi()->get('SmsService');
    }

    /**
     * User Mapper
     *
     * @return \Application\Services\Mappers\UserMapper
     */
    public function getUserMapper() {
        return $this->getDi()->get('UserMapper');
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
     * Get logger plugin
     *
     * @return \Application\Services\Mappers\LogMapper
     */
    public function getLogger() {
        return $this->getDi()->getShared('LogMapper');
    }

    /**
     * Get view plugin
     *
     * @return \Phalcon\Mvc\View
     */
    public function getView() {
        return $this->getDi()->getShared('view');
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi() {
        return $this->di;
    }

    /**
     * Generate random string
     *
     * @uses \Phalcon\Security\Random
     * @return int
     */
    public function randomString() {
        return (new Random())->number(self::RECOVERY_PASS_LENGTH);
    }

    /**
     * Get Translate service
     *
     * @return \Translate\Translator|null
     */
    public function getTranslator() {

        if($this->getDi()->has('TranslateService') === true) {
            return $this->getDi()->get('TranslateService')->assign('sign');
        }

        return null;
    }

    /**
     * Authenticate user use credentials
     *
     * @param array $credentials
     * @return \Phalcon\Mvc\Model\Resultset\Simple
     */
    abstract public function authenticate(array $credentials);

    /**
     * Register new user from credentials
     *
     * @param array $credentials
     * @return \Phalcon\Mvc\Model\Resultset\Simple
     */
    abstract public function register(array $credentials);

    /**
     * Restore user access from credentials
     *
     * @param array $credentials
     * @return \Phalcon\Mvc\Model\Resultset\Simple
     */
    abstract public function restore(array $credentials);

    /**
     * Logout user (clear tokens)
     *
     * @param array $credentials
     * @return \Phalcon\Mvc\Model\Resultset\Simple
     */
    abstract public function logout(array $credentials);

    /**
     * Get user access token from header or request
     *
     * @return string $token
     */
    abstract protected function getToken();

    /**
     * Set user access token
     *
     * @param int $user_id Auth user ID
     * @param string $token Generated token
     * @param int $expire_date Token date expiry
     * @return boolean
     */
    abstract protected function setToken($user_id, $token, $expire_date);

    /**
     * If user is authenticated?
     *
     * @return boolean
     */
    abstract protected function isAuthenticated();

    /**
     * If user has role?
     *
     * @param int $role
     * @return boolean
     */
    abstract protected function hasRole($role);
}