<?php
namespace Application\Services\Mail;

use \Phalcon\Exception;

/**
 * Class MailSMTPExceptions. SMTP Mailer exception handler
 *
 * @package Application\Services
 * @subpackage Mail
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mail/MailSMTPExceptions.php
 */
class MailSMTPExceptions
    implements \Swift_Events_TransportExceptionListener {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Set dependency container thought constructor
     *
     * @param \Phalcon\DiInterface $di
     */
    public function __construct(\Phalcon\DiInterface $di)
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
     * Invoked as a TransportException is thrown in the Transport system.
     *
     * @param \Swift_Events_TransportExceptionEvent $evt
     * @throws \Swift_TransportException
     */
    public function exceptionThrown(\Swift_Events_TransportExceptionEvent $evt)
    {

        $evt->cancelBubble(true);

        try{

            throw $evt->getException();
        }
        catch(\Swift_TransportException $e) {

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}