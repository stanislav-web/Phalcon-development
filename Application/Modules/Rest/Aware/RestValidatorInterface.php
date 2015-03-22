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
     * Initialize validator params.
     * Such as rules, request, filtering
     *
     * @param array $params
     * @return void
     */
    public function init(array $params);

    /**
     * Get dispatcher instance
     *
     * @return \Phalcon\Mvc\Dispatcher
     */
    public function getDispatcher();

    /**
     * Set possible request params
     *
     * @param \Phalcon\Http\Request $request
     */
    public function setParams(\Phalcon\Http\Request $request);

    /**
     * Return filtered params
     *
     * @return array
     */
    public function getParams();

    /**
     * Set error message
     *
     * @param array|string $error
     * @return void
     */
    public function setErrors($error);

    /**
     * Get error messages key [errors]
     *
     * @return array
     */
    public function getErrors();

    /**
     * Set validation rules
     *
     * @param array $params
     * @return void
     */
    public function setRules(array $params);

    /**
     * Get validation rules
     *
     * @return object
     */
    public function getRules();

    /**
     * Filter request params
     *
     * @param array $params
     * @param string $function
     * @return void
     */
    public function filter(array $params, $function);

    public function isValid();
}