<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('invoice_mdl');
	}

	public function index () {
		
		$this->output_data();
	}
	public function add(){

		$invoiceType = $this->config->item('invoiceType');

		$data = array(
			'invoiceType'    => $invoiceType,
		);
		$this->output_data($data);
	}
	public function addnew(){
		$obj = $this->income_mdl->gen_new();

		$title = $this->post('title');
		if(empty($title)){
			$this->set_error(static::RET_WRONG_INPUT, "标题不能为空！");	
			return $this->output_json();
		}

		$invoiceType = $this->post('invoiceType');
		if(empty($invoiceType)){
			$this->set_error(static::RET_WRONG_INPUT, "报销类型不能为空！");	
			return $this->output_json();
		}

		$date = $this->post('date');
		if(empty($date)){
			$this->set_error(static::RET_WRONG_INPUT, "请选择费用发生时间！");	
			return $this->output_json();
		}

		$desc = $this->post('desc');
		if(empty($desc)){
			$this->set_error(static::RET_WRONG_INPUT, "请写报销详细说明！");	
			return $this->output_json();
		}

		$amount = $this->post('amount');
		if(!empty($amount) && !preg_match("/^[0-9]+(.[0-9]{2})?$/", $amount)){
			$this->set_error(static::RET_WRONG_INPUT, "金额不正确");	
			return $this->output_json();
		}

		$obj->title = $title;
		$obj->type = $invoiceType;
		$obj->date = $date;
		$obj->desc = $desc;
		$obj->amount = $amount;
		$obj->ctime = date('Y-m-d H:i:s');
		$obj->user_id = $this->sysData['user_id'];

		$this->income_mdl->set($obj);
		
		return $this->output_json();
	}

}
