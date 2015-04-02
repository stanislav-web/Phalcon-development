<?php
namespace Application\Modules\Rest\Services;

use Application\Modules\Rest;
use Application\Modules\Rest\Aware\RestSecurityProvider;
use Application\Modules\Rest\Exceptions\UnprocessableEntityException;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Application\Modules\Rest\Exceptions\UnauthorizedException;
use Phalcon\Mvc\Model\Resultset\Simple as ResultSet;
use Phalcon\Logger;

/**
 * Class RestSecurityService. Rest security provider
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/RestSecurityService.php
 */
class RestSecurityService extends RestSecurityProvider {

    /**
     * User access request key name
     */
    const REQUEST_KEY = 'token';

    /**
     * User access header key name
     */
    const HEADER_KEY = 'AUTHORIZATION';

    /**
     * User token info
     *
     * @var \Application\Models\UserAccess $token
     */
    private $token;

    /**
     * Authenticate user use credentials
     *
     * @param array $credentials
     * @throws \Application\Modules\Rest\Exceptions\UnauthorizedException
     * @throws \Application\Modules\Rest\Exceptions\NotFoundException
     * @return ResultSet
     */
    public function authenticate(array $credentials) {

        $user = $this->getUserMapper()->getOne(['login' => $credentials['login']]);
        if($user !== false) {

            if($this->getSecurity()->checkHash($credentials['password'], $user->getPassword())) {

                $token = $this->getSecurity()->hash($this->getSecurity()->getToken());

                $accessToken = $this->setToken(
                    $user->getId(),
                    $token,
                    (time() + $this->getConfig()->tokenLifetime)
                );

                $this->getUserMapper()->refresh($user->getId(), [
                    'ip' => $this->getRequest()->getClientAddress(),
                    'ua' => $this->getRequest()->getUserAgent(),
                ]);

                return $accessToken;
            }
            else {
                throw new UnauthorizedException([
                    'UNAUTHORIZED_REQUEST' => 'You are not logged in'
                ]);
            }
        }
        else {
            throw new NotFoundException([
                'USER_NOT_FOUND' => 'User not found'
            ]);
        }
    }

    /**
     * Register new user from credentials
     *
     * @param array $credentials
     * @return ResultSet
     * @throws \Application\Modules\Rest\Exceptions\BadRequestException
     * @throws \Application\Modules\Rest\Exceptions\ConflictException
     */
    public function register(array $credentials)
    {
        $user = $this->getUserMapper()->createUser($credentials);

        session_regenerate_id(true);

        $token = $this->getSecurity()->hash($this->getSecurity()->getToken());

        $accessToken = $this->setToken(
            $user->getId(),
            $token,
            (time() + $this->getConfig()->tokenLifetime)
        );

        return $accessToken;
    }

    /**
     * Restore user access by credentials
     *
     * @param array $credentials
     * @throws NotFoundException
     * @throws Rest\Exceptions\BadRequestException
     * @throws UnprocessableEntityException
     */
    public function restore(array $credentials) {

        $user = $this->getUserMapper()->getOne(['login' => $credentials['login']]);
        if($user !== false) {

            // user founded restore access by login, generate password
            $password = $this->randomString();

            // send new password to user
            $this->recoverySend($user, $password);

            // update password in Db
            $result = $this->getUserMapper()->update($user, ['password' => $password], ['surname']);

            return $result;
        }
        else {
            throw new NotFoundException([
                'USER_NOT_FOUND' => 'User not found'
            ]);
        }
    }

    /**
     * Get user access token from header or query
     *
     * @return string $token
     */
    protected function getToken() {

        $token = $this->getRequest()->get(self::REQUEST_KEY, null, null);

        if(is_null($token) === true) {
            $token = ltrim($this->getRequest()->getHeader(self::HEADER_KEY), 'Bearer ');
        }
        return trim($token);
    }

    /**
     * Set user access token
     *
     * @param int $user_id Auth user ID
     * @param string $token Generated token
     * @param int $expire_date Token date expiry
     * @return ResultSet
     */
    protected function setToken($user_id, $token, $expire_date) {

        $model = $this->getUserMapper()->setAccessToken(
            $user_id, $token, $expire_date
        );

        return $model->find(['user_id ='. $user_id]);
    }

    /**
     * If user is authenticated?
     *
     * @return boolean
     */
    public function isAuthenticated() {

        $token = $this->getToken();

        $this->token = $this->getUserMapper()->getAccess()->findFirst([
                "token = ?0 AND expire_date > NOW()",
                "bind" => [$token],
            ]
        );

        return (empty($this->token) === true) ? false : true;
    }

    /**
     * If user has role?
     *
     * @param int $role
     * @return boolean
     */
    public function hasRole($role) {

        if($this->token instanceof \Application\Models\UserAccess) {

            $isHasRole = $this->getUserMapper()->getInstance()->findFirst([
                    "id = ?0 AND role = ?1",
                    "bind" => [$this->token->getUserId(), $role],
                ]
            );

            return ($isHasRole === false) ? false: true;
        }

        return false;
    }

    /**
     * Send recovery message
     *
     * @param \Application\Models\Users $user
     * @param $password
     * @throws UnprocessableEntityException
     */
    private function recoverySend(\Application\Models\Users $user, $password) {

        $engine = $this->getDi()->get('EngineMapper')->define();

        if(filter_var($user->getLogin(), FILTER_VALIDATE_EMAIL) !== false) {

            $this->getView()->setViewsDir(APP_PATH.'/Modules/Rest/views');
            $message = $this->getMailer()->createMessageFromView($engine->getCode().'/emails/restore_password_email', [
                'login'     => $user->getLogin(),
                'name'      => $user->getName(),
                'password'  => $password,
                'site'      => $engine->getHost(),
                'sitename'  => $engine->getName()
            ])->priority(1)->to($user->getLogin(), $user->getName())->subject(sprintf($this->getTranslator()->translate('PASSWORD_RECOVERY_SUBJECT'), $engine->getHost()));

                try {
                    $message->send();
                }
                catch(\Exception $e) {

                    $this->getLogger()->save($e->getMessage(), Logger::CRITICAL);

                    throw new UnprocessableEntityException([
                        'RECOVERY_ACCESS_FAILED' => 'Recovery access failed'
                    ]);
                }
        }
        else {

            // sms send
        }
    }

//    /**
//     * Send recovery SMS
//     *
//     * @param \Application\Models\Users $user
//     * @param string $password
//     * @param \Application\Models\Engines $engine
//     * @return mixed
//     * @throws \Phalcon\Exception
//     */
//    private function sendRecoverySMS(\Application\Models\Users $user, $password, \Application\Models\Engines $engine) {
//
//        $template =  "Hello, ".$user->getName()."! Your temporary generated password is: ".$password.". Best regards, ".ucfirst($engine->getName());
//        $status = $this->getSmsService()->call(self::SMS_PROVIDER)->setRecipient($user->getLogin())->send($template);
//
//        return $status;
//    }
}