<?php
namespace Application\Modules\Rest\Services;

use Application\Services\Security\AuthService;
use \Phalcon\DI\InjectionAwareInterface;
use Application\Modules\Rest\Exceptions;
use \Valitron\Validator;

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
class JsonRestService implements InjectionAwareInterface {

    /**
     * Provide response content type
     *
     * @var string $contentType;
     */
    private $debug  = false;

    /**
     * REST Validator
     *
     * @var \Application\Modules\Rest\Services\RestValidationService $validator;
     */
    private $validator;

    /**
     * Provide response content type
     *
     * @var string $contentType;
     */
    private $contentType  = 'application/json';

    /**
     * Provide response content charset
     *
     * @var string $contentCharset;
     */
    private $contentCharset  = 'utf-8';

    /**
     * Default response code
     *
     * @var int $code;
     */
    private $httpCode = 200;

    /**
     * Default response message
     *
     * @var string $message;
     */
    private $httpMessage = 'OK';

    /**
     * User app message container
     *
     * @var array $reply;
     */
    private $reply = [];

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Init default HTTP response status
     */
    public function __construct(\Application\Modules\Rest\Services\RestValidationService $validator) {

        $this->validator = $validator;
        $this->setStatusMessage();
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Filter required params
     *
     * @param array $params
     * @throws Exceptions\MethodNotAllowedException
     */
    public function filterRequiredParams(array $params)
    {
        $intersect = array_intersect_key(array_flip($params), $this->getRequestParams());

        if(count($params) !== count($intersect)) {
            throw new Exceptions\BadRequestException();
        }

        return $this;
    }

    /**
     * Get dispatcher controllers
     *
     * @return \Phalcon\Mvc\Dispatcher
     */
    public function getDispatcher()
    {
        return $this->getDi()->get('dispatcher');
    }

    /**
     * Get server request
     *
     * @return \Phalcon\Http\Request
     */
    public function getRequestService()
    {
        return $this->getDi()->get('request');
    }

    /**
     * Get basic response service
     *
     * @return \Phalcon\Http\Response
     */
    private function getResponseService()
    {
        return $this->getDi()->get('response');
    }

    /**
     * Get basic response service
     *
     * @uses \Application\Services\Security\AuthService
     * @throws Exceptions\UnauthorizedException
     */
    public function useRestrictAccess()
    {
        // get access token from any request
        $token = $this->getDi()->get('AuthService')->getAccessToken();
        if(empty($token) === true) {
            throw new Exceptions\UnauthorizedException();
        }
        else {
            $this->getResponseService()->setHeader('X-'.ucfirst(AuthService::TOKEN_KEY),
                base64_encode($token['token']));
        }
    }

    /**
     * Send response to client
     *
     * @param int $status
     * @param string $message
     * @return \Phalcon\Http\ResponseInterface
     */
    public function response() {

        $response = $this->getResponseService()
            ->setContentType($this->contentType, $this->contentCharset)
            ->setStatusCode($this->httpCode, $this->httpMessage)
            ->setHeader('Access-Control-Allow-Origin', 'http://'.$this->getRequestService()->getServer('HTTP_HOST'))
            ->setHeader('Access-Control-Allow-Methods', $this->validator->getRules()->methods)
            ->setHeader('Access-Control-Allow-Credentials', 'true');

        if($this->debug === true) {
            $this->reply['debug'] = [
                'request' => $this->getRequestService()->getHeaders(),
                'response' => $this->getResponseService()->getHeaders()->toArray(),
            ];
        }
        return $response->setJsonContent($this->reply)
            ->send();
    }

    /**
     * Set HTTP Status Message
     *
     * @param int $code default response code
     * @param string $message default response message
     * @return JsonRestService
     */
    public function setStatusMessage($code = 200, $message = 'OK') {

        $this->reply['code'] = $this->httpCode     = $code;
        $this->reply['message'] = $this->httpMessage  = $message;

        return $this;
    }

    /**
     * Set user app reply content.
     *
     * @param string|array $reply
     * @param boolean $isLast block reply loop
     * @return JsonRestService
     */
    public function setReply($reply) {

        if($this->reply['code'] > 204) {

            $this->reply    =   ['error' =>
                $this->reply
            ];
            return false;
        }
        foreach((array)$reply as $k => $v)
        {
            $this->reply['response'][$k]    =   $v;
        }

        return $this;
    }

    /**
     * Debugger state
     *
     * @param boolean $enable
     * @return JsonRestService
     */
    public function setDebug($enable) {

        if($enable === true) {
            $this->debug = $enable;
        }

        return $this;
    }

    /**
     * Set validation rules
     *
     * @param array $rules
     * @return JsonRestService
     */
    public function setRules(array $rules) {

        $this->rules = $rules;

        return $this;
    }

    /**
     * @throws Exceptions\MethodNotAllowedException
     */
    public function validate() {
        $this->validator->isAllowMethods();

        return $this;
    }
}