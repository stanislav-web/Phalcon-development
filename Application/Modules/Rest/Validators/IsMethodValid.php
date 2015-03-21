<?php
namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\MethodNotAllowedException;

/**
 * Class IsMethodValid. Check if request method is allowed
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/IsMethodValid.php
 */
class IsMethodValid {

    /**
     * Check if request method is allowed
     *
     * @param \Phalcon\Http\Request $request
     * @param \StdClass $rules
     * @throws MethodNotAllowedException
     */
    public function __construct(\Phalcon\Http\Request $request, \StdClass $rules) {

        $methods = explode(',', $rules->methods);

        if(in_array($request->getMethod(),$methods) === false) {
            throw new MethodNotAllowedException();
        }
    }
}