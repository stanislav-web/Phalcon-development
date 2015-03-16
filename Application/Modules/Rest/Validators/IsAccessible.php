<?php

namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\UnauthorizedException;
use Application\Modules\Rest\Exceptions\ForbiddenException;

/**
 * Class IsAccessible. Check if access is allowed by requested user
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/IsAccessible.php
 */
class IsAccessible {

    /**
     * Access rules to current action
     *
     * @var \StdClass $rules
     */
    private $rules;

    /**
     * Authentication service
     *
     * @var \Application\Services\Security\AuthService $auth
     */
    private $auth;

    /**
     * Request service
     *
     * @var \Phalcon\Http\Request $request
     */
    private $request;

    /**
     * Check if access to url is allow by user
     *
     * @param \Phalcon\DI\FactoryDefault $di
     * @param \stdClass                  $rules
     * @throws ForbiddenException
     * @throws UnauthorizedException
     */
    public function __construct(\Phalcon\DI\FactoryDefault $di, \stdClass $rules) {

        $this->rules = $rules;

        if(isset($this->rules->authentication) === true) {

            $this->auth = $di->get('AuthService');

            if(empty($this->auth->isAuth()) === false) {

                $this->request = $di->getShared('request');
                $this->isAllowAccess();
            }
            else {
                throw new UnauthorizedException();
            }
        }
    }

    /**
     * Check access by role
     *
     * @throws ForbiddenException
     */
    public function isAllowAccess() {

        if(isset($this->rules->access) === true) {

            foreach($this->rules->access as $role => $urls) {

                if($this->auth->hasRole($role) === false
                    && in_array($this->request->getURI(), $urls)) {

                    throw new ForbiddenException();
                }
            }
        }
    }

    /**
     * Free params
     */
    public function destruct() {

        unset($this->rules);
        unset($this->auth);
        unset($this->request);

    }
}