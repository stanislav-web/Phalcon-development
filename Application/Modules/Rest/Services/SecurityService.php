<?php
namespace Application\Modules\Rest\Services;

use Application\Modules\Rest\Aware\RestSecurityProvider;

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
     * Get user request token from header or query
     *
     * @return string $token
     */
    protected function getRequestToken() {

        $token = $this->getRequest()->get(self::REQUEST_KEY, null, null);

        if(is_null($token) === true) {
            $token = ltrim($this->getRequest()->getHeader(self::HEADER_KEY), 'Token ');
        }
        return trim($token);
    }

    /**
     * If user is authenticated?
     *
     * @return boolean
     */
    public function isAuthenticated() {

        $token = $this->getRequestToken();

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
}