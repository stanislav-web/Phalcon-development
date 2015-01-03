<?php
namespace Modules\Backend\Controllers;

use Phalcon\Mvc\View;

/**
 * Class SearchController
 * @package    Backend
 * @subpackage    Modules\Backend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Backend/Controllers/SearchController.php
 */
class SearchController extends ControllerBase
{
    /**
     * Controller name
     * @use for another Controllers to set views , paths
     * @const
     */
    const NAME = 'Search';

    /**
     * Cache key
     * @use for every action
     * @access public
     */
    public $cacheKey = false;

    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();
        $this->tag->setTitle(' - ' . DashboardController::NAME);

        // create cache key
        $this->cacheKey = md5(\Modules\Backend::MODULE . self::NAME . $this->router->getControllerName() . $this->router->getActionName());

        $this->_breadcrumbs->add(DashboardController::NAME, $this->url->get(['for' => 'dashboard']));
    }

    /**
     * Get list of all engines
     * @use \Searcher
     * @return null
     */
    public function indexAction()
    {
        $title = ucfirst(self::NAME);
        $this->tag->prependTitle($title);

        // add crumb to chain (name, link)

        $this->_breadcrumbs->add($title);
        $query = $this->request->get('query', null, null);

        if(isset($query) && $query !== null) {

            // call searcher instance
            $searcher = $this->di->get('searcher');

            try {
                // Prepare models and fields to participate in search
                $searcher->setFields([
                    '\Models\Engines'    =>    [
                        'name',
                        'description',
                        'host',
                    ],
                    '\Models\Categories'    =>    [
                        'title',
                        'description'
                    ],
                    '\Models\Users'    =>    [
                        'login',
                        'name',
                        'surname'
                    ],
                    '\Models\Currency'    =>    [
                        'name'
                    ]
                ])->setQuery($query);

                $result = $searcher->run();

                var_dump($result);
                exit('dsdsdsd');
            }
            catch(\Searcher\ExceptionFactory $e) {
                echo $e->getMessage();
            }

            $this->view->setVar('title', $title. ' "'. $query.'"');

        }
        else {
            $this->view->setVar('title', $title);
        }

        $this->view->setVars([
            'result'=> '',
        ]);

    }
}

