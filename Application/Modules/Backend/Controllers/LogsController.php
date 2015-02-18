<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\Logs;
use Phalcon\Mvc\View;

/**
 * Class LogsController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/LogsController.php
 */
class LogsController extends ControllerBase
{
    /**
     * Controller name
     *
     * @use for another Controllers to set views , paths
     * @const
     */
    const NAME = 'Logs';

    /**
     * Cache key
     *
     * @use for every action
     * @access public
     */
    public $cacheKey = false;

    /**
     * is Json ?
     * @var bool
     */
    private $isJsonResponse = false;

    /**
     * initialize() Initialize constructor
     *
     * @access public
     * @return null
     */
    public function initialize()
    {

        parent::initialize();
        $this->tag->setTitle(' - ' . DashboardController::NAME);

        // create cache key
        $this->cacheKey = md5(\Application\Modules\Backend::MODULE . self::NAME . $this->router->getControllerName() . $this->router->getActionName());

        $this->breadcrumbs->add(DashboardController::NAME, $this->url->get(['for' => 'dashboard']));
    }

    /**
     * Get list of all pages
     *
     * @return null
     */
    public function indexAction()
    {
        $title = ucfirst(self::NAME);
        $this->tag->prependTitle($title);

        // add crumb to chain (name, link)

        $this->breadcrumbs->add($title);
        $this->view->setVars([
            'title' => $title,
        ]);

        if ($this->request->isPost()) {
            // what kind of content type will be represented ?
            $this->setJsonResponse();

            // get records

                $dataTable = $this->di->get('DataService', [new Logs(), 0, 10])->hydrate();

                $rows = $dataTable->jsonFromObject();

            var_dump($rows); exit;
        }
    }

    /**
     * setJsonResponse() set json mode
     * @access protected
     * @return null
     */
    private function setJsonResponse()
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
    }
}

