<?php
namespace Application\Services\Http;

use \Phalcon\DI\InjectionAwareInterface;
use Application\Modules\Rest\Exceptions;
use Phalcon\Exception;

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
     * @TODO Create exception follow this messages
     */
    const CREATED = 201;
    const NO_CONTENT = 204;
    const FORBIDDEN = 403;
    const SERVER_ERROR = 500;

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
     * @TODO Create exception follow this messages
     * Response statuses / messages
     *
     * @var array $sm
     */
    private $sm = [
        self::CREATED => 'Created',
        self::NO_CONTENT => 'No Content',
        self::FORBIDDEN => 'Forbidden',
        self::SERVER_ERROR => 'Internal Server Error'
    ];

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
    public function __construct() {

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
     * Get request params (Header, Requests, Routes)
     *
     * @return array
     */
    public function getRequestParams()
    {
        return $this->getDi()->get('dispatcher')->getParams()
            +$this->getRequestService()->get();
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
     * @throws Exceptions\MethodNotAllowedException
     */
    public function useRestrictAccess()
    {
        // get access token from any request
        $token = $this->getDi()->get('AuthService')->getAccessToken();

        if(empty($token) === true) {
            throw new Exceptions\UnauthorizedException();
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

        return $this->getResponseService()
            ->setContentType($this->contentType, $this->contentCharset)
            ->setStatusCode($this->httpCode, $this->httpMessage)
            ->setHeader('Access-Control-Allow-Origin', 'http://'.$this->getRequestService()->getServer('HTTP_HOST'))
            ->setHeader('Access-Control-Allow-Methods', implode(',', $this->allowedMethods))
            ->setHeader('Access-Control-Allow-Credentials', 'true')
            ->setJsonContent($this->reply)
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

        if($this->reply['code'] > self::NO_CONTENT) {
            return false;
        }
        foreach((array)$reply as $k => $v)
        {
            $this->reply['response'][$k]    =   $v;
        }

        return $this;
    }

}