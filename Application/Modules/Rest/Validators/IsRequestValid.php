<?php
namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\BadRequestException;

/**
 * Class IsRequestValid. Check if request params is valid
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/IsRequestValid.php
 */
class IsRequestValid {

    /**
     * Check if request params is valid
     *
     * @param array $params
     * @param \StdClass $rules
     * @throws BadRequestException
     */
    public function __construct(array $params, \StdClass $rules) {

    }
}