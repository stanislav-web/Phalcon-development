<?php
namespace Application\Modules\Rest\Services;

use Application\Modules\Rest\Aware\RestServiceInterface;

/**
 * Class RestService. Http Rest handler
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.6
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
        'Access-Control-Allow-Credentials'  =>  'true',
        'Access-Control-Allow-Headers'      =>  'Accept, Authorization, X-Requested-With, Content-Type, Accept-Language, origin'
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
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * Get profiler
     *
     * @return \Application\Services\Develop\ProfilerService
     */
    public function getProfilerService()
    {
        return $this->getResolver()->getDi()->get('ProfilerService');
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
        return $this->getResolver()->getDi()->getShared('response');
    }

    /**
     * Get REST Cache Service
     *
     * @return \Application\Modules\Rest\Services\RestCacheService
     */
    private function getCacheService() {
        return  $this->getResolver()->getDi()->getShared('RestCache');
    }

    /**
     * Set current  / created resource uri
     *
     * @param array $response
     * @return RestService
     */
    public function setResourceUri(array $response) {

        $request = $this->getResolver()->getRequest();

        $this->resourceUri =
            (isset($response['meta']['resource']) === false)
        ? $request->getScheme().'://'.$request->getHttpHost().$request->getURI() : $response['meta']['resource'];

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

        $this->message    =   $message;
        $this->getResponseService()->setStatusCode($message['meta']['code'], $message['meta']['message']);
        $this->setResourceUri($message);
        $this->message['meta']['resource'] = $this->getResourceUri();
        $this->message = (APPLICATION_ENV === 'development') ?  $this->debug() : $this->message;

        return $this;
    }

    /**
     * Get user app messages content.
     *
     * @return \StdClass
     */
    public function getMessage() {
        return (object)$this->message;
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
     * Get related mappers
     *
     * @return array
     */
    public function getRelations() {

        $relations = [];
        $rules = $this->getResolver()->getRules();

        if(isset($rules->relations) === true) {
            foreach($rules->relations as $relation => $rule) {
                // if isset rel name in rules ?
                if(isset($this->getParams()[$relation]) === true) {

                    $rule['rel'] = (is_numeric($this->getParams()[$relation]) === true)
                        ? [ current($rule['rel'])   => (int)array_shift($this->getParams()['bind']),
                            key($rule['rel'])       => (int)$this->getParams()[$relation]
                        ] :[
                            current($rule['rel'])   => (int)array_shift($this->getParams()['bind']),
                        ];

                    $relations[$relation] = $rule;
                }
            }
        }

        return $relations;
    }

    /**
     * Get request params
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
     * Get remaining from limited request
     *
     * @return string|int
     */
    private function getRateRemaining() {

        $resolver = $this->getResolver();

        if(isset($resolver->getRules()->requests['limit']) === true) {
            return ($resolver->getRules()->requests['limit']
                -$resolver->getDi()->getShared('session')->get($resolver->getRequest()->getClientAddress())
            );
        }

        return false;
    }

    /**
     * Get developers info
     *
     * @return array
     */
    private function debug() {

        return array_merge(
            $this->message, [
                'debug' => [
                    'memory_use'    => $this->getProfilerService()->getMemoryUsage(),
                    'memory_limit'  => $this->getProfilerService()->getMemoryLimit(),
                    'cpu_load'      => $this->getProfilerService()->getUsageCPU(),
                    'stack'         => $this->getProfilerService()->getStackCalls(),
                    'sql'           => $this->getProfilerService()->getDbProfiler()
                ]
            ]
        );
    }

    /**
     * Send response to client
     *
     * @param boolean $modified
     * @return \Phalcon\Http\ResponseInterface
     */
    public function response() {

        $this->setMessage($this->getResolver()->getResponse());

        $this->setHeader([
            'Access-Control-Allow-Methods'  =>  $this->getResolver()->getRules()->methods,
            'X-Rate-Limit'                  =>  $this->getRateLimit(),
            'X-RateLimit-Remaining'         =>  $this->getRateRemaining(),
            'Content-Language'              =>  $this->getLocale(),
            'Content-Length'                =>  $this->setContentLength($this->getMessage()),
            'X-Resource'                    =>  $this->getResourceUri(),
            'Cache-Control' =>  'max-age='.$this->getCacheService()->getLifetime().', must-revalidate',
            'Expires'       =>  gmdate('D, d M Y H:i:s T', time()+$this->getCacheService()->getLifetime()),
        ]);


        $response = $this->getResponseService();
        $eTag = $this->getCacheService()->getKey();

        if(is_null($eTag) === false) {
            $response->setEtag($eTag);
        }
        $response->setJsonContent($this->getMessage());

        return $response;
    }
}