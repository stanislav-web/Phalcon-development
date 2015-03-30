<?php
namespace Application\Modules\Rest\Services;

/**
 * Class RestService. Http Rest handler
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/RestExceptionHandler.php
 */
class RestExceptionHandler {

    /**
     * Dependency Container
     *
     * @var \Phalcon\Di\FactoryDefault $di
     */
    private $di;

    /**
     * Exception data
     *
     * @var \Exception $exception
     */
    private $exception;

    /**
     * Init DI
     *
     * @param \Phalcon\Di\FactoryDefault $di
     */
    public function __construct(\Phalcon\Di\FactoryDefault $di) {
        $this->setDi($di);
    }

    /**
     * Get Dependency container
     *
     * @return \Phalcon\Di\FactoryDefault
     */
    private function getDi()
    {
        return $this->di;
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\Di\FactoryDefault $di
     * @return RestExceptionHandler
     */
    private function setDi($di)
    {
        $this->di = $di;
        return $this;
    }

    /**
     * Handle exception data
     *
     * @param \Exception $data
     */
    public function handle(\Exception $exception) {
        $this->setException($exception);

        return $this;
    }

    /**
     * Get request service
     *
     * @return \Phalcon\Http\Request
     */
    private function getRequest() {
        return $this->getDi()->get('request');
    }

    /**
     * Get response service
     *
     * @return \Phalcon\Http\Response
     */
    private function getResponse() {
        return $this->getDi()->get('response');
    }

    /**
     * Get log mapper
     *
     * @return \Application\Services\Mappers\LogMapper
     */
    private function getLogger() {
        return $this->getDi()->get('LogMapper');
    }

    /**
     * Get exception data
     * @return array
     */
    private function getException()
    {
        return $this->exception;
    }

    /**
     * Set exception data
     *
     * @param \Exception $exception
     * @return RestExceptionHandler
     */
    private function setException(\Exception $exception)
    {
        // set exception code
        $this->exception['code'] = $exception->getCode();

        // set resource
        $this->exception['resource'] = $this->getRequest()->getURI();

        if($this->isJson($exception->getMessage())) {

            $exception = json_decode($exception->getMessage(), true);
            $this->exception['message'] = $exception['data']['message'];
            if(isset($exception['data']['exception']) === true) {

                //@TODO can be translated
                $this->exception['data'] = $exception['data']['exception'];
            }
        }
        else
        {
            $this->exception['message'] = $exception->getMessage();
        }
        return $this;
    }

    private function isJson($string) {
            return ((is_string($string) &&
                (is_object(json_decode($string)) ||
                    is_array(json_decode($string))))) ? true : false;
    }

    public function send() {

        $e = $this->getException();

        $this->getResponse()->setContentType('application/json', 'utf-8')
            ->setStatusCode($e['code'], $e['message'])
            ->setJsonContent(['error' => $e])->send();
    }
}