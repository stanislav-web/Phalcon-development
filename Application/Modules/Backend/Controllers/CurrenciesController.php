<?php
namespace Application\Modules\Backend\Controllers;

use Application\Modules\Backend\Forms;
use Phalcon\Mvc\View;

/**
 * Class CurrenciesController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/CurrenciesController.php
 */
class CurrenciesController extends ControllerBase
{
    /**
     * @const Basic virtual dir name
     */
    const NAME = 'Currencies';

    /**
     * Initialize constructor
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Get list of currencies action
     */
    public function indexAction() {
        $this->setBreadcrumbs()->add(self::NAME);

        $currency = $this->getDI()->get('CurrencyService');

        $this->view->setVars([
            'items' => $currency->read(),
        ]);
    }

    /**
     * Delete currency action
     */
    public function deleteAction()
    {
        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->forward();
        }

        $currency = $this->getDI()->get('CurrencyService');

        if($currency->delete($params['id']) === true) {
            $this->flashSession->success('The currency #'.$params['id'].' was successfully deleted');
        }
        else {

            // the store failed, the following message were produced
            foreach($currency->getErrors() as $message) {
                $this->flashSession->error((string)$message);
            }
        }

        return $this->forward();
    }

    /**
     * Add currency action
     */
    public function addAction() {

        $currency = $this->getDI()->get('CurrencyService');

        // handling POST data
        if ($this->request->isPost()) {

            if($currency->create($this->request->getPost()) === true) {
                $this->flashSession->success('The currency was successfully added!');
            }
            else {

                // the store failed, the following message were produced
                foreach($currency->getErrors() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            return $this->forward();
        }
        else {
            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'currencies']))->add('Add');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Add',
                'form' => new Forms\CurrencyForm()
            ]);
        }
    }

    /**
     * Edit currency action
     */
    public function editAction() {

        $params = $this->dispatcher->getParams();
        $currency = $this->getDI()->get('CurrencyService');

        if (isset($params['id']) === false) {

            return $this->forward();
        }

        if ($this->request->isPost()) {

            if($currency->update($params['id'], $this->request->getPost()) === true) {
                $this->flashSession->success('The currency was successfully modified!');
            }
            else {

                // the store failed, the following message were produced
                foreach($currency->getErrors() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            return $this->forward();
        }
        else {

            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'currencies']))->add('Edit');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Edit',
                'form' => new Forms\CurrencyForm(null, [
                    'default' => $currency->read($params['id'])
                ])
            ]);
        }
    }
}

