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

    const RECORDS_NOT_FOUND  = 'The records not found';

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
     * @param \Phalcon\Mvc\Model\Resultset\Simple $result
     */
    public function __construct(\Phalcon\Mvc\Model\Resultset\Simple $result) {

        $this->setResult($result);
    }

    /**
     * Set result set
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $result
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
            'RECORDS_NOT_FOUND' => self::RECORDS_NOT_FOUND
        ];
    }

    /**
     * Set response as Bad Request
     *
     * @param array|string $errors
     * @return ResultSetValidator
     */
    public function invalidResult($messages) {

        if(empty($this->errors['info']) === true) {
            $this->errors['code']       = BadRequestException::CODE;
            $this->errors['message']    = BadRequestException::MESSAGE;
        }
        $this->errors['info'][]  = [
            'INVALID_RESULT' => $messages
        ];
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
        if($this->getResult()->valid() === true) {

            // result fine
            return $this->getResult()->toArray();
        }
        else {

            // error handling
            if(is_null($this->getResult()->getMessages()) === true) {
                $this->notFoundRecords($this->getResult());
            }
            else {
                $this->invalidResult($this->getResult()->getMessages());
            }
        }

        return $this->getErrors();
    }
}