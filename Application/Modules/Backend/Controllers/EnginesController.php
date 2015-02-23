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
    public function indexAction()
    {
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

            $engines =
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
                    $engines->setLogo(basename($uploader->getInfo()[0]['path']));

                }
                else {
                    // the store failed, the following message were produced
                    foreach ($uploader->getErrors() as $message) {
                        $this->flashSession->error($message);
                    }
                }
            }

            if($engines->save() === true) {

                $this->flashSession->success('The engine was successfully added!');
                $this->logger->save('Engine `' . $engines->getName() . '`` assigned by ' . $this->request->getClientAddress(), 6);
                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                ]);
            }
            else {
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
     * Delete action
     */
    public function deleteAction()
    {
        try {
            // handling POST data
            if ($this->request->isGet()) {

                $id = $this->dispatcher->getParams()[0];

                $engines = (new Engines())->setId($id);

                if (!$engines->delete()) {
                    // the store failed, the following message were produced
                    foreach ($engines->getMessages() as $message)
                        $this->flashSession->error((string)$message);
                } else // saved successfully
                    $this->flashSession->success('The engine was successfully deleted!');

                    $this->logger->save('Delete engine #' . $id . ' by ' . $this->request->getClientAddress(), 6);

                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                    ]);
            }
        } catch (\Phalcon\Exception $e) {
            echo $e->getMessage();
        }
    }



    /**
     * Shows the view to create (edit) engine
     */
    public function assignAction()
    {

        $id = $this->dispatcher->getParams();

        // check "edit" or "new" action in use
        $engine = (empty($id) === true) ? new Engines() : Engines::findFirst($id[0]);

        if (!$engine instanceof Engines)
            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
                'action' => $this->router->getActionName()
            ]);


        try {

            // handling POST data
            if ($this->request->isPost()) {

                $engines =
                    $engine
                        ->setName($this->request->getPost('name'))
                        ->setDescription($this->request->getPost('description'), null, '')
                        ->setHost($this->request->getPost('host'))
                        ->setCode($this->request->getPost('code'))
                        ->setCurrencyId($this->request->getPost('currency_id', null, 1))
                        ->setStatus($this->request->getPost('status', null, 0));

                // check uploaded logo (if exist)

                if($this->request->hasFiles() !== false) {

                    echo 'Files exist<br><br>';
                    // call uploader

                    $uploader = $this->di->get('uploader');

                    $uploader->setRules([
                        'directory' =>  DOCUMENT_ROOT.'/files',
                        'minsize'   =>  [10],
                        'maxsize'   =>  1000000,
                        'hash'      =>  'crc32',
                        'sanitize'  =>  true,
                        'mimes'     =>  [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                        ],
                        'extensions'     =>  [
                            'gif',
                            'jpeg',
                            'jpg',
                            'png',
                        ],
                    ]);

                    $uploader->addFilters([
                        new \Uploader\Filters\Basic([
                            'extensions'     =>  [
                                'gif',
                                'jpeg',
                                'jpg',
                                'png',
                            ],
                            'mimes'     =>  [
                                'image/gif',
                                'image/jpeg',
                                'image/png',
                            ],
                        ]),
                        new \Uploader\Filters\Basic([
                            'extensions'     =>  [
                                'gif',
                                'jpeg',
                                'jpg',
                                'png',
                            ],
                            'mimes'     =>  [
                                'image/gif',
                                'image/jpeg',
                                'image/png',
                            ],
                        ])
                    ]);

                    if($uploader->isValid() === true) {

                        echo 'Uploader valid<br>';

                        //var_dump($uploader->move());

                    }
                    else {
                        //var_dump('Errors', $uploader->getErrors());
                    }
                }



                if (!$engines->save()) {

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
                } else {

                    // saved successfully
                    if (empty($id) === true)
                        $this->flashSession->success('The engine was successfully added!');
                    else
                        $this->flashSession->success('The engine was successfully updated!');

                    if ($this->_logger)
                        $this->logger->save('Engine assigned by ' . $this->request->getClientAddress(), 6);

                    // forward does not working correctly with this  action type
                    // by the way this handle need to remove in another action (
                    return
                        $this->response->redirect([
                            'for' => 'dashboard-full',
                            'controller' => $this->router->getControllerName(),
                        ]);
                }
            }

            // build meta data
            $title = (empty($id) === true) ? 'Add' : 'Edit';
            $this->tag->prependTitle($title . ' - ' . self::NAME);

            // add crumb to chain (name, link)
            $this->breadcrumbs->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'engines']))
                ->add($title);

            // set variables output to view
            $this->view->setVars([
                'title' => $title,
                'form' => (new Forms\EngineForm(null, [
                    'currency' => Currency::find(),
                    'default' => (empty($id) === true) ? null : $engine
                ]))
            ]);
        } catch (\Phalcon\Exception $e) {
            echo $e->getMessage();
        }
    }

}

