<?php
namespace Application\Modules\Rest\V1\Controllers;

/**
 * Class EnginesController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/EnginesController.php
 */
class EnginesController extends ControllerBase {

    /**
     * REST cache container
     *
     * @var \Application\Modules\Rest\Services\RestCacheService $cache
     */
    protected $cache;

    /**
     * Cache key
     *
     * @var string $key
     */
    protected $key;

    /**
     * Initialize cache service
     */
    public function initialize() {

        $this->cache = $this->di->get('RestCache');
        $this->key   = ($this->request->isGet()) ? $this->request->getUri() : null;
    }

    /**
     * GET Engines action
     */
    public function getAction() {

        $this->response = $this->cache->exists($this->key) ? $this->cache->get($this->key)
            : $this->cache->set(
                $this->getDI()->get('EngineMapper')->read($this->rest->getParams()),
                $this->key,
                true
            );
        $this->notModified = $this->cache->isCached();
    }
}