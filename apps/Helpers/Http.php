<?php
namespace Helpers;
use Phalcon\Tag;
use Phalcon\Http\Request;

/**
 * Helper Http. Work with http headers
 * @package Phalcon
 * @subpackage Helpers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Helpers/Http.php
 */
class Http extends Tag
{

    /**
     * Get preferred or selected language
     *
     * @param null|string $cookieKey
     * @return string
     */
    public static function getLanguage($cookieKey = null)
    {
        // get cookies
        $cookies = \Phalcon\DI::getDefault()->getShared('cookies');

        if($cookieKey !== null) {

            if($cookies->has($cookieKey)) {

                $language = $_COOKIE[$cookieKey];
            }
        }
        else {
            $language = substr((new Request())->getBestLanguage(), 0, 2);
        }

        return $language;
    }
}