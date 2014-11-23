<?php
namespace Helpers;

/**
 * Helper. Data formatting
 * @package Phalcon
 * @subpackage Helpers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Helpers/Format.php
 */
class Format
{
	/**
	 * Format byte code to human understand
	 * @param int $bytes number of bytes
	 * @param int $precision after comma numbers
	 * @return string
	 */
	public static function formatBytes($bytes, $precision = 2)
	{
		$size   = array('bytes', 'kb', 'mb', 'gb', 'tb', 'pb', 'eb', 'zb', 'yb');
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$precision}f", $bytes / pow(1024, $factor)) . ' '.@$size[$factor];
	}

	/**
	 * Output part of string
	 * @param string $orig original string
	 * @param int $chars output chars count
	 * @return string
	 */
	public static function limitString($orig, $chars)
	{
		if(strlen($orig) > $chars)
			$output = substr($orig,0,$chars) . '...';
		else
			$output = $orig;
		return $output;
	}

	/**
	 * Convert seconds to human readable text.
	 * @param timestamp $secs
	 * @return string
	 */
	public static function timestampToDate($secs = 0)
	{
		$units = array(
			"week"   => 7*24*3600,
			"day"    =>   24*3600,
			"hour"   =>      3600,
			"minute" =>        60,
			"second" =>         1,
		);

		// specifically handle zero
		if($secs == 0) return "0 seconds";

		$s = "";

		foreach($units as $name => $divisor)
		{
			if($quot = intval($secs / $divisor))
			{
				$s .= "$quot $name";
				$s .= (abs($quot) > 1 ? "s" : "") . " ";
				$secs -= $quot * $divisor;
			}
		}
		return substr($s, 0, -2);
	}
}
