<?php
namespace Application\Services\Views;

use \Phalcon\DI\InjectionAwareInterface;
use \Application\Plugins\Breadcrumbs\Breadcrumbs;

/**
 * Class MetaService. Actions above application meta view
 *
 * @package Application\Services
 * @subpackage Views
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Views/MetaService.php
 */
class MetaService implements InjectionAwareInterface
{
    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Page title (home)
     *
     * @var string $homeTitle;
     */
    protected $homeTitle;

    /**
     * Page title
     *
     * @var string $title;
     */
    protected $title;

    /**
     * Home link spot
     *
     * @var string $homelink;
     */
    protected $homelink;

    /**
     * Meta keywords
     *
     * @var string $keywords;
     */
    protected $keywords;

    /**
     * Meta description
     *
     * @var string $description;
     */
    protected $description;

    /**
     * Breadcrumbs Chain
     *
     * @var Breadcrumbs $breadcrumbs;
     */
    protected $breadcrumbs;

    /**
     * Helper Service
     *
     * @var \Application\Services\HelpersService $tag;
     */
    protected $tag = null;

    /**
     * @return string
     */
    public function getHomelink()
    {
        return $this->homelink;
    }

    /**
     * @param string $homelink
     * @return MetaService
     */
    public function setHomelink($homelink)
    {
        $this->homelink = $homelink;

        $this->setBreadcrumbs();
        return $this;
    }

    /**
     * @return HelpersService
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param HelpersService $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
        $this->setTag($this->getDi()->get('tag'));
    }

    /**
     * Get dependency container
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * @param string $homeTitle
     * @return MetaService
     */
    public function setHomeTitle($homeTitle)
    {
        $this->homeTitle    =   $homeTitle;
        $this->getTag()->setTitle($homeTitle);

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return MetaService
     */
    public function setDescription($description = '')
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     * @return MetaService
     */
    public function setKeywords($keywords = '')
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return MetaService
     */
    public function setTitle($title, $delimiter = ' - ')
    {
        $this->title = ucfirst($title);

        (empty($this->getTag()->getTitle()) === true) ?
            $this->getTag()->setTitle($this->homeTitle) : ($this->homeTitle != $this->title ?
                $this->getTag()->prependTitle($this->title.$delimiter): '');

        $this->getDi()->getShared('view')->setVar('title', $this->title);

        return $this;
    }

    /**
     * Set breadcrumbs home spot start
     *
     * @param Breadcrumbs $breadcrumbs
     * @return MetaService
     */
    public function setBreadcrumbs()
    {
        $this->breadcrumbs = (new Breadcrumbs())->add($this->homeTitle, $this->getHomelink());

        return $this;
    }

    /**
     * Get breadcrumbs
     *
     * @return Breadcrumbs
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }
}