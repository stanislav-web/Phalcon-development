<?php
namespace Application\Modules\Rest\Validators;
use Application\Modules\Rest\Exceptions\NotAcceptableException;

/**
 * Class IsAcceptable. Check if requested data is acceptable by api
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
     * Check if requested data is acceptable by api
     *
     * @param \Phalcon\Http\Request $request
     * @param \Phalcon\Config $config
     * @throws NotAcceptableException
     */
    public function __construct(\Phalcon\Http\Request $request, \Phalcon\Config $config) {

        if($this->isValidQueryParams($request, $config) === false) {
            throw new NotAcceptableException();
        }

        if($this->isValidContentType($request, $config) === false) {
            throw new NotAcceptableException();
        }

        if($this->isValidLanguage($request, $config) === false) {
            throw new NotAcceptableException();
        }
    }

    /**
     * Check query string by wrong parameters
     *
     * @param \Phalcon\Http\Request $request
     * @param \Phalcon\Config  $config
     * @return bool
     */
    private function isValidQueryParams(\Phalcon\Http\Request $request, \Phalcon\Config $config) {

        $queryString = $request->get();

        if(isset($queryString['_url'])) {
            unset($queryString['_url']);
        }

        $undefinedValues = array_diff_key($queryString, array_flip($config->acceptFilters->toArray()));

        return (empty($undefinedValues) === false)  ? false : true;
    }

    /**
     * Check if requested content-type is acceptable by api
     *
     * @param \Phalcon\Http\Request $request
     * @param \Phalcon\Config  $config
     * @return bool
     */
    private function isValidContentType(\Phalcon\Http\Request $request, \Phalcon\Config $config) {

        $format = $request->get('format', 'lower', null);

        if(is_null($format) === true) {
            $format = strtolower($request->getBestAccept());
        }

        return in_array($format, $config->acceptContent->toArray());
    }

    /**
     * Check if requested locale (language) is acceptable by api
     *
     * @param \Phalcon\Http\Request $request
     * @param \Phalcon\Config  $config
     * @return bool
     */
    private function isValidLanguage(\Phalcon\Http\Request $request, \Phalcon\Config $config) {

        $locale = $request->get('locale', 'lower', null);

        if(is_null($locale) === true) {

            $locale = strtolower(substr($request->getBestLanguage(), 0, 2));
        }

        return in_array($locale, $config->acceptLanguage->toArray());
    }
}