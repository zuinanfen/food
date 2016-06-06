<?php

class Meta_Ajax_Log {
	
	const OPER_TYPE_NORMAL = 0;	//其他
		
	public $ip;
	public $oper_type;
	public $data;
	public $ctime;
	
	public function __toString() {
		return $this->oper_type . '|' .
				$this->ctime . '|' .
				$this->ip . '|' .
				$this->data . "\n"
		;
	}
}

class Log_ajax_builder extends Log_builder{
	
	public function build($obj_log){
		if (empty($obj_log->oper_type)) $obj_log->oper_type = Meta_Sys_Log::OPER_TYPE_NORMAL;
		if (empty($obj_log->ip)) $obj_log->ip = get_instance()->input->ip_address();
		if (empty($obj_log->data)) $obj_log->data = '';
		if (empty($obj_log->ctime)) $obj_log->ctime = date('YmdHis', $_SERVER['REQUEST_TIME']);
		return $obj_log;                                       
	}

}

class Log_ajax_saver extends Log_saver{

	const LOG_PATH = '/Applications/XAMPP/xamppfiles/logs/food/'; //web服务器（或者是nfs）上面的log路径
	
	public function save($obj_log){
		$filename = $this->get_file_name(self::LOG_PATH . 'ajax_' . date('Ymd') . '.log');

		$fp = $this->open_file($filename);
		if (!$fp) {
			return false;
		}

		fwrite($fp, $obj_log, self::LOG_MAX_LENGTH);
		$this->close_file($fp);
		
		return true;
	}
}

class Log_ajax_parser extends Log_parser {
	public function parse($log) {
		return $log;
	}
}
