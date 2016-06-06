<?php

require_once __DIR__ . '/logger/log_user.php';
require_once __DIR__ . '/logger/log_sys.php';
require_once __DIR__ . '/logger/log_ajax.php';
class Logger {
	
	const SYS_LOG = 0x1;	//系统日志
	const USER_LOG = 0x2;	//用户操作日志
	const AJAX_LOG = 0x3;	//异步请求日志
    const DEBUG_LOG = 0xFF;	//调试日志
	
	public $log_builder; // 获取日志内容
	public $log_saver; // 输出到文件或者数据库
	public $log_parser; // 解析

	private function __construct($builder, $saver, $parser) {	
		$this->log_builder = $builder;
		$this->log_saver = $saver;
		$this->log_parser = $parser;
	}
	
	public static function factory($type) {
		switch ($type) {
			case self::SYS_LOG:
				$logger = new self(new Log_sys_builder(), new Log_sys_saver(), new Log_sys_parser());
				break;
			case self::DEBUG_LOG:
				$logger = new self(new Log_sys_builder(), new Log_debug_saver(), new Log_sys_parser());
				break;
			case self::USER_LOG:
				$logger = new self(new Log_user_builder(), new Log_user_saver(), new Log_user_parser());
				break;
				break;
			case self::AJAX_LOG:
				$logger = new self(new Log_ajax_builder(), new Log_ajax_saver(), new Log_ajax_parser());
				break;
		}
		return $logger;
	}


	public function log($log){
		if (is_object($log)) {
			$log = $this->log_builder->build($log);
		}
		return @$this->log_saver->save($log);
	}
	
	public function parse ($log) {
		return $this->log_parser->parse($log);
	}
	
}

abstract class Log_parser {
	
	abstract public function parse($log);
}

abstract class Log_builder {
	public $logger;
	
	public function build($data) {
		return $data;
	}
	
}

abstract class Log_saver {
	public $logger;

	const FILE_MAX_SIZE = 1099511627776; //1G
	const LOG_MAX_LENGTH = 102400; //100K
	
	abstract public function save($log);
	
	protected function get_file_name ($filename) {
		if (file_exists($filename) && self::FILE_MAX_SIZE <= $this->get_file_size($filename)) {
	
			$idx = 0;
			do {
				$tmpname = $filename . sprintf('.%03d', $idx++);
			} while(file_exists($tmpname) && $idx < 1000);
	
			@rename($filename, $tmpname);
		}
		return $filename;
	}
	
	protected function open_file ($filename) {
		$fp = fopen($filename, 'a');
	
		$start_time = microtime(TRUE);
		while (false == flock($fp, LOCK_EX | LOCK_NB) && microtime(TRUE)-$start_time > 2 ) {
			usleep(round(rand(0, 100)*1000));
		}
	
		if (!flock($fp, LOCK_EX | LOCK_NB)) {
			return NULL;
		}
	
		return $fp;
	}
	
	protected function close_file ($fp) {
		flock($fp, LOCK_UN);
		fclose($fp);
	}
	
	protected function get_file_size ($filename) {
		clearstatcache();
		return filesize($filename);
	}
}


