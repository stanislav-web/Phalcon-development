<?php
namespace Application\Services\Views;

use \Phalcon\DI\InjectionAwareInterface;
use \Phalcon\Assets\Filters\Jsmin;

/**
 * Class AssetsService. Actions above application front content
 *
 * @package Application\Services
 * @subpackage Views
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Views/AssetsService.php
 */
class AssetsService implements InjectionAwareInterface
{
    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Engine model
     *
     * @var \Application\Models\Engines $engine;
     */
    protected $engine;

    /**
     * Assets Collection Manager
     *
     * @var \Phalcon\Assets\Collection $collection;
     */
    protected $collection;

    /**
     * Init Engine params
     *
     * @param \Application\Models\Engines $engine
     */
    public function __construct(\Application\Models\Engines $engine) {
        $this->setEngine($engine);
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
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Get Engine object
     *
     * @return \Application\Models\Engines
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Get assets collection
     *
     * @return \Phalcon\Assets\Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Setup collection object
     *
     * @param \Phalcon\Assets\Collection $collection
     * @return AssetsService
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
        return $this;
    }

    /**
     * Set engine object
     *
     * @param \Application\Models\Engines $engine
     * @return AssetsService
     */
    public function setEngine(\Application\Models\Engines $engine)
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * Get assets manager
     *
     * @return \Phalcon\Assets\Manager
     */
    public function getAssets()
    {
        return $this->getDi()->get('assets');
    }

    /**
     * Get configuration
     *
     * @return \Phalcon\Config
     */
    public function getConfig()
    {
        return $this->getDi()->get('config')->assets;
    }

    /**
     * Define all frontend sources
     */
    public function define() {

        $config =  $this->getConfig()->toArray();

        foreach($config as $type => $collection) {

            foreach($collection as $key => $resources) {
                // create collection

                $this->setCollection($this->getAssets()->collection($key));

                if($type === 'css') {

                    array_map(function($resource) {

                        $this->getCollection()->addCss(strtr($resource, [':engine' => strtolower($this->getEngine()->getCode())]))->setAttributes(['media' => 'all']);
                    }, $resources);
                }
                else {

                    array_map(function($resource) {

                        $this->getCollection()->addJs(strtr($resource, [':engine' => strtolower($this->getEngine()->getCode())]));
                    }, $resources);

                    if (APPLICATION_ENV === 'production') {
                        $this->minify($key);
                    }
                }
            }
        }
    }

    /**
     * Minimize params
     *
     * @param string $key
     */
    public function minify($key) {

        $this->collection->join(true);
        $this->collection->addFilter(new Jsmin());
        $this->collection->setTargetPath('assets/frontend/'.strtolower($this->getEngine()->getCode()).'/'.$key.'.min.js');
        $this->collection->setTargetUri('assets/frontend/'.strtolower($this->getEngine()->getCode()).'/'.$key.'.min.js');
    }

}