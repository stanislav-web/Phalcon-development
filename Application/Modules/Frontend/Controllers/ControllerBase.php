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
     * Auth user service
     *
     * @var \Application\Services\AuthService $auth
     */
    protected $auth;

    /**
     * Translate service
     *
     * @var \Translate\Translator
     */
    protected $translate;

    /**
     * Engine to show
     *
     * @var \Application\Models\Engines $engine
     */
    protected $engine;

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
     * Event before routes execute
     */
    public function beforeExecuteRoute()
    {
        // define engine
        $this->engine = $this->di->get("EngineService")->define($this->request->getHttpHost());

        if($this->request->isAjax() === false) {

            // define assets service
            $this->di->get("AssetsService", [$this->engine])->define();
        }

        // define translate service
        $this->translate = $this->di->get("TranslateService");

        // define auth service
        $this->auth = $this->di->get("AuthService");

    }

    /**
     * Send response collection put from controllers
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function afterExecuteRoute()
    {
        if($this->request->isAjax() === true) {

            // is user auth
            if ($this->auth->isAuth() === true) {
                $this->setReply($this->auth->getAccessToken());
            }

            die($this->getReply());
        }
        else {

            // setup app title
            $this->tag->setTitle($this->engine->getName());

            $this->di->get("ViewService", [$this->engine])->define();

            // setup navigation menu bars
            $nav = $this->di->get('navigation');

            // setup to all templates
            $this->view->setVars([
                'menu'      => $nav,
                't'         => $this->translate
            ]);
        }
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

        return $this->response->getContent();
    }
}
