<?php
namespace Application\Services\Security;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;
use Phalcon\Http\Request;

/**
 * Class SessionProtector. Protect session form hijack stealer's
 * It has been suggested by Ellie White on PHP UK 2014.
 *
 * @package Application\Services
 * @subpackage Security
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Security/SessionProtector.php
 */
class SessionProtector {

    /**
     * Configurations
     *
     * @var array $config
     */
    private $config = [];

    /**
     * Session adapter
     *
     * @var \Phalcon\Session\Adapter $session
     */
    private $session;

    /**
     * Init Session configurations
     *
     * @param array $sessionConfig
     */
    public function init(array $sessionConfig) {

        $this->config = $sessionConfig;

        try {
            $adapter = "\Phalcon\Session\Adapter\\".ucfirst($this->config['adapter']);

            $this->session = new $adapter([
                'host'          => $sessionConfig[$this->config['adapter']]['host'],
                'port'          => $this->config[$this->config['adapter']]['port'],
                'lifetime'      => $this->config['lifetime'],
                'persistent'    => $this->config[$this->config['adapter']]['persistent']
            ]);

            session_set_cookie_params($this->config['lifetime'], "/");
            $this->session->start();

            if($this->session->has('started') === true) {

                $token = $this->token();
                $sh = ($this->session->has('hijack') ===true) ? null : $this->session->get('hijack');
                $ch = (empty($_COOKIE['data'])) ? null : $_COOKIE['data'];

                if (!$sh || !$ch || ($sh != $ch) || ($sh != $token)) { // Hijacked!

                    session_write_close();
                    $this->session->setId(md5(time()));
                    $this->session->start();
                    setcookie('data', 0, -172800);
                }
            } else { // Empty/new session, create tokens
                $token = $this->token();
                $this->session->set('started', date_format(new \DateTime(), \DateTime::ISO8601));
                $this->session->set('hijack', $token);
                setcookie('data', $token);
            }

            return $this->session;
        }
        catch(InternalServerErrorException $e) {
            throw new InternalServerErrorException();
        }
    }

    /**
     * Generate protected token
     *
     * @return string
     */
    public function token() {

        $request = new Request();
        $token = empty($request->getUserAgent()) ? 'N/A' : $request->getUserAgent();

        return sha1($token.$this->config['salt'].$this->session->get('started'));
    }


}