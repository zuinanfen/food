<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dishoption extends NB_Controller {

	protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		// $this->load->model('option_mdl');
		$this->load->model('dishoption_mdl');
	}

	// public function index () {
	// 	$option_list = $this->option_mdl->list_all();
	// 	$this->output_data(array(
	// 		'list' => $option_list,
	// 		'status_list' => Option_mdl::$status,
	// 	));
	// }
	public function getDetail () {
		$optionId = $this->input->post('optionId');
		$option_detail = $this->dishoption_mdl->get($optionId);

		$this->output_json(array(
			'detail' => $option_detail
		));
	}

	public function del(){
		$id = $this->input->post('optionId');
		$dish_id = $this->input->post('dish_id');
		if (!isset($id)|| empty($id)){
			$this->set_error(static::RET_WRONG_INPUT, '系统出错，请联系开发人员');	
			return $this->output_json();
		}
		$option_detail = $this->dishoption_mdl->get($id);
		$option_detail->status = 1;

		$this->dishoption_mdl->set($option_detail);
		$this->output_json();
	}

	public function edit () {
		$obj = $this->dishoption_mdl->gen_new();
		$name = $this->input->post('name');
		$price = $this->input->post('price');
		$sort = $this->input->post('sort');
		$dish_id = $this->input->post('dish_id');
		if (isset($dish_id)&&!empty($dish_id)){
			$obj->dish_id = $dish_id;
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '系统出错，请联系开发人员');	
			return $this->output_json();
		}
		if (isset($name)&&!empty($name)){
			$obj->name = $name;
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '选项名称不能为空');	
			return $this->output_json();
		}
		if(is_numeric($price)){
			$obj->price = $price;
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '价格增减必须填数字');	
			return $this->output_json();
		}
		if (isset($sort)&&!empty($sort)){
			$obj->sort = $sort;
		}else{
			$this->set_error(static::RET_WRONG_INPUT, '排序必须为整数');	
			return $this->output_json();
		}
		$optionId = $this->input->post('optionId');
		if(!empty($optionId)){
			$obj->id = $optionId;
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
