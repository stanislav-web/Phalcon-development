<?php
namespace Application\Services\Advanced;

use \Phalcon\Tag;

/**
 * Class HelpersService. Joined all of my helpers together
 *
 * @package Application\Services
 * @subpackage Advanced
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Advanced/HelpersService.php
 */
class HelpersService extends Tag {

    use \Application\Helpers\Format;
    use \Application\Helpers\Node;
}