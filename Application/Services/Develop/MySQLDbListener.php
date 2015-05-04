<?php
namespace Application\Services\Develop;

use Phalcon\Db\Profiler;

/**
 * Class MySQLDbListener. Event to listen MySQL queries
 *
 * @package Application\Services
 * @subpackage Database
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Develop/MySQLDbListener.php
 */
class MySQLDbListener
{
    /**
     * Queries profile data
     *
     * @var array $profileData
     */
    protected $profileData;

    /**
     * @var \Phalcon\Db\Profiler $profiler
     */
    protected $profiler;

    /**
     * Initial profiler
     */
    public function __construct() {
        $this->profiler = new Profiler();
    }

    /**
     * Get profiler instance
     *
     * @return \Phalcon\Db\Profiler
     */
    public function getProfiler() {
        return $this->profiler;
    }

    /**
     * Set profile data
     *
     * @param array $profileData
     */
    public function setProfileData(array $profileData) {

        $this->profileData[] = $profileData;
    }

    /**
     * Get profile data
     *
     * @return array
     */
    public function getProfileData() {
        return $this->profileData;
    }

    /**
     * Get profile data
     *
     * @return array
     */
    public function getDataSizes() {
        return $this->profileData;
    }

    /**
     * Get profile data
     *
     * @return array
     */
    public function getIndexSizes() {
        return $this->profileData;
    }
}