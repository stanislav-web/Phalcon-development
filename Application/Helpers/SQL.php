<?php
namespace Application\Helpers;

/**
 * SQL trait. SQL command pattern
 *
 * @package Application
 * @subpackage Helpers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Helpers/SQL.php
 */
trait SQL {

    /**
     * Show database status
     *
     * @param \Phalcon\Db\Adapter\Pdo\Mysql $db           connector
     * @param array                         $placeholders bind values
     * @param int                           $mode         fetch mode (\PDO::FETCH_OBJ | \PDO::FETCH_ASSOC ...)
     *
     * @return mixed
     */
    public static function dbStatus(\Phalcon\Db\Adapter\Pdo\Mysql $db, array $placeholders, $mode = \PDO::FETCH_ASSOC)
    {

        $sql = "
            (
                SELECT table_name AS 'name', ROUND(((data_length + index_length) / 1024 / 1024), 2) 'size'
		            FROM information_schema.TABLES
			            WHERE table_schema = ?
            )
            UNION ALL (
	            SELECT table_schema 'name', ROUND(SUM( data_length + index_length ) / 1024 / 1024, 3) 'size'
	                FROM information_schema.TABLES
		                WHERE table_schema = ?
            )
        ";

        $result = $db->query($sql, [$placeholders['dbname'], $placeholders['dbname']]);

        return $result->fetchAll($mode);
    }

}
