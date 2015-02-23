<?php
namespace Application\Modules\Frontend\Controllers;

use Phalcon\Mvc\View;
use Application\Models\Pages;

/**
 * Class AboutController
 *
 * @package    Application\Modules\Frontend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Frontend/Controllers/AboutController.php
 */
class AboutController extends ControllerBase
{
    /**
     * @var \Application\Models\Pages $page
     */
    private $page;

    /**
     * @var string $title
     */
    private $title;

    /**
     * Initialize internal router
     */
    public function initialize() {

        $dispatch = $this->dispatcher->getActionName();

        $action   =   ($dispatch === 'index') ? 'about' : $dispatch;

        // get page from database
        $this->page = Pages::findFirst([
            "alias = ?0",
            "bind" => [$action]
        ]);

        $this->title    =   ucfirst($this->page->getTitle()).' - '.$this->engine->getName();
        $this->tag->setTitle($this->title);
    }

    /**
     * About action.
     */
    public function indexAction()
    {
        // setup content
        $this->setReply([
            'title'     =>  $this->title,
            'content'   =>  $this->page->getContent(),
        ]);
    }

    /**
     * Help action.
     */
    public function helpAction()
    {
        // setup content
        $this->setReply([
            'title'     =>  $this->title,
            'content'   =>  $this->page->getContent(),
        ]);
    }

    /**
     * Agreement action.
     */
    public function agreementAction()
    {
        // setup content
        $this->setReply([
            'title'     =>  $this->title,
            'content'   =>  $this->page->getContent(),
        ]);
    }

    /**
     * Contacts action.
     */
    public function contactsAction()
    {
        // setup content
        $this->setReply([
            'title'     =>  $this->title,
            'content'   =>  $this->page->getContent(),
        ]);
    }
}

