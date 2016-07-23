<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dishoption extends NB_Controller {

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
		$obj = $this->option_mdl->gen_new();
		if (isset($this->post('name')) && !empty($this->post('name'))){
			$obj->name = $this->post('name');
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '选项名称不能为空');	
			return $this->output_json();
		}
		if (isset($this->post('price')) && !empty($this->post('price'))){
			$obj->price = $this->post('price');
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '价格增减必须填数字');	
			return $this->output_json();
		}
		if (isset($this->post('sort')) && !empty($this->post('sort'))){
			$obj->sort = $this->post('sort');
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '排序必须为整数');	
			return $this->output_json();
		}

		$this->dishoption_mdl->set($obj);
		$this->output_json();
	}

	/*public function insert ()
	{
		$obj = $this->option_mdl->gen_new();
		if (isset($name) && !empty($name)){
			$obj->name = $name;
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '选项名称不能为空');	
			return $this->output_json();
		}
		if (isset($price) && !empty($price)){
			$obj->price = $price;
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '价格增减必须填数字');	
			return $this->output_json();
		}
		if (isset($sort) && !empty($sort)){
			$obj->sort = $sort;
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '排序必须为整数');	
			return $this->output_json();
		}

		$this->dishoption_mdl->set($obj);
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
	}*/
}
