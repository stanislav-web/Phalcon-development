<?php
namespace Application\Services\Database;
use Phalcon\Db\Adapter\Pdo\Mysql as AdapterGateway;
use Phalcon\Db\Exception as DbException;

/**
 * Class MySQLConnectService. Connection to Database service
 *
 * @package Application\Services
 * @subpackage Database
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Database/MySQLConnectService.php
 */
class MySQLConnectService extends AdapterGateway {

    /**
     * Init MySQL Connect
     *
     * @param array $dbConfig
     */
    public function __construct(array $dbConfig) {

        try {

            $setup = [
                "host"          => $dbConfig['host'],
                "username"      => $dbConfig['username'],
                "password"      => $dbConfig['password'],
                "dbname"        => $dbConfig['dbname'],
                "persistent"    => $dbConfig['persistent'],
                "options" => [
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '".$dbConfig['charset']."'",
                    \PDO::ATTR_CASE => \PDO::CASE_LOWER,
                    \PDO::ATTR_ERRMODE => $dbConfig['debug'],
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]
            ];

            parent::__construct($setup);
        }
        catch(\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

//    /**
//     * Bind params to a SQL statement
//     *
//     * @param string $sqlStatement
//     * @param array  $params
//     */
//    public function bindParams($sqlStatement, $params)
//    {
//        parent::bindParams($sqlStatement, $params);
//    }
//
//    /**
//     * Creates a view
//     *
//     * @param string $tableName
//     * @param array  $definition
//     * @param string $schemaName
//     *
//     * @return boolean
//     */
//    public function createView($viewName, $definition, $schemaName = null)
//    {
//        return parent::createView($viewName, $definition, $schemaName);
//    }
//
//    /**
//     * Drops a view
//     *
//     * @param string   $viewName
//     * @param   string $schemaName
//     * @param boolean  $ifExists
//     *
//     * @return boolean
//     */
//    public function dropView($viewName, $schemaName = null, $ifExists = null)
//    {
//        return parent::dropView($viewName, $schemaName, $ifExists);
//    }
//
//    /**
//     * List all views on a database
//     *
//     * @param string $schemaName
//     *
//     * @return array
//     */
//    public function listViews($schemaName = null)
//    {
//        return parent::listViews($schemaName);
//    }
//
//    /**
//     * Creates a new savepoint
//     *
//     * @param string $name
//     *
//     * @return boolean
//     */
//    public function createSavepoint($name)
//    {
//        return parent::createSavepoint($name);
//    }
//
//    /**
//     * Releases given savepoint
//     *
//     * @param string $name
//     *
//     * @return boolean
//     */
//    public function releaseSavepoint($name)
//    {
//        return parent::releaseSavepoint($name);
//    }
//
//    /**
//     * Rollbacks given savepoint
//     *
//     * @param string $name
//     *
//     * @return boolean
//     */
//    public function rollbackSavepoint($name)
//    {
//        return parent::rollbackSavepoint($name);
//    }
//
//    /**
//     * Set if nested transactions should use savepoints
//     *
//     * @param boolean $nestedTransactionsWithSavepoints
//     *
//     * @return \Phalcon\Db\AdapterInterface
//     */
//    public function setNestedTransactionsWithSavepoints($nestedTransactionsWithSavepoints)
//    {
//        return parent::setNestedTransactionsWithSavepoints($nestedTransactionsWithSavepoints);
//    }
//
//    /**
//     * Returns if nested transactions should use savepoints
//     *
//     * @return boolean
//     */
//    public function isNestedTransactionsWithSavepoints()
//    {
//        return parent::isNestedTransactionsWithSavepoints();
//    }
//
//    /**
//     * Returns the savepoint name to use for nested transactions
//     *
//     * @return string
//     */
//    public function getNestedTransactionSavepointName()
//    {
//        return parent::getNestedTransactionSavepointName();
//    }
}