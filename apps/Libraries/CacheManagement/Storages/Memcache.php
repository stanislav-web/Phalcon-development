<?php
namespace Libraries\CacheManagement\Storages;
	use Libraries\CacheManagement,
		\Helpers\Node,
		Phalcon\Config;

/**
 * Memcached statisticls pool
 * @package Phalcon
 * @subpackage Libraries\CacheManagement
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Libraries/Storages/Memcache.php
 */
class Memcache  implements  CacheManagement\AwareInterface {

	private

		/**
		 * Config memcache
		 * @access private
		 * @var object
		 */
		$_config 	= 	false,

		/**
		 * Resource #ID of connection
		 * @access private
		 * @var bool
	 	 */
		$_connection 	= 	false,

		/**
		 * Server response statuses
		 * @var array
		 */
		$_status		=	[
			100	=>	"Extension %s does not installed",
			101	=>	"Could not Connect to the server %s : %s",
		];

	/**
	 * Init connection to Memcache Server
	 * @param Config $config
	 * @throws CacheManagement\CacheExceptions
	 */
	final public function __construct(Config $config)
	{
		if(!extension_loaded('memcached'))
			throw new CacheManagement\CacheExceptions(printf($this->_status[100], 'memcached'), 101);

		$this->_config	=	$config->cache->memcached;

		if(isset($this->_config))
		{
			$this->_connection = (new \Memcache());
			$this->_connection->connect($this->_config->host, $this->_config->port);
		}

		// if connection lost
		if($this->_connection === false)
			throw new CacheManagement\CacheExceptions(
				printf($this->_status[101],
					$this->_config->host,
					$this->_config->port), 101);
	}

	/**
	 * Get server status information
	 * @access public
	 * @return array
	 */
	public function getServerStatus()
	{
		return [
			'host'		=>	$this->_config->host,
			'port'		=>	$this->_config->port,
			'stats'		=>	$this->_connection->getStats(),
			'status'	=>	$this->_connection->getServerStatus($this->_config->host, $this->_config->port)
		];
	}

	/**
	 * Get storage information
	 * @access public
	 * @return array
	 */
	public function getStorageStatus()
	{
		return [
			'slabs'	=> 	$this->_connection->getExtendedStats('slabs'),
			'items'	=>	$this->_connection->getExtendedStats('items'),
		];
	}

	/**
	 * Get storage content
	 * @param int $limit limit of records
	 * @access public
	 * @return array|mixed
	 */
	public function getPool($limit = 100)
	{
		$list = [];
		$storage = $this->getStorageStatus();
		foreach($storage['slabs'] as $server => $slabs)
		{
			foreach($slabs AS $slabId => $slabMeta)
			{
				if('active_slabs' == $slabId || "total_malloced" == $slabId) continue;
				try {
					$cdump = $this->_connection->getExtendedStats('cachedump', (int)$slabId, $limit);
				}
				catch (Exception $e) {
					continue;
				}
				foreach($cdump AS $server => $entries)
				{
					if($entries)
					{
						foreach($entries AS $eName => $eData)
						{

							$value = $this->_connection->get($eName);
							$type = gettype($value);
							$value = Node::dataUnserialize($value);
							if(is_object($value) || is_array($value))
							{
								$value = is_object($value)? json_decode(json_encode($value), true): $value;
								$value = Node::arrayMapDeep($value,['\Helpers\Node','dataUnserialize']);
							}
							if($eName != '_PHCM')
								$list[] = [
									'key'   => 	$eName,
									'value' => 	$value,
									'size'	=>	mb_strlen(serialize($value), '8bit'),
									'type'  => 	$type,
								];
						}
					}
				}
			}
		}
		ksort($list);
		return  $list;
	}


	/**
	 * Invalidate all existing items
	 * @access public
	 * @return boolean | null
	 */
	public function flushData()
	{
		$result = $this->_connection->flush();
		return ($result) ? true : false;
	}

	/**
	 * Insert new item
	 * @access public
	 * @return boolean | null
	 */
	public function setItem($key, $value)
	{
		$result = $this->_connection->set($key, $value, MEMCACHE_COMPRESSED);
		return ($result) ? true : false;
	}

	/**
	 * Remove selected item key
	 * @param string $key
	 * @access public
	 * @return boolean | null
	 */
	public function removeData($key)
	{
		$result = $this->_connection->delete($key);
		return ($result) ? true : false;
	}


	function print_hit_miss_widget(){
		$status = $this->status;
		?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Hit/Miss</h3>
				</div>
				<div class="panel-body">
					<div id="hit_miss_cart" style="height: 250px;"></div>
				</div>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function(){
					Morris.Donut({
						element: 'hit_miss_cart',
						data: [
							{label: "Hit", value: <?= $status["get_hits"] ?>},
							{label: "Miss", value: <?= $status["get_misses"] ?>},
						],
						colors: ['#5cb85c','#d9534f']
					});
				});
			</script>
		</div>
	<?php
	}
	function print_memory_widget(){
		$status  = $this->status;
		$MBSize  = number_format((real) $status["limit_maxbytes"]/(1024*1024),3);
		$MBSizeU = number_format((real) $status["bytes"]/(1024*1024),3);
		$MBRead  = number_format((real)$status["bytes_read"]/(1024*1024),3);
		$MBWrite = number_format((real) $status["bytes_written"]/(1024*1024),3);
		?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Memory</h3>
				</div>
				<div class="panel-body">
					<div id="memory_cart" style="height: 250px;"></div>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					Morris.Bar({
						element: 'memory_cart',
						data: [
							{type: 'total',v: '<?= $MBSize ?>'},
							{type: 'used', v: '<?= $MBSizeU ?>'},
							{type: 'read', v: '<?= $MBRead ?>'},
							{type: 'Sent', v: '<?= $MBWrite ?>'}
						],
						xkey: 'type',
						ykeys: ['v'],
						labels: ['MB'],
						barColors: function (row, series, type) {
							if (type === 'bar') {
								var colors = ['#f0ad4e', '#5cb85c', '#5bc0de', '#d9534f', '#17BDB8'];
								return colors[row.x];
							}else {
								return '#000';
							}
						},
						barRatio: 0.4,
						xLabelAngle: 35,
						hideHover: 'auto'
					});
				});
			</script>
		</div>
	<?php
	}
	function print_status_dump_widget(){
		$status = $this->status;
		echo '<pre>'.print_r($status,true).'</pre>';
	}
	function dashboard(){

		//charts
		$this->print_charts();
		//footer
		$this->footer();
	}

	function print_charts(){
		?>
		<a name="charts">&nbsp;</a>
		<div class="row top20">
			<?php
			$this->print_hit_miss_widget();
			$this->print_memory_widget();
			?>
		</div>
	<?php
	}

	function footer(){
		?>
		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="http://cdn.oesmith.co.uk/morris-0.5.1.min.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/alertify.js/0.3.11/alertify.min.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				$("#stored_keys").dataTable({
					"bFilter":true,
					"bSort":true,
					"dom": '<"top"ilf>rt<"bottom"p><"clear">'
				});
			});
		</script>
		</body>
		</html>
	<?php
	}
}//end class
