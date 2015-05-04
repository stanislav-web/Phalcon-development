<?php
namespace Application\Modules\Rest\Controllers;

/**
 * Class ItemsController
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/ItemsController.php
 */
class ItemsController extends ControllerBase {

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
        $this->key   = ($this->request->isGet()) ? md5($this->request->getUri()) : null;
    }

    /**
     * GET Engines action
     */
    public function getAction() {

        $this->response = $this->cache->exists($this->key) ? $this->cache->get($this->key)
            : $this->cache->set(
                $this->getDI()->get('ItemsMapper')->read($this->rest->getParams()),
                $this->key,
                true
            );
    }
}