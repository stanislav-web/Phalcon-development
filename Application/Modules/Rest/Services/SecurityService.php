<?php
namespace Application\Modules\Rest\Services;

use Application\Modules\Rest\Aware\RestSecurityProvider;
use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Application\Modules\Rest\Exceptions\UnauthorizedException;

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
     * @return bool|array
     */
    protected function setToken($user_id, $token, $expire_date) {

        $authData = $this->getUserMapper()->setAccessToken(
            $user_id, $token, $expire_date
        );

        if($authData != false) {

            $result = $authData->toArray();
            $result['token'] = base64_encode($result['token']);

        }

        return $result;
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
                "bind" => [base64_decode($token)],
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
     * @param string $login
     * @param string $password
     * @return boolean
     */
    public function authenticate($login, $password) {

        $user = $this->getUserMapper()->getOne(['login' => $login]);
        if($user !== false) {

            if($this->getSecurity()->checkHash($password, $user->getPassword())) {

                $token = $this->getSecurity()->hash($this->getSecurity()->getToken());

                $accessToken = $this->setToken(
                    $user->getId(),
                    $token,
                    (time() + $this->getConfig()->api->token->lifetime)
                );

                if(is_array($accessToken) === true) {

                    $this->getUserMapper()->refresh($user->getId(), [
                        'ip'    =>  $this->getRequest()->getClientAddress(),
                        'ua'    =>  $this->getRequest()->getUserAgent(),
                    ]);

                    return $accessToken;
                }
                else {
                    throw new BadRequestException();
                }
            }
            else {
                $this->setError('INVALID_AUTH_DATA');
                throw new UnauthorizedException();
            }
        }
        else {
            throw new NotFoundException('User not found', 404);
        }
    }
}