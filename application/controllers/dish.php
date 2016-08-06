<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dish extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('dish_mdl');
		$this->load->model('option_mdl');
		$this->load->model('dishoption_mdl');
	}

	public function index () {
		$dish_list = $this->dish_mdl->list_all(false,array('sort'=>'desc'));
		// $option_list = $this->option_mdl->list_all(TRUE);
		
		//格式化定制项
		// foreach ($dish_list as $obj) {
		// 	$option_ids = json_decode($obj->option, TRUE);
		// 	$option_names = array();
		// 	foreach ($option_ids as $id) {
		// 		if (isset($option_list[$id]))
		// 			$option_names[] = $option_list[$id]->name;
		// 	}
		// 	$obj->option = implode(',',$option_names);
		// }
		$this->output_data(array(
			'list' => $dish_list,
			'status_list' => Dish_mdl::$status,
		));
	}
	public function edit () {
		$id = $this->get('id', 'num');
		$dish_detail = $this->dish_mdl->get($id);
		$option_list = $this->dishoption_mdl->list_by_dish($id);
		// var_dump($option_list);
		$this->output_data(array(
			'dish_id'  => $id,
			'detail' => $dish_detail,
			'status_list' => Dish_mdl::$status,
			'option_list' => $option_list
		));
	}

	public function add () {
		//$option_list = $this->option_mdl->list_all();
		$this->output_data(array(
			'status_list' => Dish_mdl::$status
			//'option_list' => $option_list
		));
	}

	public function insert ()
	{
		$obj = $this->dish_mdl->gen_new();
		$name = $this->post("name"); if (isset($name) && !empty($name)) $obj->name = $name;
		$price = $this->post("price", 'money'); if (isset($price) && $price>0) $obj->price = $price;
		$sort = $this->post("sort"); if (isset($sort)) $obj->sort= intval($sort);
		$status = $this->post("status"); if (isset($status) && $status>=0) $obj->status = intval($status);
		// $option = $this->post("option", 'json'); if (isset($option) && !empty($option)) $obj->option = $option;

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
		// $option = $this->post("option", 'json'); if (isset($option) && !empty($option)) $obj->option = $option;

		$this->dish_mdl->set($obj);
		$this->output_json();
	}
}
