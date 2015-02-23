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
     * initialize() Initialize constructor
     *
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Get list of all engines
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
     * Add engine action
     */
    public function addAction() {

        // handling POST data
        if ($this->request->isPost()) {

            $engine =
                (new Engines())
                    ->setName($this->request->getPost('name'))
                    ->setDescription($this->request->getPost('description'), null, '')
                    ->setHost($this->request->getPost('host'))
                    ->setCode($this->request->getPost('code'))
                    ->setCurrencyId($this->request->getPost('currency_id', null, 1))
                    ->setStatus($this->request->getPost('status', null, 0));

            // check uploaded logo (if exist)

            if($this->request->hasFiles() !== false) {

                $uploader = $this->di->get('uploader');

                $uploader->setRules(['directory' =>  DOCUMENT_ROOT.'/files/logo']);

                if($uploader->isValid() === true) {

                    $uploader->move();
                    $engine->setLogo(basename($uploader->getInfo()[0]['path']));

                }
                else {
                    // the store failed, the following message were produced
                    foreach ($uploader->getErrors() as $message) {
                        $this->flashSession->error($message);
                    }
                }
            }

            if($engine->save() === true) {

                $this->flashSession->success('The engine was successfully added!');
                $this->logger->save('Engine `' . $engine->getName() . '` assigned by ' . $this->request->getClientAddress(), 6);
                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                ]);
            }
            else {

                // remove uploaded files
                $uploader->truncate();

                // the store failed, the following message were produced
                foreach ($engine->getMessages() as $message)
                    $this->flashSession->error((string)$message);

                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                        'action' => $this->router->getActionName()
                ]);
            }
        }
        else {
            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'engines']))->add('Add');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Add',
                'form' => (new Forms\EngineForm(null, [
                    'currency' => Currency::find(),
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

            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);
        }

        $engine = Engines::findFirst($params['id']);

        if ($this->request->isPost()) {

            $engines =
                (new Engines())
                    ->setId($params['id'])
                    ->setName($this->request->getPost('name'))
                    ->setDescription($this->request->getPost('description'), null, '')
                    ->setHost($this->request->getPost('host'))
                    ->setCode($this->request->getPost('code'))
                    ->setCurrencyId($this->request->getPost('currency_id', null, 1))
                    ->setStatus($this->request->getPost('status', null, 0));

            // check uploaded logo (if exist)

            if($this->request->hasFiles() !== false) {

                $uploader = $this->di->get('uploader');

                $uploader->setRules(['directory' =>  DOCUMENT_ROOT.'/files/logo']);

                if($uploader->isValid() === true) {

                    $uploader->move();

                    $engines->setLogo(basename($uploader->getInfo()[0]['path']));

                }
                else {
                    // the store failed, the following message were produced
                    foreach ($uploader->getErrors() as $message) {
                        $this->flashSession->error($message);
                    }
                }
            }

            if($engines->update() === true) {

                $this->flashSession->success('The engine was successfully modified!');
                $this->logger->save('Engine `' . $engines->getName() . '` modified by ' . $this->request->getClientAddress(), 6);
                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                    ]);
            }
            else {

                // remove uploaded files
                $uploader->truncate();

                // the store failed, the following message were produced
                foreach ($engines->getMessages() as $message)
                    $this->flashSession->error((string)$message);

                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                        'action' => $this->router->getActionName()
                    ]);
            }
        }
        else {

            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'engines']))->add('Edit');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Edit',
                'form' => (new Forms\EngineForm(null, [
                    'currency' => Currency::find(),
                    'default' => $engine
                ]))
            ]);
        }
    }

    /**
     * Delete engine action
     */
    public function deleteAction()
    {
        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);
        }

        $engines = (new Engines())->setId($params['id']);

        if ($engines->delete() === false) {

            // the store failed, the following message were produced
            foreach ($engines->getMessages() as $message) {
                $this->flashSession->error((string)$message);
            }
        } else {
            $this->flashSession->success('The engine was successfully deleted!');
            $this->logger->save('Delete engine #' . $params['id'] . ' by ' . $this->request->getClientAddress(), 6);
        }


        // forward does not working correctly with this  action type
        // by the way this handle need to remove in another action (
        return
            $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);

    }
}

