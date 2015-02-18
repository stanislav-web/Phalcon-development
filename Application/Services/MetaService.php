<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;

/**
 * Class MetaService. Actions above application meta view
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/MetaService.php
 */
class MetaService  implements InjectionAwareInterface
{
    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Page title
     *
     * @var string $title;
     */
    protected $title;

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
     * Helper Service
     *
     * @var \Application\Services\HelpersService $tag;
     */
    protected $tag = null;

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
     * @param string $baseTitle
     * @return MetaService
     */
    public function setBaseTitle($baseTitle, $delimiter = ' - ')
    {
        $this->getTag()->setTitle($delimiter . $baseTitle);

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
    public function setTitle($title)
    {

        $this->title = (empty($this->getTag()->getTitle()) === true) ?
            $this->getTag()->setTitle($this->baseTitle) :
                $this->getTag()->prependTitle(ucfirst($title));

        return $this;
    }
}