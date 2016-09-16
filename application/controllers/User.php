<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('user_mdl');
		$this->roleType = $this->config->item('roleType');
		$this->roleStatus = $this->config->item('roleStatus');
	}

	public function index () {
		$user_list = $this->user_mdl->list_all();
		$this->output_data(array(
			'list' => $user_list,
			'role_list' => $this->roleType,
			'status_list' => $this->roleStatus,
		));
	}
	public function edit () {
		$id = $this->get('id', 'num');
		$user_detail = $this->user_mdl->get($id);

		$this->output_data(array(
			'detail' => $user_detail,
			'role_list' => $this->roleType,
		));
	}

	public function add () {
		$this->output_data(array(
			'role_list' => $this->roleType,
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
		$obj->name = $name;

		$uid = $this->post('uid');
		if (empty($uid)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的登陆账号");	
			return $this->output_json();
		}
		$obj->uid = $uid;

		$password = $this->post("password");
		if (empty($password)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数PASSWORD");	
			return $this->output_json();
		}
		$secretKey = $this->config->item('secretKey');

		$obj->password = md5($secretKey.$password);

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
			$this->set_error(static::RET_ERROR_DATA, "找不到该用户信息");	
			return $this->output_json();
		}
		
		$uid = $this->post("uid");
		if (!empty($uid)) {
			$obj->uid = $uid;
		}

		

		$secretKey = $this->config->item('secretKey');
		$old_name = $obj->name;


		$name = $this->post("name"); 
		if (isset($name) && !empty($name)){
			$obj->name = $name;
		}

		$role_id = $this->post("role_id"); 
		if (isset($role_id) && $role_id>=0){
			$obj->role_id = intval($role_id);
		} 
		$status = $this->post("status"); 
		if (isset($status) && $status>=0){
			$obj->status = intval($status);
		}


		// $password = $this->post("password");
		// if (isset($name) && !empty($name) && isset($password) && !empty($password)) {
		// 	if ( md5($secretKey.$password) != $obj->password ) {
		// 		$this->set_error(static::RET_ERROR_DATA, "原始密码错误");	
		// 		return $this->output_json();
		// 	}

			
		// 	if (empty($newpassword)) {
		// 		$this->set_error(static::RET_WRONG_INPUT, "新密码不能为空");	
		// 		return $this->output_json();
		// 	}

			
		// }
		$newpassword = $this->post("newpassword"); 

		if(isset($newpassword) && !empty($newpassword)){
			$obj->password = md5($secretKey.$newpassword);
		}


		$this->user_mdl->set($obj);
		$this->output_json();
	}
}
