<?php
namespace Libraries\Navigation;

/**
 * Node elements class
 * @package Phalcon
 * @subpackage Libraries\Navigation
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Libraries/Node.php
 */
class Node
{


    protected
        /**
         * Css class name
         * @var string
         */
        $class,

        /**
         * Node name
         * @var string
         */
        $name,

        /**
         * Css id name
         * @var string
         */
        $id,

        /**
         * Module name
         * @var string
         */
        $module,

        /**
         * Controller name
         * @var string
         */
        $controller,

        /**
         * Action name
         * @var string
         */
        $action,

        /**
         * Url name
         * @var string
         */
        $url,

        /**
         * target html element
         * @var string
         */
        $target,

        /**
         * Parents node
         * @var \Libraries\Navigation\Node
         */
        $parent,

        /**
         * Class Link
         * @var \Libraries\Navigation\Node
         */
        $classLink,

        /**
         * Onclick JS
         * @var \Libraries\Navigation\Node
         */
        $click,

        /**
         * Icon class
         * @var \Libraries\Navigation\Node
         */
        $icon,

        /**
         * isActive node flag
         * @var bool
         */
        $isActive = false,

        /**
         * Node's childs
         * @var array
         */
        $childs = [];


    /**
     * Get css class name
     * @access public
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set css class name
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setClass($value)
    {
        $this->class = $value;
        return $this;
    }

    /**
     * Get node name
     * @access public
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get css id name
     * @access public
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get controller name
     * @access public
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Get controller name
     * @access public
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Get action name
     * @access public
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * get Url
     * @access public
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get html target
     * @access public
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Get parents node
     * @access public
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get class link
     * @access public
     * @return string
     */
    public function getClassLink()
    {
        return $this->classLink;
    }

    /**
     * Get onclick attribute
     * @access public
     * @return string
     */
    public function getClick()
    {
        return $this->click;
    }

    /**
     * Get icon link
     * @access public
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set node name
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * Set css id name
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Set module name
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setModule($value)
    {
        $this->module = $value;
        return $this;
    }

    /**
     * Set controller name
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setController($value)
    {
        $this->controller = $value;
        return $this;
    }

    /**
     * Set action name
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setAction($value)
    {
        $this->action = $value;
        return $this;
    }

    /**
     * Set url
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setUrl($value)
    {
        $this->url = $value;
        return $this;
    }

    /**
     * Set html target
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setTarget($value)
    {
        $this->target = $value;
        return $this;
    }

    /**
     * Set Parent
     * @param \Libraries\Navigation\Node $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setParent($value)
    {
        $this->parent = $value;
        return $this;
    }

    /**
     * Set class link
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setClassLink($value)
    {
        $this->classLink = $value;
        return $this;
    }

    /**
     * Set onclick JS
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setClick($value)
    {
        $this->click = $value;
        return $this;
    }

    /**
     * Set icon link
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setIcon($value)
    {
        $this->icon = $value;
        return $this;
    }

    /**
     * Set active flag
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setActive($value)
    {
        $this->isActive = $value;
        return $this;
    }

    /**
     * Set childs
     * @param string $value
     * @access public
     * @return \Libraries\Navigation\Node
     */
    public function setChilds($value)
    {
        $this->childs = $value;
        return $this;
    }

    /**
     * Is node active?
     * @access public
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * Has node any childs
     * @access public
     * @return bool
     */
    public function hasChilds()
    {
        return 0 < count($this->getChilds());
    }

    /**
     * Get node childs
     * @access public
     * @return array
     */
    public function getChilds()
    {
        return $this->childs;
    }
}