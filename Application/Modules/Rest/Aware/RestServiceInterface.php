<?php
namespace Application\Modules\Rest\Aware;

/**
 * RestServiceInterface. Implementing rules necessary intended for REST API Service
 *
 * @package Application\Modules\Rest
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Rest/Aware/RestValidatorInterface.php
 */
interface RestServiceInterface {

    /**
     * Success operations
     */

    const CODE_OK           = 200;
    const CODE_CREATED      = 201;
    const MESSAGE_OK        = '0K';
    const MESSAGE_CREATED   = 'Created';

    /**
     * Initialize validator to this service
     *
     * @param \Application\Modules\Rest\Services\RestValidationService $validator
     */
    public function __construct(\Application\Modules\Rest\Services\RestValidationService $validator);

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi();

    /**
     * Set validator
     *
     * @param \Application\Modules\Rest\Services\RestValidationService $validator
     */
    public function setValidator($validator);

    /**
     * Get validator
     *
     * @return \Application\Modules\Rest\Services\RestValidationService
     */
    public function getValidator();

    /**
     * Set response header
     *
     * @param array $params
     */
    public function setHeader(array $params);

    /**
     * Set user app messages content.
     *
     * @param string|array $message
     * @return \Application\Modules\Rest\Services\JsonRestService
     */
    public function setMessage($message);

    /**
     * Get user app messages content.
     *
     * @return array
     */
    public function getMessage();

    /**
     * Get get user preferred / selected locale
     *
     * @return string
     */
    public function getLocale();

    /**
     * Validate request params
     *
     * @uses \Application\Modules\Rest\Services
     * @return void
     */
    public function validate();

    /**
     * Send response to client
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function response();
}