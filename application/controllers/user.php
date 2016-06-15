<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('user_mdl');
		$this->load->model('role_mdl');
	}

	public function index () {
		$user_list = $this->user_mdl->list_all();
		$role_list = $this->role_mdl->list_all(true);
		$this->output_data(array(
			'list' => $user_list,
			'role_list' => $role_list,
			'status_list' => User_mdl::$status,
		));
	}
	public function edit () {
		$id = $this->get('id', 'num');
		$user_detail = $this->user_mdl->get($id);

		$role_list = $this->role_mdl->list_all(true);
		$this->output_data(array(
			'detail' => $user_detail,
			'role_list' => $role_list
		));
	}

	public function add () {
		$role_list = $this->role_mdl->list_all(true);
		$this->output_data(array(
			'role_list' => $role_list
		));
	}

	public function insert ()
	{
		$obj = $this->user_mdl->gen_new();

		$name = $this->post("name"); 
		if (empty($name)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数NAME");	
			return $this->output_json();
		}
		$obj->name = strtoupper($name);

		$password = $this->post("password");
		if (empty($password)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数PASSWORD");	
			return $this->output_json();
		}
		$obj->password = md5($obj->name.$password);

		$role_id = $this->post("role_id"); if (isset($role_id) && $role_id>=0) $obj->role_id = intval($role_id);
		$status = $this->post("status"); if (isset($status) && $status>=0) $obj->status = intval($status);

		$this->user_mdl->set($obj);
		$this->output_json();
	}

	public function set ()
	{
		$id = $this->post("id");
		if (empty($id)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数ID");	
			return $this->output_json();
		}

		$obj = $this->user_mdl->get($id);
		if (empty($obj)) {
			$this->set_error(static::RET_ERROR_DATA, "找不到对象");	
			return $this->output_json();
		}

		$old_name = $obj->name;
		$name = $this->post("name"); if (isset($name) && !empty($name)) $obj->name = strtoupper($name);
		$role_id = $this->post("role_id"); if (isset($role_id) && $role_id>=0) $obj->role_id = intval($role_id);
		$status = $this->post("status"); if (isset($status) && $status>=0) $obj->status = intval($status);
		$password = $this->post("password");
		if (isset($name) && !empty($name) && isset($password) && !empty($password)) {
			if ( md5($old_name.$password) != $obj->password ) {
				$this->set_error(static::RET_ERROR_DATA, "原始密码错误");	
				return $this->output_json();
			}

			$newpassword = $this->post("newpassword"); 
			if (empty($newpassword)) {
				$this->set_error(static::RET_WRONG_INPUT, "错误的参数NEWPASSWORD");	
				return $this->output_json();
			}

			$obj->password = md5($obj->name.$newpassword);
		}

		$this->user_mdl->set($obj);
		$this->output_json();
	}
}
