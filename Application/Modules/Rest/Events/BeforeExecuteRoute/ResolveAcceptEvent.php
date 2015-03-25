<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Aware\RestValidatorProvider;
use Application\Modules\Rest\Exceptions\NotAcceptableException;

/**
 * ResolveAcceptEvent. Watch allowed methods
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveAcceptEvent.php
 */
class ResolveAcceptEvent extends RestValidatorProvider {

    /**
     * This action track input events before rest execute
     * @throws \Exception
     */
    public function run(\Phalcon\DI\FactoryDefault $di) {

        $this->setDi($di);

        if($this->isValidQueryParams() === false) {
            $this->throwError();
        }

        if($this->isValidContentType() === false) {
            $this->throwError();
        }

        if($this->isValidLanguage() === false) {
            $this->throwError();
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

    /**
     * Throw exception errors
     *
     * @throws \Application\Modules\Rest\Exceptions\NotAcceptableException
     * @throws \Exception
     */
    private function throwError() {

        try {
            throw new NotAcceptableException();
        }
        catch(NotAcceptableException $e) {

            //@TODO JSON response need


            $this->getDi()->get('LogMapper')->save($e->getMessage().' IP: '.$this->getRequest()->getClientAddress().' URI: '.$this->getRequest()->getURI(), Logger::ALERT);
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}