<?php
namespace Application\Services\Mail;

use \Phalcon\DI\InjectionAwareInterface;
use \Phalcon\Mailer\Manager;

/**
 * Class MailSMTPService. SMTP Mailer service under the Swift
 *
 * @package Application\Services
 * @subpackage Mail
 * @since PHP >=5.4
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
    public function setDi($di)
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
     * @return \Phalcon\Mailer\Message
     */
    public function createMessageFromView($template, array $params = []) {

        // get available views directory
        if($this->getDi()->has('view') === true) {
            $this->view = $this->getDi()->getShared('view');
        }
        $this->mailer = $this->configInstance->createMessageFromView($this->view->getViewsDir().$template, $params);

        return $this->mailer;
    }

    /**
     * Register exceptions SWIFT plugins
     *
     * @param MailSMTPExceptions $plugin
     */
    public function registerExceptionsHandler(\Application\Services\Mail\MailSMTPExceptions $plugin) {
        $this->configInstance->getSwift()->registerPlugin($plugin);
    }

    /**
     * Simply mail logger
     *
     * @param string $message
     * @param int $level
     */
    public function log($message, $level) {
        $this->getDi()->get('LogService')->save($message, $level);
    }
}