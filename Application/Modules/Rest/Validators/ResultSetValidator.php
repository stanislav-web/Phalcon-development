<?php
namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class ResultSetValidator. Checking response
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/ResultSetValidator.php
 */
class ResultSetValidator {

    const RECORD_NOT_FOUND  = 'The record not found in `%s`';

    /**
     * Resultset definition
     *
     * @var \Phalcon\Mvc\Model\Resultset\Simple $result
     */
    private $result;

    /**
     * Error messages
     *
     * @var array $errors
     */
    private $errors = [];

    /**
     * Setup definition
     *
     * @param mixed $result
     */
    public function __construct($result) {

        $this->setResult($result);
    }

    /**
     * Set result set
     *
     * @param mixed $result
     * @return ResultSetValidator
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get hydrated result object
     *
     * @return \Phalcon\Mvc\Model\Resultset\Simple $result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set response as Not Found
     *
     * @param array|string $errors
     * @return ResultSetValidator
     */
    public function notFoundRecords() {

        if(empty($this->errors['info']) === true) {
            $this->errors['code']       = NotFoundException::CODE;
            $this->errors['message']    = NotFoundException::MESSAGE;
        }
        $this->errors['info'][]  = [
            'RECORD_NOT_FOUND' => sprintf(self::RECORD_NOT_FOUND)
        ];

        return $this;
    }

    /**
     * Get error messages key [errors]
     *
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Check if errors exist
     *
     * @return boolean
     */
    public function hasErrors() {

        return (!empty($this->errors));
    }

    /**
     * Resolve response message
     */
    public function resolve()
    {
        if($this->getResult()->count() > 0) {
            return $this->getResult()->toArray();
        }
        else {
            return $this->notFoundRecords();
        }
    }
}