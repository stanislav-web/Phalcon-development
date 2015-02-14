<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;
use \Translate\Translator;

/**
 * Class TranslateService. Locale translate services
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/TranslateService.php
 */
class TranslateService implements InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Translator
     *
     * @var \Translate\Translator $translate;
     */
    protected $translate;

    /**
     * Set chased language
     *
     * @param string $language
     */
    public function __construct($language) {

        $this->translate = (new Translator())->setLanguage($language);
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
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Define translate path
     *
     * @return null
     */
    public function path($path) {

        $this->translate->setDefault($this->di->get('config')->language)
            ->setTranslatePath($path);

        return $this->translate;
    }
}