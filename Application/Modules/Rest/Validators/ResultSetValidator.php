<?php
namespace Application\Modules\Rest\Validators;

use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Resultset\Simple as ResultSet;
use Phalcon\Mvc\Model\MetaData\Apc as MetaData;

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
    const CODE_NO_CONTENT       = 204;
    const CODE_NOT_MODIFIED     = 304;
    const MESSAGE_OK            = '0K';
    const MESSAGE_CREATED       = 'Created';
    const MESSAGE_NO_CONTENT    = 'No Content';
    const MESSAGE_NOT_MODIFIED  = 'Not Modified';

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

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
     * Setup definition
     *
     * @param \Phalcon\Di\FactoryDefault $di
     */
    public function __construct(\Phalcon\Di\FactoryDefault $di) {

        $this->setDi($di);
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     * @return QueryValidator
     */
    public function setDi($di)
    {
        $this->di = $di;

        return $this;
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
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
     * Return Primary key of result
     *
     * @return mixed
     */
    public function getPrimaryKey() {

        $meta = new MetaData();
        $key = $meta->getPrimaryKeyAttributes($this->getResponse()->getFirst());
        $value = $this->getResponse()->getFirst()->readAttribute(reset($key));
        return $value;
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

        $request = new Request();


        if($request->isPost()) {
            $result['code'] = self::CODE_CREATED;
            $result['message'] = self::MESSAGE_CREATED;

            // make replace url form config redirects

            if(isset($this->getRedirects()[$this->getRequestUri()]) === true) {

                $result['resource'] = $request->getScheme().'://'.
                    $request->getHttpHost().$this->getRedirects()[$this->getRequestUri()].DIRECTORY_SEPARATOR.$this->getPrimaryKey();
            }
            else {
                $result['resource'] = $request->getScheme().'://'.$request->getHttpHost().$request->getURI().DIRECTORY_SEPARATOR.$this->getPrimaryKey();
            }
        }
        elseif($request->isGet() || $request->isPut()) {
            $result['code'] = self::CODE_OK;
            $result['message'] = self::MESSAGE_OK;
        }
        else {
            $result['code'] = self::CODE_NO_CONTENT;
            $result['message'] = self::MESSAGE_NO_CONTENT;
        }

        if($this->getResponse() instanceof ResultSet) {

            //@TODO Resolve response from relations
            //var_dump($this->getResponse()->toArray()); exit;

            // result Set from GET, POST
            $result['limit']   = $this->getResponse()->count();
            $response = $this->getResponse()->toArray();
            $this->result = (array_merge($result, ['data' => $response]));
        }
        else {
            $this->result = $result;
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
     * @param mixed $response
     * @return ResultSetValidator
     */
    public function validate($response)
    {
        $this->setResponse($response)->setResult();
    }


    /**
     * Get redirects params
     *
     * @return \Phalcon\Config
     */
    private function getRedirects() {
        return $this->getDI()->get('RestConfig')->api->redirects->toArray();
    }

    /**
     * Get requested Uri
     *
     * @return string uri
     */
    private function getRequestUri() {
        return $this->getDI()->get('request')->getUri();
    }
}