<?php
/*
 Песочница
 */
class Events extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$config['auth'] = FALSE;
		$this -> load -> model('users/staff_model');
		$this -> load -> model('user_model');
		$this -> load -> model('orders_model');
	}

	public function get_user_settings() {
		$user = get_system_user(8777);
		print_r($user);
		//$this->stash['json'] = array();
	}

	public function start($user_id, $ip) {
		$current = time();
		$data = json_encode(array('ip' => $ip));

		$active = $this -> db -> select('id') -> from(T_WATCHDOG) -> where('user_id', $user_id) -> where('end_time', NULL) -> count_all_results();
		if ($active == 0) {
			$this -> db -> insert(T_WATCHDOG, array(
				'user_id' => $user_id,
				'start_time' => $current,
				'data' => $data
			));
			$this -> stash['json'] = array('answer' => 'ok');
		} else {
			$this -> stash['json'] = array('answer' => 'refresh');
		}

	}

	public function stop($user_id, $ip) {
		$current = time();
		$data = json_encode(array('ip' => $ip));

		$start_time = $this -> db -> select('id, start_time') -> where('user_id', $user_id) -> where('end_time', NULL) -> get(T_WATCHDOG) -> row_array();
		if (date('d', $start_time['start_time']) != date('d', $current)) {
			$yesterday_end = mktime(23, 59, 59, date('m', $start_time['start_time']), date('d', $start_time['start_time']), date('Y', $start_time['start_time']));
			$today_begin = mktime(0, 0, 0, date('m', $current), date('d', $current), date('Y', $current));
			$this -> db -> where('id', $start_time['id']) -> update(T_WATCHDOG, array(
				'end_time' => $yesterday_end,
				'data' => $data
			));
			$this -> db -> insert(T_WATCHDOG, array(
				'user_id' => $user_id,
				'start_time' => $today_begin,
				'end_time' => $current,
				'data' => $data
			));
		} else {
			$this -> db -> where('user_id', $user_id) -> where('end_time', NULL) -> update(T_WATCHDOG, array(
				'end_time' => $current,
				'data' => $data
			));
		}
		$this -> stash['json'] = array('answer' => 'ok');
	}

	public function close_1() {
		echo time();
		$current = time();
		$this -> db -> where('end_time', NULL) -> update(T_WATCHDOG, array('end_time' => $current));
	}

	public function missed_call($number) {
		// Обрабатываем телефон
		$number = array_shift($this -> user_model -> parse_phones($number));
		$number = $number['city_code'].$number['phone'];

		// Поищем пропущенные и необработанные вызовы с этого номера, чтобы не захламлять таблицу
		$similar_missed_calls = $this -> db -> select('query_id, question')
			-> from(T_CALLCENTER_QUERIES)
			-> where('status', 0)
			-> where('user_phone', $number)
			-> order_by('query_date', 'DESC')
			-> get() -> row_array();

		// Если такие есть
		if(count($similar_missed_calls) > 0){
			$try = explode(" ", $similar_missed_calls['question']);
			$calls = $try[0] + 1;

			// Добавляем дату
			$missed_call_data['query_date'] = date('Y-m-d H:i:s');

			$missed_call_data['question'] = $calls . ' ' .
				number_of($calls, 'пропущенн', array('ый', 'ых', 'ых')).' '.
				number_of($calls, 'вызов', array('', 'а', 'ов')).
				', необходимо перезвонить на номер ' . $number;
			$this -> db -> where('query_id', $similar_missed_calls['query_id']) -> update(T_CALLCENTER_QUERIES, $missed_call_data);
		}else{
			$missed_call_data = array(
				'query_date' 	=> '',
				'status' 		=> 0,
				'user_fio' 		=> $number,
				'user_city'		=> '',
				'user_phone'	=> $number,
				'order_id' 		=> 0,
				'user_id' 		=> 0,
				'question' 		=> '1 пропущенный вызов, необходимо перезвонить на номер ' . $number,
				'priority' 		=> 0,
				'shop_id' 		=> 0
			);

			// Пробуем найти пользователя по номеру телефона
			$user = $this -> user_model -> get_by_phones(array($number));

			// Если нашли вытаскиваем запись
			if (count($user) > 0) {
				$user = array_shift($user);

				// Добавляем данные к массиву
				$missed_call_data['user_fio'] = $user['user_fio'];
				$missed_call_data['user_city'] = $user['user_city'];
				$missed_call_data['user_id'] = $user['user_id'];

				// Ищем заказы
				$order = $this -> orders_model -> get_by_user_id($user['user_id'], null, null, false, 1);
				if (count($order) > 0) {

					// Если есть заказы, вытаскиваем последний
					$order = array_shift($order);

					// Если заказ актуален добавляем данные в массив
					//if($order['status'] != orders_model::S_SUCCESS){
					$missed_call_data['order_id'] = $order['id'];
					$missed_call_data['shop_id'] = $order['shop_id'];
					//}
				}
			}

			// Добавляем дату
			$missed_call_data['query_date'] = date('Y-m-d H:i:s');
			$this -> db -> insert(T_CALLCENTER_QUERIES, $missed_call_data);
		}
	}

	// Обработка перезвона заявки
	public function query_recall($query_id, $status, $user_id, $phone){
		$operation_type = 'query_call';
		switch ($status) {
			case 'ANSWER':
				$operation_type = 'query_call';
				break;
			case 'CANCEL':
				$operation_type = 'query_call_cancel';
				break;
			case 'BUSY':
				$operation_type = 'query_call_busy';
				break;
		}
		$log = array(
			'query_id' => $query_id,
			'user_id' => $user_id,
			'operation_type' => $operation_type,
			'log_date' => date('Y-m-d H:i:s'),
			'log' => json_encode( array('phone' => $phone) )
		);
		$this->db->insert( T_CALLCENTER_QUERIES_LOG, $log );
		$this->stash['json'] = array('status'=>1, 'query_id'=>$query_id);
	}
}