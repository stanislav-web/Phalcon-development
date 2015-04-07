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
     * Templates for restore views
     */
    const RESTORE_VIEW_DIR = ':engine/notifies/';

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
     * Logout user (clear token)
     *
     * @param array $credentials
     * @return Rest\Aware\ResultSet|void
     * @throws NotFoundException
     */
    public function logout(array $credentials) {

        $credentials[0] = str_replace('id', 'user_id',$credentials[0]);
        $user = $this->getUserMapper()->getAccess()->findFirst($credentials);
        if($user !== false) {
            $user->delete();
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
        $this->getView()->setViewsDir(APP_PATH.'/Modules/Rest/views');

        $params = [
            'login'     => $user->getLogin(),
            'name'      => $user->getName(),
            'password'  => $password,
            'site'      => $engine->getHost(),
            'sitename'  => $engine->getName()
        ];

        if(filter_var($user->getLogin(), FILTER_VALIDATE_EMAIL) !== false) {

            $message = $this->getMailer()->createMessageFromView(strtr(self::RESTORE_VIEW_DIR, [':engine' => $engine->getCode()]).'restore_password_email', $params)
                ->to($user->getLogin(), $user->getName())
                ->subject(sprintf($this->getTranslator()->translate('PASSWORD_RECOVERY_SUBJECT'), $engine->getHost()))
                ->priority(1);

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

            $content = $this->getView()->getRender(strtr(self::RESTORE_VIEW_DIR, [':engine' => $engine->getCode()]), 'restore_password_sms', $params);

            $message = $this->getSmsService()->call('SMSC')->setRecipient($user->getLogin());
            $message->send(trim($content));
        }
    }
}