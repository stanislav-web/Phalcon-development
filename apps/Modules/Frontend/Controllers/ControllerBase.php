<?php
namespace Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Models\Users;

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
        if ($this->config->logger->enable === true) {
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
                'menu'      => $nav
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

        // add styles minified
        $css = $this->assets->collection('header-css')
            ->addCss('assets/plugins/bootstrap/bootstrap.min.css')
            ->addCss('assets/frontend/'.strtolower($this->engine->getCode()).'/css/style.css')
            ->addCss('assets/frontend/'.strtolower($this->engine->getCode()).'/css/menu.css')
            ->addCss('assets/frontend/'.strtolower($this->engine->getCode()).'/css/splash.css')
            ->setAttributes(['media' => 'all']);

        // add java scripts minified

        $jsh = $this->assets->collection('header-js')
            ->addJs('assets/plugins/store/store.min.js')
            ->addJs('assets/plugins/angular/angular.min.js')
            ->addJs('assets/plugins/angular-route/angular-route.min.js')
            ->addJs('assets/plugins/angular-animate/angular-animate.min.js')
            ->addJs('assets/plugins/angular-sanitize/angular-sanitize.min.js')
            ->addJs('assets/plugins/angular-translate/angular-translate.min.js')
            ->addJs('assets/plugins/angular-translate-loader-partial/angular-translate-loader-partial.min.js')
            ->addJs('assets/plugins/angular-cookies/angular-cookies.min.js')
            ->addJs('assets/plugins/angular-spinner/angular-spinner.min.js')
            ->addJs('assets/plugins/jquery/jquery.min.js')
            ->addJs('assets/plugins/bootstrap/bootstrap.min.js')
            ->addJs('assets/plugins/ui-bootstrap-tpl/ui-bootstrap-tpl.min.js');

        if (APPLICATION_ENV === 'production') {

            // glue and minimize scripts header

            $jsh->join(true);
            $jsh->addFilter(new \Phalcon\Assets\Filters\Jsmin());
            $jsh->setTargetPath('assets/frontend/'.strtolower($this->engine->getCode()).'/js-hover.min.js');
            $jsh->setTargetUri('assets/frontend/'.strtolower($this->engine->getCode()).'/js-hover.min.js');

        }

        $jsf = $this->assets->collection('footer-js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/app.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/app.config.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/directives/spinner.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/services/splash.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/authenticate/services/authentication.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/controllers/menu.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/controllers/language.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/controllers/index.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/authenticate/controllers/sign.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/user/controllers/user.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/menu.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/move-top.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/easing.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/rules.js')
            ->addJs('assets/plugins/spinner/spin.min.js');

        if (APPLICATION_ENV === 'production') {

            // glue and minimize scripts footer

            $jsf->join(true);
            $jsf->addFilter(new \Phalcon\Assets\Filters\Jsmin());
            $jsf->setTargetPath('assets/frontend/'.strtolower($this->engine->getCode()).'/js-footer.min.js');
            $jsf->setTargetUri('assets/frontend/'.strtolower($this->engine->getCode()).'/js-footer.min.js');

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

        foreach($reply as $k => $v) {
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
     * @access pritected
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

                    $token = $this->user['id'] . $this->user['salt'] . $this->request->getUserAgent();
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
     * Set choised or prefered language
     *
     * @access private
     * @return null
     */
    private function setLanguage() {

        if($this->cookies->has('NG_TRANSLATE_LANG_KEY')) {
            $this->language = $this->cookies->get('NG_TRANSLATE_LANG_KEY')->getValue();
        }
        else {
            $this->language = substr($this->request->getBestLanguage(), 0, 2);
        }

        $this->setReply(['language' => $this->language]);
    }
}
