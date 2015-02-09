<?php
namespace Modules\Frontend\Controllers;

use Helpers\Http;
use Models\Users;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * Class ControllerBase
 *
 * @package    Frontend
 * @subpackage    Modules\Frontend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Controllers/ControllerBase.php
 */
class ControllerBase extends Controller
{
    /**
     * Config service
     * @var object Phalcon\Config
     */
    protected $config;

    /**
     * Auth user
     * @var object Models\Users
     */
    protected $user;

    /**
     * Auth user token
     * @var string
     */
    protected $token    =   null;

    /**
     * Default language
     * @var string
     */
    protected $language    =   'ru';

    /**
     * Translate service
     *
     * @var \Translate\Translator
     */
    protected $translate;

    /**
     * is user Authenticated ?
     * @var boolean
     */
    protected $isAuthenticated = false;

    /**
     * Logger service
     * @var object Phalcon\Logger\Adapter\File
     */
    protected $logger;

    /**
     * Engine to show
     *
     * @var \Models\Engines
     */
    protected $engine;

    /**
     * Engine to show
     *
     * @var \Models\Categories
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

        // load logger
        if($this->config->logger->enable === true) {
            $this->logger = $this->di->get('logger');
        }

        // find current engine
        if($this->session->has('engine') === false) {

            $this->engine   =   \Models\Engines::findFirst("host = '".$this->request->getHttpHost()."'");

            // collect to the session
            $this->session->set('engine', $this->engine);
        }
        else {
            // get current engine

            $this->engine   =   $this->session->get('engine');
        }
        // get related categories HasMany
        //$this->categories   =   \Models\EnginesCategoriesRel::find("engine_id = '1'");
        //foreach ($this->categories as $c) {
        //    var_dump($c->category);
        //}

        if($this->engine !== null) {


            // setup app title
            $this->tag->setTitle($this->engine->getName());

            // load user data
            $this->userVerify();

            // load lang packages
            $this->setLanguage();

            // setup special view directory for this engine
            $this->view->setViewsDir($this->config['application']['viewsFront'].strtolower($this->engine->getCode()))
                ->setMainView('layout')
                ->setPartialsDir('partials');

            // setup navigation menu bars
            $nav = $this->di->get('navigation');

            // setup to all templates
            $this->view->setVars([
                'engine'    => $this->engine->toArray(),
                'menu'      => $nav,
                't'         => $this->translate
            ]);

            // add scripts & stylesheets
            $this->addAssetsContent();
        }
    }

    /**
     * Add assets content
     *
     * @access protected
     * @return null
     */
    private function addAssetsContent() {

        // add styles
        foreach($this->config->assets as $type => $collection) {

            foreach($collection as $title => $content) {

                // create collection
                $min = $title;
                $title = $this->assets->collection($title);

                if($type === 'css') {
                    // collect css
                    foreach($content as $string) {
                        $title->addCss(strtr($string, [':engine' => strtolower($this->engine->getCode())]))->setAttributes(['media' => 'all']);
                    }
                }
                else {
                    // collect js
                    foreach($content as $string) {
                        $title->addJs(strtr($string, [':engine' => strtolower($this->engine->getCode())]));
                    }

                    if (APPLICATION_ENV === 'production') {

                        // glue and minimize scripts header

                        $title->join(true);
                        $title->addFilter(new \Phalcon\Assets\Filters\Jsmin());
                        $title->setTargetPath('assets/frontend/'.strtolower($this->engine->getCode()).'/'.$min.'.min.js');
                        $title->setTargetUri('assets/frontend/'.strtolower($this->engine->getCode()).'/'.$min.'.min.js');

                    }
                }
            }
        }

        return;
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

    /**
     * Check user if have any access types
     *
     * @access protected
     * @return null
     */
    protected function userVerify() {

        if($this->request->isGet()) {

            // get access token from header
            $xToken = $this->request->getHeader('X_TOKEN');

            if(empty($xToken) === false) {
                // need to decrypt token from header
                $this->token = $this->crypt->decryptBase64($xToken, $this->config->cookieCryptKey);

            }
            // get token from session
            else if($this->session->has('token') === true) {
                $this->token =   $this->session->get('token');
            }
            // get token from cookies
            else if($this->cookies->has('token') === true) {
                $this->token =   $this->cookies->get('token')->getValue();
            }

            if(is_null($this->token) === false) {
                // token exist, check user by this token

                $user = (new Users())->findFirst([
                    "token = ?0",
                    "column" => 'id, password, ua',
                    "bind" => [$this->token],
                ]);

                if($user !== false) {

                    // if user were founded
                    $this->user = $user->toArray();

                    $token = $this->user['login'] . $this->user['salt'] . $this->request->getUserAgent();
                    if($this->token === md5($token)) {

                        // success! user is logged in the system
                        $this->setReply([
                            'user'      =>  $this->user,
                        ]);

                        $this->isAuthenticated  =   true;
                    }
                }            
            }
        }
    }

    /**
     * Set choose or preferred language
     *
     * @access private
     * @return null
     */
    private function setLanguage() {

        // use helper to get preferred or selected language
        $this->language = Http::getLanguage('NG_TRANSLATE_LANG_KEY');

        // set translate path
        $this->translate = $this->di->get('translate');
        $this->translate->setTranslatePath(APP_PATH.'/Modules/Frontend/languages/')
            ->setLanguage($this->language)->setDefault($this->config->language);
    }
}
