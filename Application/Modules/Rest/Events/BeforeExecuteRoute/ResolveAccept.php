<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Aware\RestValidatorProvider;
use Application\Modules\Rest\Exceptions\NotAcceptableException;

/**
 * ResolveAccept. Watch allowed parameters
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveAccept.php
 */
class ResolveAccept extends RestValidatorProvider {

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

        if($this->isValidQueryParams() === false) {
            throw new NotAcceptableException([
                'FILTERS_IS_NOT_SUPPORT'  =>  'This filters is not support'
            ]);
        }

        if($this->isValidContentType() === false) {
            throw new NotAcceptableException([
                'CONTENT_IS_NOT_SUPPORT'  =>  'This content type is not support'
            ]);
        }

        if($this->isValidLanguage() === false) {
            throw new NotAcceptableException([
                'LANGUAGE_IS_NOT_SUPPORT'  =>  'This language is not support'
            ]);
        }
    }

    /**
     * Check query string by wrong parameters
     *
     * @return bool
     */
    private function isValidQueryParams() {

        $queryString = $this->getRequest()->get();

        if(isset($queryString['_url'])) {
            unset($queryString['_url']);
        }

        $undefinedValues = array_diff_key($queryString, array_flip($this->getConfig()->acceptFilters->toArray()));
        return (empty($undefinedValues) === false)  ? false : true;
    }

    /**
     * Check if requested content-type is acceptable by api
     *
     * @return bool
     */
    private function isValidContentType() {

        $format = $this->getRequest()->get('format', 'lower', null);

        if(is_null($format) === true) {
            $format = strtolower($this->getRequest()->getBestAccept());
        }

        return in_array($format, $this->getConfig()->acceptContent->toArray());
    }

    /**
     * Check if requested locale (language) is acceptable by api
     *
     * @return bool
     */
    private function isValidLanguage() {

        $locale = $this->getRequest()->get('locale', 'lower', null);

        if(is_null($locale) === true) {

            $locale = strtolower(substr($this->getRequest()->getBestLanguage(), 0, 2));
        }

        return in_array($locale, $this->getConfig()->acceptLanguage->toArray());
    }
}