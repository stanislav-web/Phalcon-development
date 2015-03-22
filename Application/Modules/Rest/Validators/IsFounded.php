<?php

namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class IsFounded. Check if route or record exist
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/IsFounded.php
 */
class IsFounded {

    /**
     * Check if request method is allowed
     *
     * @param \Phalcon\Http\Request $request
     * @throws NotFoundException
     */
    public function __construct(\Phalcon\Mvc\Router $router) {

        throw new NotFoundException();
    }
}