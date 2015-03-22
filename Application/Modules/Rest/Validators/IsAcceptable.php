<?php
namespace Application\Modules\Rest\Validators;
use Application\Modules\Rest\Exceptions\NotAcceptableException;

/**
 * Class IsAcceptable. Check if format is acceptable by api
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/IsAcceptable.php
 */
class IsAcceptable {

    /**
     * Check if format is acceptable by api
     *
     * @param \Phalcon\Http\Request $request
     * @param array $config
     * @throws NotAcceptableException
     */
    public function __construct(\Phalcon\Http\Request $request, array $config) {

        $format = $request->get('format', 'lower', null);

        if(is_null($format) === true) {
            $format = strtolower($request->getBestAccept());
        }

        if(in_array($format, $config['formats']) === false) {

            throw new NotAcceptableException();
        }
    }
}