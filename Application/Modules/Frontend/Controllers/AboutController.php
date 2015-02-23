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

        var_dump($this->page); exit;
    }

    /**
     * About action.
     */
    public function indexAction()
    {
        // setup content
        $this->setReply([
            'title'     =>  ucfirst($this->page->getTitle()).' - '.$this->engine->getName(),
            'content'   =>  $this->page->getContent(),
        ]);
    }

    /**
     * Static pages action.
     */
    public function staticAction()
    {
        // get page to display - param
        $param = $this->dispatcher->getParam('page');
        if($param !== null) {
            // get page from database
            $page = Pages::findFirst([
                "alias = ?0",
                "bind" => [$param]
            ]);
            if($page !== null) {
                // setup title
                $this->tag->prependTitle(ucfirst($page->getTitle()).' - ');
                // setup content
                $this->setReply([
                    'title'     =>  ucfirst($page->getTitle()).' - '.$this->engine->getName(),
                    'content'   =>  $page->getContent(),
                ]);
            }
        }
        // send response
        if($this->request->isAjax() === true) {
            return $this->getReply();
        }
    }
}

