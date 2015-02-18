<?php
namespace Application\Services;

use \Phalcon\Tag;

/**
 * Class HelpersService. Joined all of my helpers together
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/HelpersService.php
 */
class HelpersService extends Tag {

    use \Application\Helpers\Format;
    use \Application\Helpers\Node;
}