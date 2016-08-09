<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*class Option extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('option_mdl');
	}

	public function index () {
		$option_list = $this->option_mdl->list_all();
		$this->output_data(array(
			'list' => $option_list,
			'status_list' => Option_mdl::$status,
		));
	}
	public function edit () {
		$id = $this->get('id', 'num');
		$option_detail = $this->option_mdl->get($id);

		$this->output_data(array(
			'detail' => $option_detail,
			'status_list' => Option_mdl::$status,
		));
	}

	public function add () {
		$this->load->model('custom_mdl');
		$this->output_data(array(
			'status_list' => Option_mdl::$status
		));
	}

	public function insert ()
	{
		$obj = $this->option_mdl->gen_new();
		$name = $this->post("name"); if (isset($name) && !empty($name)) $obj->name = $name;
		$price = $this->post("price", 'money'); if (isset($price)) $obj->price = $price;
		$status = $this->post("status"); if (isset($status) && $status>=0) $obj->status = intval($status);

		$this->option_mdl->set($obj);
		$this->output_json();
	}

	public function set ()
	{
		$id = $this->post("id");
		if (empty($id)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数ID");	
			return $this->output_json();
		}

		$obj = $this->option_mdl->get($id);
		if (empty($obj)) {
			$this->set_error(static::RET_ERROR_DATA, "找不到对象");	
			return $this->output_json();
		}

		$name = $this->post("name"); if (isset($name) && !empty($name)) $obj->name = $name;
		$price = $this->post("price", 'money'); if (isset($price)) $obj->price = $price;
		$status = $this->post("status"); if (isset($status) && $status>=0) $obj->status = intval($status);

		$this->option_mdl->set($obj);
		$this->output_json();
	}
}
*/