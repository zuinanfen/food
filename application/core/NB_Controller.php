<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

function pr($arr){
	header('Content-type:text/html;charset=utf-8');
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
	exit();
}

class NB_Controller extends CI_Controller {
	protected $_allow_access = array (); // access without logon
	protected $_of;
	protected $_ret = 0;
	protected $_log = '';
	protected $_debug = '';

	const RET_NORMAL = 0;
	const RET_WRONG_INPUT = 0x1;
	const RET_ERROR_DATA = 0x2;
	const RET_ERROR_SYS = 0x3;
	const RET_NOT_LOGON = 0x4;
	
	const DEBUG_NORMAL = 0;
	const DEBUG_INFO = 0x1;
	const DEBUG_WARN = 0x2;
	const DEBUG_ERROR = 0x3;

	public function reflection_api() {
		$data = array ();
	
		$rf = new ReflectionClass ( $this );
		foreach ( $rf->getMethods ( ReflectionMethod::IS_PUBLIC ) as $rf_method ) {
			$rf_method_name = $rf_method->getName ();
			if ($rf_method->isConstructor () or $rf_method->isDestructor () or $rf_method->isAbstract () or $rf_method->isStatic () or substr ( $rf_method_name, 0, 2 ) == '__' or strstr ( __METHOD__, $rf_method_name ) or $rf_method_name == 'debug')
				continue;
			$comment = $rf_method->getDocComment ();
			$data [$rf_method->getName ()] = $comment === false ? '' : $comment;
		}
	
		$this->output->set_content_type ( 'application/json' )->set_output ( json_encode ( $data ) );
	}
	
	function __construct() {
		parent::__construct ();
		$this->benchmark->mark ( 'request_start' );
		
		require_once APPPATH.'helpers/log_helper.php';
		// 创建日志工具
		$this->sys_log = Logger::factory ( Logger::SYS_LOG );	//系统请求日志
		$this->user_log = Logger::factory ( Logger::USER_LOG ); //用户日志（DB）
		$this->debug_log = Logger::factory ( Logger::DEBUG_LOG ); //调试日志
		$this->ajax_log = Logger::factory ( Logger::AJAX_LOG ); // 专门用于记录ajax调用耗时，及内存消耗。
		$this->load->helper ( 'heartbeat' );

		$this->read_params();
    }
    
	
	public function __destruct() {
		if (isset ( $_SERVER ['REQUEST_URI'] ) and isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) and $_SERVER ['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
			$this->benchmark->mark ( 'request_end' );
			$requst_uri = $_SERVER ['REQUEST_URI'];
			if (strpos ( $_SERVER ['REQUEST_URI'], '?' ) !== false) {
				$requst_uri = substr ( $_SERVER ['REQUEST_URI'], 0, strpos ( $_SERVER ['REQUEST_URI'], '?' ) );
        	}
			if (strpos ( $requst_uri, 'lazyloader' ) !== FALSE) {
        			return;
        	}
			$elapsed_time = $this->benchmark->elapsed_time ( 'request_start', 'request_end' );
			$memory_use = (! function_exists ( 'memory_get_usage' )) ? '0' : round ( memory_get_usage () / 1024 / 1024, 2 ) . 'MB';
			;
			$this->ajax_log->log ('request_time:' . date ( 'Y-m-d H:i:s' ) . '|request_uri:' . $requst_uri . '|elapsed_time:' . $elapsed_time . '|memory_use:' . $memory_use . "\n" );
        }
	}
	
