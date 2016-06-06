<?php

class Meta_Sys_Log {
	
	const OPER_TYPE_NORMAL = 0;	//其他
		
	public $user_id;
	public $ip;
	public $oper_type;
	public $data;
	public $ctime;

    //重写转字符串方法
	public function __toString() {
		return $this->oper_type . '|' .
				$this->ctime . '|' .
				$this->user_id . '|' .
				$this->ip . '|' .
				$this->data . "\n"
		;
	}
}


class Log_sys_builder extends Log_builder{
	
	public $user_id = 0;
	
	public function build($obj_log){
		if (empty($obj_log->user_id)) $obj_log->user_id = $this->user_id;
		if (empty($obj_log->oper_type)) $obj_log->oper_type = Meta_Sys_Log::OPER_TYPE_NORMAL;
		if (empty($obj_log->ip)) $obj_log->ip = class_exists('CI_Controller')?get_instance()->input->ip_address() : $_SERVER['REMOTE_ADDR'];
		if (empty($obj_log->data)) $obj_log->data = '';
		if (empty($obj_log->ctime)) $obj_log->ctime = date('YmdHis', $_SERVER['REQUEST_TIME']);
		return $obj_log;                                       
	}

}

class Log_sys_saver extends Log_saver{

	const LOG_PATH = '/Applications/XAMPP/xamppfiles/logs/food/';
	
	public function save($obj_log){
		
		//require_once __DIR__ . '/../cache_helper.php';
		//Cache_helper::init(Cache_helper::DB_DEFAULT)->pub($platform.'_sys', ''.$obj_log);
		//return true;
		
		$filename = $this->get_file_name(self::LOG_PATH . 'sys_' . date('Ymd') . '.log');
		$fp = $this->open_file($filename);
		if (!$fp) {
			return false;
		}

		fwrite($fp, $obj_log, self::LOG_MAX_LENGTH);
		$this->close_file($fp);
		
		return true;
		
	}
	
}

class Log_error_saver extends Log_saver{

	const LOG_PATH = '/Applications/XAMPP/xamppfiles/logs/food/';

	public function save($obj_log){
		$filename = $this->get_file_name(self::LOG_PATH . 'err_' . date('Ymd') . '.log');
	
		$fp = $this->open_file($filename);
		if (!$fp) {
			return false;
		}
	
		fwrite($fp, $obj_log, self::LOG_MAX_LENGTH);
		$this->close_file($fp);
	
		return true;
	}

}

class Log_debug_saver extends Log_saver{

	const LOG_PATH = '/data/logs/platform/';

	public function save($obj_log){
		$filename = $this->get_file_name(self::LOG_PATH . 'debug_' . date('Ymd') . '.log');

		$fp = $this->open_file($filename);
		if (!$fp) {
			return false;
		}
		//如果是数组，转换为字符串
		if(is_array($obj_log)){
			$obj_log = json_encode($obj_log);
		}
		$obj_log = date("Y-m-d H:i:s")."|".$obj_log."\n";//统一加上换行
		fwrite($fp, $obj_log, self::LOG_MAX_LENGTH);
		$this->close_file($fp);

		return true;
	}

}

class Log_sys_parser extends Log_parser {
	public function parse($log) {
		return $log;
	}
}
