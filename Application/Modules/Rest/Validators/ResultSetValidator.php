<?php
namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Phalcon\Mvc\Model\Resultset\Simple as ResultSet;

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

    const CODE_OK               = 200;
    const CODE_CREATED          = 201;
    const CODE_NOT_MODIFIED     = 304;
    const MESSAGE_OK            = '0K';
    const MESSAGE_CREATED       = 'Created';
    const MESSAGE_NOT_MODIFIED  = 'Not Modified';
    const RECORDS_NOT_FOUND  = 'The records not found';

    /**
     * Resultset response definition
     *
     * @var \Phalcon\Mvc\Model\Resultset\Simple $response
     */
    private $response;

    /**
     * Result definition
     *
     * @var array $result
     */
    private $result = [];

    /**
     * Error messages
     *
     * @var array $errors
     */
    private $errors = [];

    /**
     * Setup definition
     *
     * @param mixed $response
     */
    public function __construct($response) {

        $this->setResponse($response);
    }

    /**
     * Set response set
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $response
     * @return ResultSetValidator
     */
    private function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get hydrated response object
     *
     * @return \Phalcon\Mvc\Model\Resultset\Simple
     */
    private function getResponse()
    {
        return $this->response;
    }

    /**
     * Set result set
     *
     * @return ResultSetValidator
     */
    private function setResult()
    {
        if($this->hasErrors() === false) {

            $result = [];
            $result['code'] = self::CODE_OK;
            $result['message'] = self::MESSAGE_OK;
            $result['limit']   = $this->getResponse()->count();

            $this->result = (array_merge($result, ['data' => $this->getResponse()->toArray()]));
        }
        else {
            $this->result = $this->getErrors();
        }

        return $this;
    }

    /**
     * Get result data
     *
     * @return array
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
    private function notFoundRecords() {

        if(empty($this->errors['data']) === true) {
            $this->errors['code']       = NotFoundException::CODE;
            $this->errors['message']    = NotFoundException::MESSAGE;
        }
        $this->errors['data'][]  = [
            'RECORDS_NOT_FOUND' => self::RECORDS_NOT_FOUND
        ];
    }

    /**
     * Set response as Bad Request
     *
     * @param array|string $errors
     * @return ResultSetValidator
     */
    private function invalidResponse($messages) {

        if(empty($this->errors['data']) === true) {
            $this->errors['code']       = BadRequestException::CODE;
            $this->errors['message']    = BadRequestException::MESSAGE;
        }
        $this->errors['data'][]  = [
            'INVALID_RESPONSE' => $messages
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
     * Validate response
     * @return ResultSetValidator
     */
    public function validate()
    {
        if($this->getResponse() instanceof ResultSet) {

            if($this->getResponse()->valid() === false) {

                // error handling
                if(is_null($this->getResponse()->getMessages()) === true) {
                    $this->notFoundRecords();
                }
                else {
                    $this->invalidResponse($this->getResponse()->getMessages());
                }
            }

            $this->setResult();
        }

        return $this;
    }
}