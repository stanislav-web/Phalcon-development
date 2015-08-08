<?php
namespace Application\Services\Advanced;

use \Translate\Translator;

/**
 * Class TranslateService. Locale translate services
 *
 * @package Application\Services
 * @subpackage Advanced
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Advanced/TranslateService.php
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
     * Accepted locales
     *
     * @var array $localeCodes
     */
    protected $localeCodes = [
        'ru'    =>  'ru_RU.utf8',
        'en'    =>  'en_GB.utf8',
        'uk'    =>  'ru_UA.utf8',
    ];

    /**
     * Set chased language
     *
     * @param string $definedLanguage
     * @param string $defaultLanguage
     */
    public function __construct($definedLanguage, $defaultLanguage) {

        $this->translate = (new Translator())->setLanguage($definedLanguage);
        $this->defaultLanguage  =   $defaultLanguage;

        // set localization
        setlocale(LC_ALL, $this->localeCodes[$this->defaultLanguage]);
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