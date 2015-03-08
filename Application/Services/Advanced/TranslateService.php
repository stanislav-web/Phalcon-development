<?php
namespace Application\Services\Advanced;

use \Translate\Translator;

/**
 * Class TranslateService. Locale translate services
 *
 * @package Application\Services
 * @subpackage Advanced
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Adcanced/TranslateService.php
 */
class TranslateService {

    /**
     * Default language
     *
     * @var string $defaultLanguage;
     */
    protected $defaultLanguage;

    /**
     * Translator
     *
     * @var \Translate\Translator $translate;
     */
    protected $translate;

    /**
     * Set chased language
     *
     * @param string $definedLanguage
     * @param string $defaultLanguage
     */
    public function __construct($definedLanguage, $defaultLanguage) {

        $this->translate = (new Translator())->setLanguage($definedLanguage);
        $this->defaultLanguage  =   $defaultLanguage;
    }

    /**
     * Define translate path
     *
     * @return null
     */
    public function path($path) {

        $this->translate->setDefault($this->defaultLanguage)
            ->setTranslatePath($path);

        return $this->translate;
    }
}