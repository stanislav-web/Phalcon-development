<?php
namespace Application\Services\Http;

use Application\Services\Security\AuthService;
use \Phalcon\DI\InjectionAwareInterface;
use Application\Modules\Rest\Exceptions;
use \Valitron\Validator;

/**
 * Class JsonRestService. Http Rest handler
 *
 * @package Application\Services
 * @subpackage Http
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Http/JsonRestService.php
 */
class JsonRestService implements InjectionAwareInterface {

    /**
     * Provide response content type
     *
     * @var string $contentType;
     */
    private $debug  = false;

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
     * Allowed request method
     *
     * @var array $allowedMethods;
     */
    private $allowedMethods  = ['*'];

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Init default HTTP response status
     */
    public function __construct(\Application\Services\Http\RestValidationService $validator) {

        $this->setStatusMessage();

        var_dump($validator->validate());
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
     * Set allowed methods
     *
     * @param array $allowedMethods
     * @return JsonRestService
     * @throws Exceptions\MethodNotAllowedException
     */
    public function setAllowedMethods(array $allowedMethods)
    {
        if(in_array($this->getRequestService()->getMethod(),$allowedMethods) === false) {
            throw new Exceptions\MethodNotAllowedException();
        }
        $this->allowedMethods = $allowedMethods;

        return $this;
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
            ->setHeader('Access-Control-Allow-Methods', implode(',', $this->allowedMethods))
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
}