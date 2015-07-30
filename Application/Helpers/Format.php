<?php
namespace Application\Helpers;

/**
 * Format class. Data formatting
 *
 * @package Application
 * @subpackage Helpers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Helpers/Format.php
 */
trait Format {

    /**
     * Format byte code to human understand
     *
     * @param int $bytes number of bytes
     * @param int $precision after comma numbers
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2) {
        $size = array('bytes', 'kb', 'mb', 'gb', 'tb', 'pb', 'eb', 'zb', 'yb');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.".$precision."f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }

    /**
     * Format call stack trace
     *
     * @param array $stacktrace
     */
    public static function callStack($stacktrace) {

        $i = 1;
        $result = [];
        foreach($stacktrace as $node) {
            if(isset($node['line']) === true) {
                $result[] = "$i. ".basename($node['file']) .":" .$node['function'] ."(" .$node['line'].")";
            }
            $i++;
        }
        return $result;
    }
}
