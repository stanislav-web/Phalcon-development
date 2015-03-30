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
        $result = [];
        $result['code'] = self::CODE_OK;
        $result['message'] = self::MESSAGE_OK;
        $result['limit']   = $this->getResponse()->count();

        if($this->getResponse() instanceof ResultSet) {
            $this->result = (array_merge($result, ['data' => $this->getResponse()->toArray()]));
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
     * Validate response
     * @return ResultSetValidator
     */
    public function validate()
    {
        $this->setResult();
    }
}