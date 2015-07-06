<?php
namespace Application\Services\Develop;

use Phalcon\DI\InjectionAwareInterface;

/**
 * Class ProfilerService. Profiler of php calls
 *
 * @package Application\Services
 * @subpackage Develop
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Develop/ProfilerService.php
 */
class ProfilerService implements InjectionAwareInterface
{
    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

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
     * Get database profiler data
     *
     * @return array
     */
    public function getDbProfiler() {
        return $this->getDi()->get('DbListener')->getProfileData();
    }

    /**
     * Get stack calls
     *
     * @return array
     */
    public function getStackCalls() {
        return $this->getDi()->get('tag')->callStack(xdebug_get_function_stack());
    }

    /**
     * Get CPU usage
     *
     * @return string
     */
    public function getUsageCPU() {
        return round(sys_getloadavg()[0], 1, PHP_ROUND_HALF_ODD).'%';
    }

    /**
     * Get Stack of memory usage
     *
     * @return array|string
     */
    public function getMemoryUsage() {
        return $this->getDi()->get('tag')->formatBytes(memory_get_usage(true));
    }

    /**
     * Get memory limit
     *
     * @return string
     */
    public function getMemoryLimit() {
        return  ini_get('memory_limit');
    }
}