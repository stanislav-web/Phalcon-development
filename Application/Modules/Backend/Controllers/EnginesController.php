<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\Currency;
use Application\Models\Engines;
use Application\Modules\Backend\Forms;
use Phalcon\Mvc\View;

/**
 * Class EnginesController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/EnginesController.php
 */
class EnginesController extends ControllerBase
{
    /**
     * @const Basic virtual dir name
     */
    const NAME = 'Engines';

    /**
     * Initialize constructor
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Get list of engines action
     */
    public function indexAction() {
        $this->setBreadcrumbs()->add(self::NAME);

        $engines = (new Engines())->get();

        $this->view->setVars([
            'items' => $engines,
            'statuses' => Engines::$statuses
        ]);
    }

    /**
     * Delete engine action
     */
    public function deleteAction()
    {
        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->forward();
        }

        $engineService = $this->getDI()->get('EngineService');

        if($engineService->deleteEngine($params['id']) === true) {
            $this->flashSession->success('The engine #'.$params['id'].' was successfully deleted');
        }
        else {

            // the store failed, the following message were produced
            foreach($engineService->getErrors() as $message) {
                $this->flashSession->error((string)$message);
            }
        }

        return $this->forward();
    }

    /**
     * Add engine action
     */
    public function addAction() {

        // handling POST data
        if ($this->request->isPost()) {

            $engineService = $this->getDI()->get('EngineService');

            if($engineService->addEngine($this->request->getPost()) === true) {
                $this->flashSession->success('The engine was successfully added!');
            }
            else {

                // the store failed, the following message were produced
                foreach($engineService->getErrors() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            return $this->forward();
        }
        else {
            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'engines']))->add('Add');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Add',
                'form' => (new Forms\EngineForm(null, [
                    'currency' => Currency::find([
                        "columns" => "id, name"
                    ]),
                ]))
            ]);
        }
    }

    /**
     * Edit engine action
     */
    public function editAction() {

        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->forward();
        }

        if ($this->request->isPost()) {

            $engineService = $this->getDI()->get('EngineService');

            if($engineService->editEngine($params['id'], $this->request->getPost()) === true) {
                $this->flashSession->success('The engine was successfully modified!');
            }
            else {

                // the store failed, the following message were produced
                foreach($engineService->getErrors() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            return $this->forward();
        }
        else {

            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'engines']))->add('Edit');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Edit',
                'form' => (new Forms\EngineForm(null, [
                    'currency' => Currency::find(),
                    'default' => Engines::findFirst($params['id'])
                ]))
            ]);
        }
    }

}

