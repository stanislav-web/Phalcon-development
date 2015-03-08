<?php
namespace Application\Services\Advanced;

use \Phalcon\DI\InjectionAwareInterface;
use Phalcon\Http\Request;

/**
 * Class LanguageService. Language definition service
 *
 * @package Application\Services
 * @subpackage Advanced
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Advanced/LanguageService.php
 */
class LanguageService implements InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Preferred Language
     *
     * @var string $language;
     */
    protected $language = 'en';

    /**
     * Default cookie / session key to keep language code
     *
     * @var string
     */
    protected $key = 'NG_TRANSLATE_LANG_KEY';

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
     * Define preferred language
     *
     * @return null
     */
    public function define(\Phalcon\DiInterface $di, $language = null) {

        $this->setDi($di);

        if($language !== null) {
            $this->language = $language;
        }
        else {
            $this->getCookieLanguage() !== false ? $this->language :  $this->getHttpLanguage();
        }

        return $this->language;
    }

    /**
     * Set cookie language key
     *
     * @param string $key
     * @return LanguageService
     */
    public function setKey($key) {
        $this->key  =   $key;

        return $this;
    }

    /**
     * Get language key from cookies
     *
     * @return bool
     */
    public function getCookieLanguage() {

        $cookies = $this->di->getShared('cookies');

        if($cookies->has($this->key) === true) {

            $this->language = $_COOKIE[$this->key];
        }
        else {
            return false;
        }
    }

    /**
     * Get language key from http headers
     *
     * @return string
     */
    public function getHttpLanguage() {

        $request = (new Request())->getBestLanguage();
        if(empty($request) === false) {

            $this->language = substr((new Request())->getBestLanguage(), 0, 2);
        }
        else {
            return false;
        }
    }
}