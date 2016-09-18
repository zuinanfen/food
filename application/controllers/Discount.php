<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('discountconfig_mdl');
		$this->load->model('discountcard_mdl');
		$this->load->model('dish_mdl');
	}

	public function index () {
		
		$discountType = $this->config->item('discountType');

		$this->output_data(
			array(
				'discountType' => $discountType, 
			)
		);
	}
	public function add(){
		if(!in_array($this->sysData['role_id'], array(100))){
			$this->set_error(static::RET_WRONG_INPUT, "权限不够创建优惠券！");	
			return $this->output_json();
		}
		
		$obj = $this->discountconfig_mdl->gen_new();

		$name = $this->post('name');
		if(empty($name)){
			$this->set_error(static::RET_WRONG_INPUT, "名称不能为空！");	
			return $this->output_json();
		}

		$type = $this->post('type');
		if(empty($type)){
			$this->set_error(static::RET_WRONG_INPUT, "全选择卡券类型！");	
			return $this->output_json();
		}

		$desc = $this->post('desc');
		if(empty($desc)){
			$this->set_error(static::RET_WRONG_INPUT, "请填写卡券描述！");	
			return $this->output_json();
		}

		$pic = $this->post('pic');
		if(empty($pic)){
			$this->set_error(static::RET_WRONG_INPUT, "请输入卡券背景图片url！");	
			return $this->output_json();
		}
		$discount = $this->post('discount');
		if(!preg_match("/^[1-9]+([0-9]{1})?$/", $discount)){
			$this->set_error(static::RET_WRONG_INPUT, "折扣格式不正确，请输入0或者两位数整数");	
			return $this->output_json();
		}



		$dish_id = $this->post('dish_id');
		if($type==1 && empty($dish_id)){
			$this->set_error(static::RET_WRONG_INPUT, "请输入折扣券对应的菜品id");	
			return $this->output_json();
		}
		//查看菜品id存在不
		if($type==1){
			$dish_detail = $this->dish_mdl->get($dish_id);
			if(empty($dish_detail)){
				$this->set_error(static::RET_WRONG_INPUT, "对应菜品不存在");	
				return $this->output_json();
			}
			$obj->dish_name = $dish_detail->name;
		}

		$expire_day = $this->post('expire_day');
		if(!preg_match("/^[0-9]*$/", $expire_day)){
			$this->set_error(static::RET_WRONG_INPUT, "过期天数，请输入整数");	
			return $this->output_json();
		}


		$obj->name = $name;
		$obj->type = $type;
		$obj->desc = $desc;
		$obj->pic = $pic;
		$obj->discount = $discount;
		$obj->dish_id = $dish_id;
		$obj->expire_day = $expire_day;
		$obj->ctime = date('Y-m-d H:i:s');
		$obj->user_id = $this->sysData['user_id'];
		$obj->status = 1;

	
		$this->discountconfig_mdl->set($obj);
		
		return $this->output_json();
	}
	public function listall(){
		$list = $this->discountconfig_mdl->list_by_status(1);

		// var_dump($list);

		$discountType = $this->config->item('discountType');
		$this->output_data(
			array(
				'list' => $list,
				'discountType' => $discountType, 
			)
		);
	}
	public function get_card(){
		$id = $this->post('id');
		if(!preg_match("/^[0-9]*$/", $id)){
			$this->set_error(static::RET_WRONG_INPUT, "id 不正确，请联系管理员！");	
			return $this->output_json();
		}
		$info = $this->discountconfig_mdl->get($id);
		if(empty($info) || $info->status==0){
			$this->set_error(static::RET_WRONG_INPUT, "该优惠券异常，或者已经被管理员禁用！");	
			return $this->output_json();
		}
		$mtime=explode(' ',microtime());
		$id = substr($mtime[1],6).($mtime[0]*100000000).mt_rand(1000,9999);
		

		$obj = $this->discountcard_mdl->gen_new();
		$obj->id = $id;
		$obj->ctime = date('Y-m-d H:i:s');
		$obj->discount_id = $info->id;
		$obj->expire_time = date('Y-m-d H:i:s',strtotime("+{$info->expire_day} day"));

		$res = $this->discountcard_mdl->set($obj);
		if(!$res){
			$this->set_error(static::RET_WRONG_INPUT, "系统出错，请刷新重试");	
			return $this->output_json();
		}
		return $this->output_json(array('cardId'=>$id));

	}
	public function show(){
		$id = $this->get('id');
		if(!preg_match("/^[0-9]*$/", $id)){
			$this->set_error(static::RET_WRONG_INPUT, "id 不正确，请联系管理员！");	
			return $this->output_json();
		}
		$info = $this->discountcard_mdl->get($id);
		// var_dump($info);
		$discountInfo = $this->discountconfig_mdl->get($info->discount_id);
		// var_dump($discountInfo);

		$discountType = $this->config->item('discountType');
		$this->output_data(
			array(
				'info' => $info,
				'discountInfo' => $discountInfo,
				'discountType' => $discountType, 
			)
		);
	}
	
}
