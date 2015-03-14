<?php
namespace Application\Modules\Rest\Aware;

/**
 * RestValidatorInterface. Implementing rules necessary intended for Validation REST requests
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


    public function setError($message);
    public function getError();
    public function setRules(array $params);
    public function getRules();
    public function setParams(array $params);
    public function getParams();
    public function filter();
    public function validate();
}