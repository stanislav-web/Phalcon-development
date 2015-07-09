<?php
namespace Application\Helpers;

/**
 * OriginPrelight class. Prelight OPTIONS Requests
 *
 * @package Application
 * @subpackage Helpers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Helpers/OriginPrelight.php
 */
class OriginPreflight {

    /**
     * Check is request is Options ?
     *
     * @return bool
     */
    public static function isOptions()
    {
        if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            return true;
        }
        return false;
    }

    /**
     * Allow Origin Requests
     *
     * @return null
     */
    public static function allowRequest()
    {
        // return only the headers and not the content
        // only allow CORS if we're doing a GET - i.e. no saving for now.
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])
            && isset($_SERVER['HTTP_ORIGIN'])) {

            header('Access-Control-Allow-Methods: POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Accept, Authorization, X-Requested-With, Content-Type, Accept-Language, origin');
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            header('Access-Control-Max-Age: 3600');
        }
        exit;
    }
}