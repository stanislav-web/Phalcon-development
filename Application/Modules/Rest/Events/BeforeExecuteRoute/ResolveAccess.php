<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Exceptions\ForbiddenException;
use Application\Modules\Rest\Exceptions\UnauthorizedException;
use Application\Modules\Rest\Aware\RestValidatorProvider;

/**
 * ResolveAccess. Watch access
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveAccess.php
 */
class ResolveAccess extends RestValidatorProvider {

    /**
     * Security service
     *
     * @var \Application\Modules\Rest\Services\SecurityService $security
     */
    private $security;

    /**
     * Request service
     *
     * @var \Phalcon\Http\Request $request
     */
    private $request;

    /**
     * This action track input events before rest execute
     *
     * @param \Phalcon\DI\FactoryDefault $di
     * @param \StdClass                  $rules
     * @return bool|void
     * @throws \Exception
     */
    public function run(\Phalcon\DI\FactoryDefault $di, \StdClass $rules) {

        $this->setDi($di);

        if(isset($rules->authentication) === true) {

            $this->security = $this->getDi()->get('RestSecurityService');

            if($this->security->isAuthenticated() === true) {

                $this->request = $this->getRequest();
                $this->isAllowedAccess($rules);
            }
            else {
                throw new UnauthorizedException([
                    'AUTH_ACCESS_REQUIRED' => 'Only for authenticated users'
                ]);
            }
        }
    }

    /**
     * Check access by role
     *
     * @param \StdClass $rules
     * @throws ForbiddenException
     */
    public function isAllowedAccess(\StdClass $rules) {

        if(isset($rules->access) === true) {

            foreach($rules->access as $role => $urls) {

                if($this->security->hasRole(array_keys($rules->access)) === false
                    && in_array(trim($this->request->getURI(), '/'), $urls)) {

                    throw new ForbiddenException([
                        'ACCESS_DENIED' => 'Here you access denied'
                    ]);
                }
            }
        }
    }

    /**
     * Free params
     */
    public function __destruct() {

        unset($this->rules, $this->request, $this->security);

    }
}