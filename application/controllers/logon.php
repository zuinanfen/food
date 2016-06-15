<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logon extends NB_Controller {

	protected $_allow_access = array('get_user');

	function __construct () {
		parent::__construct();
		$this->load->model('user_mdl');
		$this->load->model('role_mdl');
	}

	public function get_user () {
		$name = $this->post("name");
		if (empty($name)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数NAME");	
			return $this->output_json();
		}

		$obj = $this->user_mdl->get_by_name($name);
		if (empty($obj)) {
			$this->set_error(static::RET_ERROR_DATA, "找不到对象");	
			return $this->output_json();
		}

		$password = $this->post("password");
		if (empty($password)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数PASSWORD");	
			return $this->output_json();
		}

		if ( $password != $obj->password ) {
			$this->set_error(static::RET_ERROR_DATA, "密码错误");	
			return $this->output_json();
		}

		//登录成功
		$this->set_logon($obj);	

		$this->output_json(array(
			'detail' => $obj
		));
	}
}
