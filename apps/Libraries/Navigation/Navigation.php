<?php
namespace Libraries\Navigation;

/**
 * Navigation builder class
 * @package Phalcon
 * @subpackage Libraries\Navigation
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Libraries/Navigation/Navigation.php
 */
class Navigation
{

    private
        /**
         * Navigation config
         * @var \Phalcon\Config
         */
        $_config = false,

        /**
         * Elements collection
         * @var array
         */
        $_elements = [];

    /**
     * Build navigation tree from internal config file
     *
     * @param \Phalcon\Config $config
     * @access public
     */
    public function __construct($config)
    {
        $this->_config = $config;

        foreach ($this->_config as $navigationName => $conf) {
            // get navigation name [top, bottom, main ... etc]

            $conf->name = $navigationName;
            $this->_elements[$navigationName] = $this->mapNode($conf);
        }
    }

    /**
     * Node mapper (setting up element's attributes)
     *
     * @param \Phalcon\Config $config
     * @access public
     * @return instance of Node
     */
    public function mapNode(\Phalcon\Config $config)
    {
        $node = new Node();
        $allData = (array)$config;

        foreach ($allData as $key => $value) {
            if ($key == 'childs')
                continue;

            $node->{'set' . ucfirst($key)}($value);
        }
        if (isset($config->childs)) {
            $collection = $this->mapCollection($config->childs, $node);
            $node->setChilds($collection);
        }
        return $node;
    }

    /**
     * Collection mapper (assets child's tree)
     *
     * @param \Phalcon\Config $config Phalcon configuration object
     * @param int $parent
     * @access public
     * @return array
     */
    public function mapCollection(\Phalcon\Config $config, $parent = null)
    {
        $collection = [];
        foreach ($config as $nodeConfig) {
            $node = $this->mapNode($nodeConfig);
            $node->setParent($parent);
            $collection[] = $node;
        }
        return $collection;
    }

    /**
     * Generate HTML code
     *
     * @param string $name
     * @access public
     * @return string
     */
    public function toHtml($name)
    {
        return (new Render())->toHtml($this->getNavigation($name));
    }

    /**
     * Get called navigation name
     *
     * @param string $name
     * @access public
     * @return array of elements
     */
    public function getNavigation($name)
    {
        if (!array_key_exists($name, $this->_elements))
            return null;
        return $this->_elements[$name];
    }

    /**
     * Set active node in all navigation collections.
     *
     * @param mixed $action
     * @param mixed $controller
     * @param mixed $module
     * @return void
     */
    public function setActiveNode($action, $controller, $module)
    {

        // deactivate all elements by default
        $this->deactivateNodes();

        foreach ($this->_elements as $navigation) {
            $this->_activeCollection($navigation->getChilds(), $action, $controller, $module);
        }
    }

    /**
     * Deactivate all nodes in all collections
     *
     * @access public
     * @return null
     */
    public function deactivateNodes()
    {
        foreach ($this->_elements as $navigation) {
            $this->_deactivateCollection($navigation);
        }
    }

    /**
     * Deactivate all nodes in collection
     *
     * @param Node $collection
     * @access public
     * @return null
     */
    private function _deactivateCollection(Node $collection)
    {
        foreach ($collection as $node) {
            $node->setActive(false);
            if ($node->hasChilds())
                $this->dissactiveCollection($node->getChilds());
        }
    }

    /**
     * Activate node collection.
     *
     * @param mixed $collection
    f	 * @param mixed $action
     * @param mixed $controller
     * @param mixed $module
     * @access public
     * @return void
     */
    public function _activeCollection($collection, $action, $controller, $module)
    {
        foreach ($collection as $node) {
            if ($node->getAction() == $action && $node->getController() == $controller)
                $this->_activateNode($node);

            if ($node->hasChilds())
                $this->_activeCollection($node->getChilds(), $action, $controller, $module);
        }
    }

    /**
     * Activate node
     *
     * @param type $node
     * @access public
     * @return void
     */
    private function _activateNode($node)
    {
        $node->setActive(true);

        if (!is_null($node->getParent()))
            $this->_activateNode($node->getParent());
    }
}