	protected function output_data ($data = array(), $view = '', $return = FALSE) {
		$output = null;
		if (!empty($view)) {
			$this->_tpl = $view;
		}
	
		if (!isset($data['_ret'])) {
			$data['_ret'] = $this->_ret;
		}
	
		if (!isset($data['_time'])) {
			$data['_time'] = date('Y-m-d H:i:s');
		}
	
		if (!isset($data['_log'])) {
			$data['_log'] = $this->_log;
		}
	
		if (!isset($data['_debug'])) {
			$data['_debug'] = $this->_debug;
		}
		
		#CDN地址
		if (!isset($data['_cdn_host'])) {
			$data['_cdn_host'] = $this->config->config['cdn_host'];
		}

		if ($this->_of == 'json' or $this->_of == 'json-text') {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
					and strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ){
				//$data['_csrf'] = $this->security->get_csrf_hash();
			}
			if ($return)
				$output = json_encode($data);
			else if ($this->_of == 'json') {
				
				$this->output->set_content_type ('application/json')->set_output(json_encode($data));
			} else {
				$this->output->set_output(json_encode($data));
			}

		} else if ($this->_of == 'excel') {
			if (isset($data['fields']['oper'])) unset($data['fields']['oper']);
			$this->output_excel(isset($data['fields'])? $data['fields'] : array(), isset($data['data'])? $data['data'] : array(), $this->_tpl);
			
		} else {
			$output = $this->load->view($this->_tpl . '_' . $this->_of, $data, $return);
		}
		return $output;
	}
	
	protected function set_error ($ret, $log = '') {
		$this->_ret = $ret;
		$this->_log = $log;
		$this->_tpl = 'error';
	
		if (isset($this->err_log))
		$this->err_log->log(new Meta_Sys_Log(array(
				'oper_type'=> $_SERVER['REQUEST_METHOD'],
				'data' => 'sys|'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '|' .$log
		)));
	}
	
	protected function get($str, $type = 'normal', $default = null){
		$str = $this->input->get($str, TRUE);
		$str = $this->valid($str, $type);
		if(is_null($str) and !is_null($default)){
			$str = $default;
		}
		return $str;
	}
	
	protected function post($str, $type = 'normal', $default = null){
		$str = $this->input->post($str, TRUE);
		$str = $this->valid($str, $type);
		if(is_null($str) and !is_null($default)){
			$str = $default;
		}
		return $str;
	}
	
	protected function get_post($str, $type = 'normal', $default = null){
		$str = $this->input->get_post($str, TRUE);
		$str = $this->valid($str, $type);
		if(is_null($str) and !is_null($default)){
			$str = $default;
		}
		return $str;
	}
	
	protected function valid ($str, $type = 'normal') {
		if (is_array($str)) {
			foreach ($str as $k=>$v)
				if($type=='ip'){
					$ip_seg = explode(',',$v);
					if(count($ip_seg)<=0 ||count($ip_seg)>=3){
						$str[$k]=null;
					}elseif(count($ip_seg)==1){
						$str[$k] = $this->valid($ip_seg[0]);
					}elseif(count($ip_seg)==2){
						$flag = !is_null($this->valid($ip_seg[0])) && !is_null($this->valid($ip_seg[1])) && (ip2long($ip_seg[0]) <=ip2long($ip_seg[1]));
						$str[$k]= $flag ?$v:null;
					}
				}else{
					$str[$k] = $this->valid($v, $type);	
				}
				if(is_null($str[$k])){
					unset($str[$k]);
				}
				
			return $str;
		}
	
		$str = trim($str);
	
		switch ($type) {
			case 'alnum':
				return preg_match("/^[a-zA-Z0-9]+$/u",$str)? $str : NULL;
			case 'chinese':
				return preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$str)? $str : NULL;
			case 'integer':
				return preg_match("/^[0-9_]+$/u",$str)? $str : NULL;
			case 'number':
				return (is_numeric($str) && $str < PHP_INT_MAX)? $str : NULL;
			case 'money':
				$str = str_replace(',', '', $str);
				return (is_numeric($str) && $str < PHP_INT_MAX)? $str : NULL;
			case 'phone':
				return preg_match("/^[0-9-]+$/u",$str)? $str : NULL;
			case 'email':
				return filter_var($str, FILTER_VALIDATE_EMAIL)? $str : NULL;
			case 'float':
				return filter_var($str, FILTER_VALIDATE_FLOAT)? $str : NULL;
			case 'url':
				return filter_var($str, FILTER_VALIDATE_URL)? $str : NULL;
			case 'ip':
				return filter_var($str, FILTER_VALIDATE_IP)? $str : NULL;
			case 'richbox':
				return strtr($str, '\'"', '‘“');
				break;
			case 'date':
				return strtotime($str)? date('Y-m-d H:i:s', strtotime($str)) : NULL;
				break;
			case 'normal':
			default:
				return preg_match("/^[^'\"<>]+$/u",$str)? $str : NULL;
		}
	}
	
	public function debug($data, $level = self::DEBUG_NORMAL) {
		$this->_debug[] = array('data'=>$data, 'level'=>$level);
	}
	
	/*************** private functions *************/
	private function read_params () {
		$of = $this->input->get_post('of');
		$tpl = $this->input->get_post('tpl');
		
		if (isset($of) && in_array($of, array('json', 'json-text', 'xml', 'html', 'excel'))) {
			$this->_of = strtolower(trim($of));
		} else {
			$this->_of = 'html';
		}
			
		if ($tpl)
			$this->_tpl = strtolower(trim($tpl));
		else
			$this->_tpl = load_class('Router')->fetch_class() . '/' . load_class('Router')->fetch_method();
	}
	
	private function output_excel ($fileds, $data, $filename = '', $title = 'WSJ Document', $subject = 'WSJ Document', $fontsize = 10) {
		$objPHPExcel = new PHPExcel();
		 
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("WSJ")->setLastModifiedBy("Felix")->setTitle($title)->setSubject($subject)->setDescription("generated by WSJ Web Toolkit");
		 
		// Set style
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize($fontsize);
		
		$i = 1;
		$letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

		// Add title
		$fileds_key = array_keys($fileds);
		if ($fileds) {
			$j = 0;
			foreach ($fileds as $value) {
				if (!isset($value['thText'])) continue;
				$index = $letter[$j]."$i";
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($index, $value['thText']);
				$objPHPExcel->getActiveSheet()->getColumnDimension($letter[$j])->setWidth(mb_strlen($value['thText'], 'ASCII')*1.2);
				$j++;
			}
			$i++;
			$objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray(array(
                   'font'=>array('bold'=>true)
            ));
		}
	
		// Add some data
		if($data){
			foreach ($data as $value) {
				$newobj =  $objPHPExcel->setActiveSheetIndex(0);
				foreach ((array)$value as $k => $val) {
					if (isset($fileds[$k]) && isset($fileds[$k]['thText'])) {
						$val = strip_tags($val);
						$j = array_search($k, $fileds_key);
						$index = $letter[$j]."$i";
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($index, $val);
						if ($objPHPExcel->getActiveSheet()->getColumnDimension($letter[$j])->getWidth() < mb_strlen($val)*1.2) {
							$objPHPExcel->getActiveSheet()->getColumnDimension($letter[$j])->setWidth(mb_strlen($val, 'ASCII')*1.2);
						}
					}
				}
				$i++;
			}
		}
		$date = date('Y-m-d',time());
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($date);
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Excel2007)
		 
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.$date.'.xls"');
		header('Cache-Control: max-age=0');
		 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}
