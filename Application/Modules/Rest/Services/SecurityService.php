<?php
namespace Application\Modules\Rest\Services;

use Application\Modules\Rest\Aware\RestSecurityProvider;
use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Application\Modules\Rest\Exceptions\UnauthorizedException;
use Phalcon\Mvc\Model\Resultset\Simple as ResultSet;

/**
 * Class SecurityService. Rest security provider
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/SecurityService.php
 */
class SecurityService extends RestSecurityProvider {

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
     * Authenticate user use credentials
     *
     * @param array $credentials
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
     */
    public function register(array $credentials)
    {


        $user = $this->getUserMapper()->createUser($credentials);

        var_dump($user);
        exit('POST');

        // required params that to be saved by this user
            $data = $this->getRequest()->getPost();

            if($user !== false) {
                // register successful
                session_regenerate_id(true);
                $token = $this->cryptAccessToken($user->getId(), $user->getSalt());
                $this->setAccessToken($user->getId(), $token, (time() + $this->getConfig()->cache->lifetime));

                // save data to session
                $user = $this->getUser(['id' => $user->getId()]);
                $this->getDi()->getShared('session')->set('user', [
                    'id'        =>  $user['id'],
                    'login'     =>  $user['login'],
                    'name'      =>  $user['name'],
                    'surname'   =>  $user['surname'],
                    'role'      =>  $user['role'],
                    'state'     =>  $user['state'],
                    'salt'      =>  $user['salt'],
                    'rating'    =>  $user['rating'],
                    'date_registration' => $user['date_registration'],
                    'date_lastvisit' => $user['date_lastvisit']
                ]);

                return true;

            }
            return $this->setError($this->getUserMapper()->getErrors());
    }
}