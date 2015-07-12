<?php
namespace Application\Models;

/**
 * Class Logs `logs`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/Logs.php
 */
class Logs extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     *
     * @const
     */
    const TABLE = '\Application\Models\Logs';

    /**
     * Content assign definition rules
     *
     * @const
     */
    const CONTENT_DEFINITION_PARAMS = ['exception', 'ip', 'refer', 'method', 'uri', 'message'];

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var string
     */
    public $content;

    /**
     * Initialize Model
     */
    public function initialize()
    {
        // its allow to keep empty data to my db
        $this->setup(['notNullValidations' => false]);
    }
}
