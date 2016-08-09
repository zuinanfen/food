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
		$uid = $this->post("uid");
		if (empty($uid)) {
			$this->set_error(static::RET_WRONG_INPUT, "登陆账号不能为空");	
			return $this->output_json();
		}

		$obj = $this->user_mdl->get_by_uid($uid);
		if (empty($obj)) {
			$this->set_error(static::RET_ERROR_DATA, "找不到该用户");	
			return $this->output_json();
		}

		$password = $this->post("password");
		if (empty($password)) {
			$this->set_error(static::RET_WRONG_INPUT, "密码不能为空");	
			return $this->output_json();
		}

		$secretKey = $this->config->item('secretKey');

		if ( md5($secretKey.$password) != $obj->password ) {
			$this->set_error(static::RET_ERROR_DATA, "密码错误");	
			return $this->output_json();
		}
		if($obj->status !=0){
			$this->set_error(static::RET_ERROR_DATA, "用户禁止访问！");	
			return $this->output_json();
		}

		// unset($obj->password);
		// unset($obj->ctime);
		// unset($obj->mtime);
		// unset($obj->oper);
		//登录成功
		$this->set_logon($obj);	

		//根据角色选择首页
		switch ($obj->role_id) {
			case 1:  //系統管理員
				$url = '/index.php/menu/logon';
				break;
			case 2:  //廚師
				$url = '/index.php/menu/logon';
				break;
			case 3:  //點餐員
				$url = '/index.php/menu/logon';
				break;
			case 4:  //上菜員
				$url = '/index.php/menu/logon';
				break;
			default:
				$url = '/index.php/menu/logon';
				break;
		}

		$this->output_json(array(
			'detail' => $obj,
			'location' => $url
		));
	}
	public function logout(){
		$this->set_logout();
		header('Location: /');
	}
}
