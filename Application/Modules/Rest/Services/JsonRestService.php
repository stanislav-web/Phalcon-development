<?php
namespace Application\Modules\Rest\Services;

use Application\Modules\Rest\Aware\RestServiceInterface;

/**
 * Class JsonRestService. Http Rest handler
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/JsonRestService.php
 */
class JsonRestService implements RestServiceInterface {

    /**
     * REST Validator
     *
     * @var \Application\Modules\Rest\Services\RestValidationService $validator;
     */
    private $validator;

    /**
     * Default headers send required
     *
     * @var array $headers
     */
    private $headers = [
        'Content-Type'                      =>  'application/json; charset=utf-8',
        'Access-Control-Allow-Origin'       =>  '*',
        'Access-Control-Allow-Credentials'  =>  'true'
    ];

    /**
     * User app message container
     *
     * @var array $message;
     */
    private $message = [];

    /**
     * Init default HTTP response status
     *
     * @param \Application\Modules\Rest\Services\RestValidationService $validator
     */
    public function __construct(\Application\Modules\Rest\Services\RestValidationService $validator) {

        $this->setValidator($validator);
        $this->setHeader($this->headers);
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->getValidator()->getDi();
    }

    /**
     * Set validator
     *
     * @param RestValidationService $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     * Get validator
     *
     * @return RestValidationService
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Set response header
     *
     * @param array $params
     */
    public function setHeader(array $params) {

        $response = $this->getResponseService();
        foreach($params as $header => $content) {
            $response->setHeader($header,$content);
        }
    }

    /**
     * Get basic response service
     *
     * @return \Phalcon\Http\Response
     */
    public function getResponseService()
    {
        return $this->getDi()->get('response');
    }

    /**
     * Set HTTP Status Message
     *
     * @param int $code default response code
     * @param string $message default response message
     * @param string $resource default called resource
     * @return JsonRestService
     */
    public function setStatusMessage($code = self::CODE_OK, $message = self::MESSAGE_OK, $resource = null) {

        $this->message['code'] = $code;
        $this->message['message'] = $message;
        (is_null($resource) === false)
            ? $this->message['resource'] = $resource
            : $this->message['resource'] = $this->getValidator()->getRequest()->getURI();
        $this->getResponseService()->setStatusCode($code, $message);

        return $this;
    }

    /**
     * Set user app messages content.
     *
     * @param string|array $message
     * @return JsonRestService
     */
    public function setMessage($message) {

        if(array_key_exists('code', $this->message) === false) {
            $this->setStatusMessage(); // set by default
        }

        if($this->message['code'] > self::CODE_CREATED) {

            $this->message    =   ['error' =>
                $this->message
            ];
            return false;
        }
        foreach((array)$message as $k => $v)
        {
            $this->message['data'][$k]    =   $v;
        }
        return $this;
    }

    /**
     * Get user app messages content.
     *
     * @return array
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Validate request params
     *
     * @uses \Application\Modules\Rest\Services
     * @return void
     */
    public function validate() {
        return $this->getValidator()->isValid();
    }


    /**
     * Send response to client
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function response() {

        // Set rules header
        $this->setHeader(['Access-Control-Allow-Methods' => $this->getValidator()->getRules()->methods]);

        $response = $this->getResponseService();
        if(empty($this->getMessage())  === false) {
            $response->setJsonContent($this->getMessage());
        }
        return $response->send();
    }


    /**
     * Filter required params
     *
     * @param array $params
     */
//    public function filterRequiredParams(array $params)
//    {
//        $intersect = array_intersect_key(array_flip($params), $this->getRequestParams());
//
//        if(count($params) !== count($intersect)) {
//            throw new Exceptions\BadRequestException();
//        }
//
//        return $this;
//    }

    /**
     * Get basic response service
     *
     * @uses \Application\Services\Security\AuthService
     */
//    public function useRestrictAccess()
//    {
//        // get access token from any request
//        $token = $this->getDi()->get('AuthService')->getAccessToken();
//        if(empty($token) === true) {
//            throw new Exceptions\UnauthorizedException();
//        }
//        else {
//            $this->getResponseService()->setHeader('X-'.ucfirst(AuthService::TOKEN_KEY),
//                base64_encode($token['token']));
//        }
//    }
}