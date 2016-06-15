<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('order_mdl');
	}

	public function index () {
		$order_list = $this->order_mdl->list_all();
		$this->output_data(array(
			'list' => $order_list,
			'src_type' => Order_mdl::$src_type,
			'status_list' => Order_mdl::$status,
		));
	}
	public function edit () {
		$id = $this->get('id', 'num');
		$order_detail = $this->order_mdl->get($id);

		$this->output_data(array(
			'detail' => $order_detail,
			'src_type' => Order_mdl::$src_type,
			'pay_type' => Order_mdl::$pay_type,
			'status_list' => Order_mdl::$status,
		));
	}

	public function add () {
		$this->load->model('custom_mdl');
		$this->output_data(array(
			'src_type' => Order_mdl::$src_type,
			'pay_type' => Order_mdl::$pay_type,
			'status_list' => Order_mdl::$status,
		));
	}

	public function insert ()
	{
		$obj = $this->order_mdl->gen_new();
		$src = $this->post("src"); if (isset($src) && $src>=0) $obj->src = $src;
		$table_id = $this->post("table_id"); if (isset($table_id) && !empty($table_id)) $obj->table_id = $table_id;
		$order_time = $this->post("order_time", 'date'); if (isset($order_time) && !empty($order_time)) $obj->order_time = $order_time;
		$order_user = $this->post("order_user", 'integer'); if (isset($order_user) && $order_user>=0) $obj->order_user = $order_user;
		$status = $this->post("status", 'integer'); if (isset($status) && $status>=0) $obj->status = $status;
		$dish_list = $this->post("dish_list", 'json'); if (isset($dish_list) && !empty($dish_list)) $obj->dish_list = $dish_list;
		$dish_num = $this->post("dish_num", 'integer'); if (isset($dish_num) && $dish_num>=0) $obj->dish_num = $dish_num;
		$remark = $this->post("remark"); if (isset($remark) && !empty($remark)) $obj->remark = $remark;
		$amount = $this->post("amount", 'money'); if (isset($amount) && $amount>=0) $obj->amount = $amount;
		$pay_amount = $this->post("pay_amount", 'money'); if (isset($pay_amount) && $pay_amount>=0) $obj->pay_amount = $pay_amount;
		$discount = $this->post("discount", 'number'); if (isset($discount) && $discount>=0) $obj->discount = $discount;
		$pay_type = $this->post("pay_type", 'integer'); if (isset($pay_amount) && $pay_amount>=0) $obj->pay_amount = $pay_amount;

		$this->order_mdl->set($obj);
		$this->output_json();
	}

	public function set ()
	{
		$id = $this->post("id");
		if (empty($id)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数ID");	
			return $this->output_json();
		}

		$obj = $this->order_mdl->get($id);
		if (empty($obj)) {
			$this->set_error(static::RET_ERROR_DATA, "找不到对象");	
			return $this->output_json();
		}

		$src = $this->post("src"); if (isset($src) && $src>=0) $obj->src = $src;
		$table_id = $this->post("table_id"); if (isset($table_id) && !empty($table_id)) $obj->table_id = $table_id;
		$order_time = $this->post("order_time", 'date'); if (isset($order_time) && !empty($order_time)) $obj->order_time = $order_time;
		$order_user = $this->post("order_user", 'integer'); if (isset($order_user) && $order_user>=0) $obj->order_user = $order_user;
		$status = $this->post("status", 'integer'); if (isset($status) && $status>=0) $obj->status = $status;
		$dish_list = $this->post("dish_list", 'json'); if (isset($dish_list) && !empty($dish_list)) $obj->dish_list = $dish_list;
		$dish_num = $this->post("dish_num", 'integer'); if (isset($dish_num) && $dish_num>=0) $obj->dish_num = $dish_num;
		$remark = $this->post("remark"); if (isset($remark) && !empty($remark)) $obj->remark = $remark;
		$amount = $this->post("amount", 'money'); if (isset($amount) && $amount>=0) $obj->amount = $amount;
		$pay_amount = $this->post("pay_amount", 'money'); if (isset($pay_amount) && $pay_amount>=0) $obj->pay_amount = $pay_amount;
		$discount = $this->post("discount", 'number'); if (isset($discount) && $discount>=0) $obj->discount = $discount;
		$pay_type = $this->post("pay_type", 'integer'); if (isset($pay_amount) && $pay_amount>=0) $obj->pay_amount = $pay_amount;

		$this->order_mdl->set($obj);
		$this->output_json();
	}
}
