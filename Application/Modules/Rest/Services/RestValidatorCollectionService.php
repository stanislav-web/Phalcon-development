<?php
namespace Application\Modules\Rest\Services;

use Phalcon\Filter;
use Application\Modules\Rest\Aware\RestValidatorCollectionsProvider;
use Application\Modules\Rest\Validators\QueryValidator;
use Application\Modules\Rest\Validators\ResultSetValidator;

/**
 * Class RestValidatorCollectionService. Rest validator's collections
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/RestValidatorCollectionService.php
 */
class RestValidatorCollectionService extends RestValidatorCollectionsProvider {

    /**
     * Error messages
     *
     * @var array $errors
     */
    private $errors = [];

    /**
     * Request rules
     *
     * @var array $params;
     */
    private $params  = [];

    /**
     * Initialize filter
     * Setup request input parameters
     * Valid all level request by collections
     *
     * @param \Phalcon\Http\Request $request
     * @return RestValidatorCollectionService
     */
    public function filter(\Phalcon\Http\Request $request) {


        $collection = $this->getCollection();
        $this->setParams($request)->setRequest($request);

        foreach($collection as $valid) {
            (new $valid())->run($this->getDi(), $this->getRules(), $this->getParams());
        }

        return $this;
    }

    /**
     * Set possible request params
     *
     * @param \Phalcon\Http\Request $request
     * @return RestValidatorCollectionService
     */
    public function setParams(\Phalcon\Http\Request $request)
    {
        // find primary
        $primary= [];

        if(array_key_exists('id', $this->getDispatcher()->getParams())) {
            $primary = [
                "id = ?0",
                "bind" => [$this->getDispatcher()->getParam('id')],
            ];
        }

        $this->params = $this->filterParams(array_merge(
            $primary,
            $request->get()), ['trim', 'lower']);

        return $this;
    }

    /**
     * Get request params
     *
     * @return array $params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Check if errors exist
     *
     * @return boolean
     */
    public function hasErrors() {

        return (!empty($this->errors));
    }

    /**
     * Set error message
     *
     * @param array|string $errors
     * @return RestValidatorCollectionService
     */
    public function setErrors($errors) {

        $this->errors = $errors;

        return $this;
    }

    /**
     * Get error messages key [errors]
     *
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Filter request params
     *
     * @param array $params
     * @param string $function
     * @example <code>
     *              <?php $this->filterParams($params, ['trim']); ?>
     *          </code>
     */
    public function filterParams(array $params, array $filters)
    {
        $filter = new Filter();

        if(isset($params['_url'])) {
            unset($params['_url']);
        }

        return array_map(function ($value) use ($filter, $filters) {

            foreach ($filters as $func) {
                $value = $filter->sanitize($value, $func);
            }

            return $value;
        }, $params);
    }

    /**
     * Request validator
     *
     * @throws \Application\Modules\Rest\Exceptions\InternalServerErrorException
     */
    public function requestValidate() {

            $request = (new QueryValidator($this->getDi()))
                ->validate($this->getRules(), $this->getParams());

            if($request->hasErrors() === true) {

                $this->setErrors($request->getErrors());
            }
    }

    /**
     * Response validate
     *
     * @param mixed $responseData
     */
    public function responseValidate($responseData) {

        $response = (new ResultSetValidator($responseData))->validate();

        $this->setResponse($response->getResult());
    }
}