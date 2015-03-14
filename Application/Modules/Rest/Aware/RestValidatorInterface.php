<?php
namespace Application\Modules\Rest\Aware;

/**
 * RestValidatorInterface. Implementing rules necessary intended for REST API Validator
 *
 * @package Application\Modules\Rest
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Rest/Aware/RestValidatorInterface.php
 */
interface RestValidatorInterface {

    /**
     * Set possible request params
     *
     * @param \Phalcon\Http\Request $request
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     */
    public function setParams(\Phalcon\Http\Request $request, \Phalcon\Mvc\Dispatcher $dispatcher);

}