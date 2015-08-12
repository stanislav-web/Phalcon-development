<?php

use \Application\Aware\CliAwareInterface;
use Phalcon\Logger\Adapter\File as FileAdapter;
use \Application\Helpers\SQL;

/**
 * Class BackupTask. Do the MySQL backup tables
 *
 * @package Application
 * @subpackage Tasks
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Tasks/BackupTask.php
*/
class BackupTask extends \Phalcon\CLI\Task implements CliAwareInterface
{

    /**
     * Task configuration
     *
     * @var \Phalcon\Config $config
     */
    private $config;

    /**
     * Logger
     *
     * @var \Phalcon\Logger\Adapter\File $logger
     */
    private $logger;

    /**
     * PDO database connection driver
     *
     * @var \Phalcon\Db\Adapter\Pdo\Mysql $db
     */
    private $db;

    /**
     * Initial time (micro time)
     *
     * @var int $time
     */
    private $time = 0;

    /**
     * Backup tables
     *
     * @var array $tables
     */
    private $tables = [];

    use SQL;

    /**
     * Setup current task configurations
     *
     * @param \Phalcon\Config $config
     * @return \Application\Aware\CliAwareInterface
     */
    public function setConfig(\Phalcon\Config $config)  {

        $this->config = $config['cli'][CURRENT_TASK];

        return $this;
    }

    /**
     * Get current task configurations
     *
     * @return \Phalcon\Config
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * Setup file logger
     *
     * @return \Application\Aware\CliAwareInterface
     */
    public function setLogger() {

        $this->logger = new FileAdapter($this->getConfig()->logfile);

        return $this;
    }

    /**
     * Get logger
     *
     * @return \Phalcon\Logger\Adapter\File
     */
    public function getLogger() {
        return $this->logger;
    }

    /**
     * Setup db connection resource
     *
     * @return \Application\Aware\CliAwareInterface
     */
    public function setDb() {
        $this->db = $this->getDI()->get('db');

        return $this;
    }

    /**
     * Get db adapter
     *
     * @return  \Phalcon\Db\Adapter\Pdo\Mysql
     */
    public function getDb() {
        return $this->db;
    }

    /**
     * Console style helper
     *
     * @return  \Phalcon\Script\Color
     */
    public function styleHelper() {
        return $this->getDI()->get('color');
    }


    /**
     * Backup table
     *
     * @param string $table
     */
    private function backup($table) {

        // init command
        $db = $this->getDb()->getDescriptor();
        $return_var = NULL;
        $output = NULL;
        $file = $this->getConfig()->directory.DIRECTORY_SEPARATOR.$table.'.sql';

        if($table == 'routines') {
            $command = "/usr/bin/mysqldump -u {$db['username']} -h {$db['host']} -p{$db['password']} {$db['dbname']} --routines --no-create-info --no-data --no-create-db --skip-opt > ".$file." 2>/dev/null";
        }
        else {
            $command = "/usr/bin/mysqldump -u {$db['username']} -h {$db['host']} -p{$db['password']} {$db['dbname']} {$table} > ".$file." 2>/dev/null";
        }

        // do the dump of table
        exec($command, $output, $return_var);

        if(!$return_var) {
            echo $this->styleHelper()->head("[" . date('Y.m.d H:i:s', time()) . "] `".$table.".sql` dump created\n");
            $this->logger->log('Created dump of `'.$table.'`', \Phalcon\Logger::NOTICE);
        }
        else {
            $message = 'Create dump of `'.$table.'` rise an error: '.json_encode($output);
            echo $this->styleHelper()->error("[" . date('Y.m.d H:i:s', time()) . "] ".$message."\n");
            $this->logger->log($message, \Phalcon\Logger::CRITICAL);
        }

    }

    /**
     * Table reverse counter
     *
     * @var int $counter
     */
    private $counter = 0;

    /**
     * Initialize task
     */
    public function mainAction()
    {
        // enable time elapse
        $start = explode(" ", microtime());
        $this->time = $start[1] + $start[0];

        try {

            // init configurations
            // init logger
            // init db connect
            $this->setConfig($this->getDI()->get('config'))->setLogger()->setDb();

            if ($this->getDb()) {

                echo $this->styleHelper()->head("[" . date('Y.m.d H:i:s', time()) . "] MySQL connected\n");

                if(file_exists($this->getConfig()->directory) == false) {
                    // create backup directory if not exist
                    mkdir($this->config->directory, 0777);
                    echo $this->styleHelper()->head("[" . date('Y.m.d H:i:s', time()) . "] Backup directory created\n");
                }
                echo "----------------------\n";

                // get next step
                $this->console->handle([
                    'task' 		=> CURRENT_TASK,
                    'action' 	=> 'status'
                ]);
            }
            else {
                // finish action
                $this->console->handle([
                    'task' 		=> CURRENT_TASK,
                    'action' 	=> 'finish'
                ]);
            }
        }
        catch(\Phalcon\Exception $e) {
            echo $this->styleHelper()->error($e->getMessage());
            $this->logger->log($e->getMessage(), \Phalcon\Logger::CRITICAL);
        }
    }

    /**
     * Get database table information, tables, db sizes, names
     */
    public function statusAction()
    {

        $dbStatus = SQL::dbStatus($this->getDb(), ['dbname' => $this->getDb()->getDescriptor()['dbname']]);

        // output database information
        foreach ($dbStatus as $info) {
            if ($info['name'] == $this->getDb()->getDescriptor()['dbname']) {
                echo $this->styleHelper()->head(
                    "[" . date('Y.m.d H:i:s', time()) . "] " . $info['name'] . " " . $info['size'] . " Mb\n"
                );
            }
            else {
                $this->tables[] = $info['name'];
                echo $this->styleHelper()->head(
                    "[" . date('Y.m.d H:i:s', time()) . "] " . $info['name'] . " " . $info['size'] . " Mb\n"
                );
            }
        }
        // count all tables
        $this->counter = count($this->tables);
        echo "----------------------\n";
        echo $this->styleHelper()->head(
            "[" . date('Y.m.d H:i:s', time()) . "] Prepare to dump ...\n"
        );

        sleep(2);

        // get next step
        $this->console->handle([
            'task' 		=> CURRENT_TASK,
            'action' 	=> 'dump'
        ]);
    }

    /**
     * Dump database tables
     *
     * @access public
     */
    public function dumpAction()
    {
        if($this->counter >= 0) {

            do {
                if(isset($this->tables[$this->counter])
                    && in_array($this->tables[$this->counter], $this->getConfig()->exclusion->toArray()) === false) {

                    // do the backup
                    $this->backup($this->tables[$this->counter]);
                }

                --$this->counter;

                $this->console->handle([
                    'task' 		=> CURRENT_TASK,
                    'action' 	=> 'dump'
                ]);

            } while ($this->counter > 0);
        }
        else {

            // check if stored procedures & function is "allow" to dumping
            if($this->getConfig()->routines === true) {
                $this->backup('routines');
            }

            $this->console->handle([
                'task' 		=> CURRENT_TASK,
                'action' 	=> 'finish'
            ]);
        }
    }

    /**
     * Finish action. Show query execution time with request response*
     */
    public function finishAction()
    {
        // fixed end queries time
        $time = explode(" ", microtime());

        echo "----------------------\n";
        echo $this->styleHelper()->head(
            sprintf("[" . date('Y.m.d H:i:s', time()) . "] Use memory: ".(memory_get_usage()/1024)." kb. Time elapsed: %f sec.\n",    (($time[1] + $time[0])-$this->time)));
    }

}