<?php
namespace Models;

class UsersObserver extends \Phalcon\Mvc\Model
{

    /**
     * @var integer
     */
    protected $user_id;

    /**
     * @var int
     */
    protected $start;

    /**
     * @var int
     */
    protected $end;

    /**
     * Method to set the value of field user_id
     *
     * @param integer $id
     * @return $this
     */
    public function setUserId($id)
    {
        $this->user_id = $id;

        return $this;
    }

    /**
     * Method to set the value of field `start`
     *
     * @param string $host
     * @return $this
     */
    public function setStart($time)
    {
        $this->start = $time;

        return $this;
    }


	/**
	 * Method to set the value of field `end`
	 *
	 * @param string $host
	 * @return $this
	 */
	public function setEnd($time)
	{
		$this->end = $time;

		return $this;
	}

	/**
	 * Relationship with `users_observer`
	 */
    public function initialize()
    {
		$this->belongsTo('users_id', 'Users', 'id', array('foreignKey' => true));
	}

}
