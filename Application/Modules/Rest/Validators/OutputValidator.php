<?php
namespace Application\Modules\Rest\Validators;

use Phalcon\Http\Request;
use Application\Helpers\Node;

/**
 * Class OutputValidator. Checking response
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/OutputValidator.php
 */
class OutputValidator {

    const CODE_OK               = 200;
    const CODE_CREATED          = 201;
    const CODE_NO_CONTENT       = 204;
    const CODE_NOT_MODIFIED     = 304;
    const MESSAGE_OK            = '0K';
    const MESSAGE_CREATED       = 'Created';
    const MESSAGE_NO_CONTENT    = 'No Content';
    const MESSAGE_NOT_MODIFIED  = 'Not Modified';

    /**
     * Rest config container
     *
     * @var \Phalcon\Config $config;
     */
    private $config;

    /**
     * Resultset response definition
     *
     * @var \Application\Aware\AbstractDTO|null $response
     */
    private $response;

    /**
     * Result definition
     *
     * @var array $result
     */
    private $result = [];

    /**
     * Setup definition
     *
     * @param \Phalcon\Config $config
     */
    public function __construct(\Phalcon\Config $config) {

        $this->setConfig($config);
    }

    /**
     * Set config container
     *
     * @param \Phalcon\Config $config
     * @return OutputValidator
     */
    public function setConfig(\Phalcon\Config $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config container
     *
     * @param \Phalcon\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set response set
     *
     * @param \Application\Aware\AbstractDTO|null $response
     * @return OutputValidator
     */
    private function setResponse($response = null)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get hydrated response object
     *
     * @return \Application\Aware\AbstractDTO
     */
    private function getResponse()
    {
        return $this->response;
    }

    /**
     * Set result set
     *
     * @return OutputValidator
     */
    private function setResult()
    {
        $request = $this->getRequest();

        ($request->isGet()) ? $this->getResolver() : null;
        ($request->isPost()) ? $this->postResolver($request) : null;
        ($request->isPut()) ? $this->putResolver() : null;
        ($request->isDelete()) ? $this->deleteResolver() : null;

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
     *
     * @param mixed $response
     * @return OutputValidator
     */
    public function validate($response)
    {
        $this->setResponse($response)->setResult();
    }

    /**
     * Get redirects params
     *
     * @return array
     */
    private function getRedirects() {
        return $this->getConfig()->redirects->toArray();
    }

    /**
     * Get Request object
     *
     * @return \Phalcon\Http\Request
     */
    private function getRequest() {
        return new Request();
    }

    /**
     * Resolve & parse GET Response
     *
     * @param \Phalcon\Http\Request $request
     */
    private function getResolver() {

        $result = [];
        $result['meta']['code'] = self::CODE_OK;
        $result['meta']['message'] = self::MESSAGE_OK;
        $result['meta']['request_time'] = time();

        $response = array_filter($this->getResponse()->toArray());

        if(count($response) > 1) {

            $entities = array_keys($response);

            foreach($response as $entity => &$data) {

                if(isset($data['limit']) === true) $result['meta'][$entity]['limit'] = $data['limit'];
                if(isset($data['total']) === true) $result['meta'][$entity]['total'] = $data['total'];
                if(isset($data['offset']) === true) $result['meta'][$entity]['offset'] = $data['offset'];

                unset($data['limit'], $data['total'], $data['offset']);

                if(count($response[$entity]) === 1) {
                    $response[$entity] = array_shift($response[$entity]);
                }
            }
        }
        else {

            $response = array_shift($response);

            $result['meta']['limit'] = $response['limit'];
            $result['meta']['total'] = $response['total'];
            $result['meta']['offset'] = $response['offset'];
            unset($response['limit'], $response['total'], $response['offset']);
            if(count($response) === 1) {
                $response = array_shift($response);
            }
        }

        $this->result = (array_merge($result, ['data' => $response]));
    }

    /**
     * Resolve & parse POST Response
     *
     * @param \Phalcon\Http\Request $request
     */
    private function postResolver(\Phalcon\Http\Request $request) {

        $result = [];
        $result['meta']['code'] = self::CODE_CREATED;
        $result['meta']['message'] = self::MESSAGE_CREATED;
        $result['meta']['request_time'] = time();

        // make replace url form config redirects

        if(isset($this->getRedirects()[$request->getURI()]) === true) {

            $result['meta']['resource'] = $request->getScheme().'://'.
                $request->getHttpHost().$this->getRedirects()[$request->getURI()].DIRECTORY_SEPARATOR.$this->getResponse()->getPrimary();
        }
        else {
            $result['meta']['resource'] = $request->getScheme().'://'.$request->getHttpHost().
                $request->getURI().DIRECTORY_SEPARATOR.$this->getResponse()->getPrimary();
        }

        $response = array_filter($this->getResponse()->toArray());

        $data = [];

        if(Node::isNestedArray($response) === true) {
            foreach($response as $entity => $params) {
                $data[$entity] = array_shift($params);
            }
        }
        else {
            $data = $response;
        }

        $this->result = (array_merge($result, ['data' => $data]));
    }

    /**
     * Resolve & parse PUT Response
     */
    private function putResolver() {

        $result = [];
        $result['meta']['code'] = self::CODE_OK;
        $result['meta']['message'] = self::MESSAGE_OK;
        $result['meta']['request_time'] = time();

        if(is_bool($this->getResponse()) === true) {
            $this->result = $result;
        }
        else {
            $response = array_filter($this->getResponse()->toArray());
            $this->result = (array_merge($result, ['data' => $response]));
        }
    }

    /**
     * Resolve & parse DELETE Response
     */
    private function deleteResolver() {
        $result = [];
        $result['meta']['code'] = self::CODE_NO_CONTENT;
        $result['meta']['message'] = self::MESSAGE_NO_CONTENT;
        $this->result = $result;
    }
}