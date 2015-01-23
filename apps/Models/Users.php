<?php
namespace Models;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $login;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $surname;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @var string
     */
    protected $token;

    /**
     *
     * @var string
     */
    protected $state;

    /**
     *
     * @var double
     */
    protected $rating;

    /**
     *
     * @var string
     */
    protected $date_registration;

    /**
     *
     * @var string
     */
    protected $date_lastvisit;

    /**
     *
     * @var integer
     */
    protected $ip;

    /**
     *
     * @var string
     */
    protected $ua;

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns the value of field login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Method to set the value of field login
     *
     * @param string $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $login
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Method to set the value of field surname
     *
     * @param string $login
     * @return $this
     */
    public function setSurname($surname)
    {
        $this->name = $surname;

        return $this;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the value of field token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Method to set the value of field token
     *
     * @param string $password
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Returns the value of field state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Method to set the value of field state
     *
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Returns the value of field rating
     *
     * @return double
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Method to set the value of field rating
     *
     * @param double $rating
     * @return $this
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Returns the value of field date_registration
     *
     * @return string
     */
    public function getDateRegistration()
    {
        return $this->date_registration;
    }

    /**
     * Method to set the value of field date_registration
     *
     * @param string $date_registration
     * @return $this
     */
    public function setDateRegistration($date_registration)
    {
        $this->date_registration = $date_registration;

        return $this;
    }

    /**
     * Returns the value of field date_lastvisit
     *
     * @return string
     */
    public function getDateLastvisit()
    {
        return $this->date_lastvisit;
    }

    /**
     * Method to set the value of field date_lastvisit
     *
     * @param string $date_lastvisit
     * @return $this
     */
    public function setDateLastvisit($date_lastvisit)
    {
        $this->date_lastvisit = $date_lastvisit;

        return $this;
    }

    /**
     * Returns the value of field ip
     *
     * @return integer
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Method to set the value of field ip
     *
     * @param integer $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = ip2long($ip);

        return $this;
    }

    /**
     * Returns the value of field ua
     *
     * @return string
     */
    public function getUa()
    {
        return $this->ua;
    }

    /**
     * Method to set the value of field ua
     *
     * @param string $ua
     * @return $this
     */
    public function setUa($ua)
    {
        $this->ua = $ua;

        return $this;
    }

}
