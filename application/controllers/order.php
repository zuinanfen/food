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
			'status_list' => Order_mdl::$status,
		));
	}
	public function edit () {
		$id = $this->get('id', 'num');
		$order_detail = $this->order_mdl->get($id);

		$this->output_data(array(
			'detail' => $order_detail,
			'status_list' => Order_mdl::$status,
		));
	}

	public function add () {
		$this->load->model('custom_mdl');
		$this->output_data(array(
			'status_list' => Order_mdl::$status,
		));
	}

	public function insert ()
	{
		$obj = $this->order_mdl->gen_new();
		$src = $this->post("src"); if (isset($src) && !empty($src)) $obj->src = $src;
		$table_id = $this->post("table_id"); if (isset($table_id) && !empty($table_id)) $obj->table_id = $table_id;
		$price = $this->post("price", 'money'); if (isset($price) && $price>0) $obj->price = $price;
		$status = $this->post("status"); if (isset($status) && $status>=0) $obj->status = intval($status);
		$dish_list = $this->post("dish_list", 'json'); if (isset($dish_list) && !empty($dish_list)) $obj->dish_list = $dish_list;
		$dish_num = $this->post("dish_num"); if (isset($dish_num)) $obj->dish_num = intval($dish_num);
		$remark = $this->post("remark"); if (isset($remark) && !empty($remark)) $obj->remark = $remark;
		$amount = $this->post("amount"); if (isset($amount)) $obj->amount = $amount;
		$obj->order_time = date('Y-m-d H:i:s');

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

		$name = $this->post("name"); if (isset($name) && !empty($name)) $obj->name = $name;
		$price = $this->post("price", 'money'); if (isset($price) && $price>0) $obj->price = $price;
		$sort = $this->post("sort"); if (isset($sort)) $obj->sort= intval($sort);
		$status = $this->post("status"); if (isset($status) && $status>=0) $obj->status = intval($status);
		$custom = $this->post("custom", 'json'); if (isset($custom) && !empty($custom)) $obj->custom = $custom;

		$this->order_mdl->set($obj);
		$this->output_json();
	}
}
