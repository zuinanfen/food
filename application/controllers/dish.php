<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dish extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('dish_mdl');
	}

	public function index () {
		$dish_list = $this->dish_mdl->list_all();
		$this->output_data(array(
			'list' => $dish_list,
			'status_list' => Dish_mdl::$status,
		));
	}
	public function edit () {
		$id = $this->get('id', 'num');
		$dish_detail = $this->dish_mdl->get($id);
		$dish_detail->custom = json_decode($dish_detail->custom, TRUE); 
		if (empty($dish_detail->custom)) $dish_detail->custom = array();

		$this->output_data(array(
			'detail' => $dish_detail,
			'status_list' => Dish_mdl::$status,
		));
	}

	public function add () {
		$this->load->model('custom_mdl');
		$custom_list = $this->custom_mdl->list_all(TRUE);
		$this->output_data(array(
			'status_list' => Dish_mdl::$status,
			'custom_list' => $custom_list
		));
	}

	public function insert ()
	{
		$obj = $this->dish_mdl->gen_new();
		$name = $this->post("name"); if (isset($name) && !empty($name)) $obj->name = $name;
		$price = $this->post("price", 'money'); if (isset($price) && $price>0) $obj->price = $price;
		$sort = $this->post("sort"); if (isset($sort)) $obj->sort= intval($sort);
		$status = $this->post("status"); if (isset($status) && $status>=0) $obj->status = intval($status);
		$custom = $this->post("custom", 'json'); if (isset($custom) && !empty($custom)) $obj->custom = $custom;

		$this->dish_mdl->set($obj);
		$this->output_json();
	}

	public function set ()
	{
		$id = $this->post("id");
		if (empty($id)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数ID");	
			return $this->output_json();
		}

		$obj = $this->dish_mdl->get($id);
		if (empty($obj)) {
			$this->set_error(static::RET_ERROR_DATA, "找不到对象");	
			return $this->output_json();
		}

		$name = $this->post("name"); if (isset($name) && !empty($name)) $obj->name = $name;
		$price = $this->post("price", 'money'); if (isset($price) && $price>0) $obj->price = $price;
		$sort = $this->post("sort"); if (isset($sort)) $obj->sort= intval($sort);
		$status = $this->post("status"); if (isset($status) && $status>=0) $obj->status = intval($status);
		$custom = $this->post("custom", 'json'); if (isset($custom) && !empty($custom)) $obj->custom = $custom;

		$this->dish_mdl->set($obj);
		$this->output_json();
	}
}
