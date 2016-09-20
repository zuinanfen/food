<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logon extends NB_Controller {

	protected $_allow_access = array('get_user');

	function __construct () {
		parent::__construct();
		$this->load->model('user_mdl');
	}

	public function index(){
		$shop_id = $this->get("shop_id");
		if(empty($shop_id)){
			echo '来源非法';
			header('Location: /');
			die;
		}

		$this->output_data(array(
			'shop_id'  => intval($shop_id),
		));
	}

	public function get_user () {
		$uid = $this->post("uid");
		if (empty($uid)) {
			$this->set_error(static::RET_WRONG_INPUT, "登陆账号不能为空");	
			return $this->output_json();
		}
		$shop_id = $this->post("shop_id");
		if (empty($shop_id)) {
			$this->set_error(static::RET_WRONG_INPUT, "来源非法，无法追踪店铺");	
			return $this->output_json();
		}

		$res = $this->user_mdl->get_by_uid($uid);
		if (empty($res)) {
			$this->set_error(static::RET_ERROR_DATA, "找不到该用户");	
			return $this->output_json();
		}
		$checkUser = false;
		$obj = '';
		foreach ($res as $k => $v) {
			if($v->shop_id==0 || $v->shop_id==$shop_id){
				$checkUser = true;
				$obj=$v;
				break;
			}
		}
		if(!$checkUser){
			$this->set_error(static::RET_WRONG_INPUT, "该用户身份不能管理该店铺，请联系管理员");	
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
		$shopList = $this->config->item('shopList');
		$shop_name = $shopList[$shop_id];
		//登录成功
		$this->set_logon($obj, $shop_id, $shop_name);	

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
		$shop_id = $this->sysData['shop_id'];
		$this->set_logout();
		// header('Location: /index.php?shop_id='.$shop_id);
		header('Location: /');
	}
	public function discount_api(){
		$number = $this->get('number');
		$token = $this->get('token');
		
		if(empty($number)){
			echo '该优惠券号码异常！';
			die;
		}
		if(empty($token)){
			echo 'token 不正确！';
			die;
		}

		$secretKey = $this->config->item('secretKey');
		if(md5($secretKey.$number) != $token){
			echo '非法请求！';
			die;
		}
		$this->load->model('discountcard_mdl');
		$info = $this->discountcard_mdl->get($number);
		if(empty($info)){
			echo '该卡券不存在！';
			die;
		}
		$content = ''；
		if(strtotime($info->expire_time > time())){
			$content .= '该卡券已经过期！<br/>';
			echo $content;
			die;
		}
		if($info->status==0){
			$content .= '该卡券还未使用，在有效期内可以正常使用！<br/>';
			echo $content;
			die;
		}
		if($info->status==1){
			$content .= '该卡券无效，已经被使用过！<br/>';
			echo $content;
			die;
		}
		echo '未查到信息';
		return false;
	}
}
