<?php
namespace Application\Modules\Rest\Services;

use Phalcon\Filter;
use Application\Modules\Rest\Aware\RestValidatorCollectionsProvider;
use Application\Modules\Rest\Validators\InputValidator;
use Application\Modules\Rest\Validators\OutputValidator;

/**
 * Class RestValidatorCollectionService. Rest validator's collections
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/RestValidatorCollectionService.php
 */
class RestValidatorCollectionService extends RestValidatorCollectionsProvider {

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
        $dispatchParams = $this->getDispatcher()->getParams();
        if(array_key_exists('id', $dispatchParams)) {
            $primary = [
                "id = ?0",
                "bind" => [$dispatchParams['id']],
            ];

            unset($dispatchParams['id']);
        }

        $data = ($request->isPut()) ? array_merge($request->getPut(), $request->get()) : $request->get();

        $this->params = $this->filterParams(array_merge(
            $primary, $dispatchParams, $data), ['trim']);

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
    public function validate() {
        $qv = new InputValidator($this->getDi());

        $qv->validate($this->getRules(), $this->getParams());
    }

    /**
     * Response resolver
     *
     * @param mixed $responseData
     */
    public function resolve($responseData) {

        if($this->getDi()->get('config')->cache->code === true) {

            // caching response from validator
            $key = md5(serialize($responseData));
            $cache = $this->getDi()->get('OpcodeCache');

            if($cache->exists($key) === true) {
                $result = $cache->get($key);
            }
            else {

                $rs = new OutputValidator($this->getConfig());
                $rs->validate($responseData);
                $result = $rs->getResult();

                $cache->set($result, $key, true);
            }
        }
        else {

            $rs = new OutputValidator($this->getConfig());
            $rs->validate($responseData);
            $result = $rs->getResult();
        }

        $this->setResponse($result);
    }
}