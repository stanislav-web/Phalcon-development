<?php
namespace Application\Services\Mail;

use Application\Modules\Rest\Exceptions\InternalServerErrorException;
use \Phalcon\DI\InjectionAwareInterface;
use \Phalcon\Mailer\Manager;

/**
 * Class MailSMTPService. SMTP Mailer service under the Swift
 *
 * @package Application\Services
 * @subpackage Mail
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mail/MailSMTPService.php
 */
class MailSMTPService implements InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Dependency injection container
     *
     * @var \Phalcon\Mailer\Manager $configInstance;
     */
    protected $configInstance;

    /**
     * Dependency injection container
     *
     * @var \Phalcon\Mailer\Manager $mailer;
     */
    protected $mailer;

    /**
     * View service
     *
     * @var \Phalcon\Mvc\View $view;
     */
    protected $view;

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi(\Phalcon\DiInterface $di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Initialize mailer
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->configInstance = (new Manager($config));
    }

    /**
     * Email html template. Overload parent
     *
     * @param $template
     * @param array $params
     * @throws \Application\Modules\Rest\Exceptions\InternalServerErrorException
     * @return \Phalcon\Mailer\Message
     */
    public function createMessageFromView($template, array $params = []) {

        // get available views directory
        if($this->getDi()->has('view') === true) {

            $this->view = $this->getDi()->getShared('view');

            $this->mailer = $this->configInstance->createMessageFromView($this->view->getViewsDir().$template, $params);

            return $this->mailer;
        }

        throw new InternalServerErrorException([
            'VIEW_SERVICE_NOT_DEFINED' => 'The `view` service is not defined'
        ]);
    }

    /**
     * Get Swift Mailer instance
     *
     * @return \Swift_Mailer
     */
    public function getSwift() {
        return $this->configInstance->getSwift();
    }

    /**
     * Register SWIFT plugins
     *
     * @param mixed $plugin
     */
    public function registerPlugin($plugin) {
        $this->configInstance->getSwift()->registerPlugin($plugin);
    }
}