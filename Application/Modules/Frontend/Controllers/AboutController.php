<?php
namespace Application\Modules\Frontend\Controllers;

use Phalcon\Mvc\View;

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
     * Resolve dynamic routes action
     */
    public function resolveAction()
    {
        $params = $this->router->getParams();

        $action   =   (isset($params[0]) === true) ? $params[0] : 'about';

        $pageService = $this->getDI()->get('PageService');

        $page = $pageService->read(null, [
            "alias = ?0",
            "bind" => [$action]
        ], 1);

        $title    =   ucfirst($page->getTitle()).' - '.$this->engine->getName();
        $this->tag->setTitle($title);

        // setup content
        $this->setReply([
            'title'     =>  $title,
            'content'   =>  $page->getContent(),
        ]);
    }
}

