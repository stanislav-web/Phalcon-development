<?php
namespace Application\Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * Class ControllerBase
 *
 * @package    Application\Modules\Frontend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Frontend/Controllers/ControllerBase.php
 */
class ControllerBase extends Controller
{
    /**
     * Config service
     * @var object Phalcon\Config
     */
    protected $config;

    /**
     * Auth user service
     *
     * @uses \Services\AuthService
     * @var \Phalcon\Di
     */
    protected $auth;

    /**
     * Auth user data
     *
     * @var array $user
     */
    protected $user = [];

    /**
     * Translate service
     *
     * @var \Translate\Translator
     */
    protected $translate;

    /**
     * Logger service
     * @var object Phalcon\Logger\Adapter\File
     */
    protected $logger;

    /**
     * Engine to show
     *
     * @var \Application\Models\Engines
     */
    protected $engine;

    /**
     * Engine to show
     *
     * @var \Application\Models\Categories
     */
    protected $categories;

    /**
     * Navigation trees
     *
     * @var array
     */
    protected $navigation;

    /**
     * Json response string
     *
     * @var array
     */
    protected $reply = [];

    /**
     * initialize() Initial all global objects
     *
     * @access public
     * @return null
     */
    public function initialize()
    {
        // load configurations
        $this->config = $this->di->get('config');

        // define logger
        if($this->di->has('LogDbService')) {
            $this->logger = $this->di->get('LogDbService');
        }

        // define engine
        $this->engine = $this->di->get("EngineService", [$this->request->getHttpHost()])->define();

        // define translate service
        $this->translate = $this->di->get("TranslateService");

        // define assets service
        $this->di->get("AssetsService", [$this->engine])->define();

        // load user data
        $this->auth = $this->di->get("AuthService", [$this->config, $this->request]);

        if($this->auth->isAuth() === true) {

            // success! user is logged in the system
            $this->user = $this->auth->getUser();
        }

        // setup special view directory for this engine
        $this->view->setViewsDir($this->config['application']['viewsFront'].strtolower($this->engine->getCode()))
            ->setMainView('layout')
            ->setPartialsDir('partials');

        // setup navigation menu bars
        $nav = $this->di->get('navigation');

        // setup app title
        $this->tag->setTitle($this->engine->getName());

       // setup to all templates
       $this->view->setVars([
            'engine'    => $this->engine->toArray(),
            'menu'      => $nav,
            't'         => $this->translate
       ]);
    }

    /**
     * Set array reply content.
     *
     * @param array $reply
     * @return null
     */
    protected function setReply(array $reply) {

        foreach($reply as $k => $v)
        {
            $this->reply[$k]    =   $v;
        }
    }

    /**
     * Get array reply content. To put in to view as json string or some once else
     *
     * @param int $code
     * @param string $status
     * @param string $content
     * @return \Phalcon\Http\ResponseInterface
     */
    protected function getReply($code = 200, $status = 'OK', $content = 'application/json') {

        $this->response->setJsonContent($this->reply);
        $this->response->setStatusCode($code, $status);
        $this->response->setContentType($content, 'UTF-8');

        return $this->response->send();
    }
}
