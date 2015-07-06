<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Aware\RestValidatorProvider;
use Application\Modules\Rest\Exceptions\LongRequestException;

/**
 * ResolveRequestLength. Watch allowed query string length
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveRequestLength.php
 */
class ResolveRequestLength extends RestValidatorProvider {

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

        if($this->isValidQuery() === false) {
            throw new LongRequestException([
                'LONG_REQUEST'  =>  'Too many parameters in the query string'
            ]);
        }
    }

    /**
     * Check query string by wrong parameters
     *
     * @return bool
     */
    private function isValidQuery() {

        $queryString = $this->getRequest()->getQuery();

        if(isset($queryString['_url'])) {
            unset($queryString['_url']);
        }
        $queryString = http_build_query($queryString);

        if(mb_strlen($queryString, '8bit') > $this->getConfig()->acceptQueryLength) {
            return false;
        }
    }
}