<?php
namespace Application\Modules\Rest\Services;

use Application\Modules\Rest\Aware\RestServiceInterface;

/**
 * Class RestService. Http Rest handler
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/RestService.php
 */
class RestService implements RestServiceInterface {

    /**
     * Validator service
     *
     * @var \Application\Modules\Rest\Services\RestValidatorCollectionService $validator
     */
    private $resolver;

    /**
     * Default response headers send required
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
     * User preferred locale
     *
     * @var string $locale
     */
    private $locale;

    /**
     * Current /created resource uri
     *
     * @var string $resourceUri
     */
    private $resourceUri;

    /**
     * Init default HTTP headers
     * Attach validator collections
     *
     * @param \Application\Modules\Rest\Services\RestValidatorCollectionService $validator
     */
    public function __construct(\Application\Modules\Rest\Services\RestValidatorCollectionService $validator) {

        $validator->init();

        $this->setResolver($validator)->setHeader($this->headers);
    }

    /**
     * Set validator
     *
     * @param \Application\Modules\Rest\Services\RestValidatorCollectionService $validator
     */
    private function setResolver($validator)
    {
        $this->resolver = $validator;

        return $this;
    }

    /**
     * Get validator
     *
     * @return \Application\Modules\Rest\Services\RestValidatorCollectionService
     */
    private function getResolver()
    {
        return $this->resolver;
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
    private function getResponseService()
    {
        return $this->getResolver()->getDi()->get('response');
    }

    /**
     * Get REST Cache Service
     *
     * @return \Application\Modules\Rest\Services\RestCacheService
     */
    public function getCacheService() {
        return  $this->getResolver()->getDi()->getShared('RestCache');
    }

    /**
     * Set HTTP Status Message
     *
     * @param int $code default response code
     * @param string $message default response message
     * @param string $resource default called resource
     * @return RestService
     */
    public function setStatusMessage($code = self::CODE_OK, $message = self::MESSAGE_OK, $resource = null) {

        $this->setResourceUri($resource);
        $this->getResponseService()->setStatusCode($code, $message);

        $this->message['code'] = $code;
        $this->message['message'] = $message;
        $this->message['resource'] = $this->getResourceUri();

        return $this;
    }

    /**
     * Set current  / created resource uri
     *
     * @param string $resourceUri
     * @return RestService
     */
    public function setResourceUri($resourceUri = null) {

        $this->resourceUri =
            (is_null($resourceUri) === true)
        ? $this->getResolver()->getRequest()->getURI() : $resourceUri;
        
        return $this;
    }

    /**
     * Set response content length
     *
     * @param string $content
     * @return RestService
     */
    public function setContentLength($content) {
        return strlen(json_encode($content));
    }

    /**
     * Set configured cache header
     */
    public function setCacheHeader() {

        $this->getResponseService()->setEtag($this->getCacheService()->getKey());

        $this->setHeader([
            'Cache-Control' =>  'max-age='.$this->getCacheService()->getLifetime().' must-revalidate',
            'Expires'       => gmdate('D, d M Y H:i:s T', time()+$this->getCacheService()->getLifetime())
        ]);
    }

    /**
     * Get resource uri
     *
     * @return string
     */
    public function getResourceUri() {
        return $this->resourceUri;
    }

    /**
     * Set user app messages content.
     *
     * @param string|array $message
     * @return RestService
     */
    public function setMessage($message) {

        if(array_key_exists('code', $this->message) === false) {
            $this->setStatusMessage(); // set by default
        }

        if($this->message['code'] > self::CODE_NOT_MODIFIED) {

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
     * Set get user preferred / selected locale
     *
     * @return string $locale
     */
    public function getLocale() {

        if(is_null($this->locale)) {
            $this->locale = strtolower(substr((array_key_exists('locale', $this->getResolver()->getParams()))
                ? $this->getResolver()->getParams()['locale']
                : $this->getResolver()->getRequest()->getBestLanguage(), 0, 2));
        }

        return $this->locale;
    }

    /**
     * Set request params
     *
     * @return array
     */
    public function getParams() {
        return $this->getResolver()->getParams();
    }

    /**
     * Get limit request for used action
     *
     * @return string|int
     */
    private function getRateLimit() {

        return (isset($this->getResolver()->getRules()->requests) === true)
            ? $this->getResolver()->getRules()->requests['limit'] : 'infinity';
    }

    /**
     * Send response to client
     *
     * @param boolean $modified
     * @return \Phalcon\Http\ResponseInterface
     */
    public function response($modified) {

        // Set rules required header
        $this->setHeader([
            'Access-Control-Allow-Methods' => $this->getResolver()->getRules()->methods,
            'X-Rate-Limit'      =>  $this->getRateLimit(),
            'Content-Language'  =>  $this->getLocale(),
            'Content-Length'    =>  $this->setContentLength($this->getMessage()),
            'X-Resource'        =>  $this->getResourceUri(),
        ]);

        if($modified === true) {

            $this->setCacheHeader();
        }

        $response = $this->getResponseService();
        if(empty($this->getMessage())  === false) {
            $response->setJsonContent($this->getMessage());
        }
        return $response->send();
    }
}