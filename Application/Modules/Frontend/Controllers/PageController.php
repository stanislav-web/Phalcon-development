<?php
namespace Application\Modules\Frontend\Controllers;

use Phalcon\Mvc\View;

/**
 * Class PageController
 *
 * @package    Application\Modules\Frontend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Frontend/Controllers/PageController.php
 */
class PageController extends ControllerBase
{
    /**
     * Resolve dynamic routes action
     */
    public function resolveAction()
    {
        $params = $this->router->getParams();

        $action   =   (isset($params[0]) === true) ? $params[0] : 'about';

        $page = $this->getDI()->get('PageMapper');

        $row = $page->read(null, [
            "alias = ?0",
            "bind" => [$action]
        ], 1);

        if($row) {

            $title    =   ucfirst($row->getTitle()).' - '.$this->engine->getName();
            $this->tag->setTitle($title);

            // setup content
            $this->setReply([
                'title'     =>  $title,
                'content'   =>  $row->getContent(),
            ]);
        }
        else {

            // not found dynamic page
            $this->response->setStatusCode(404, 'Not Found')->send();
        }
    }
}

