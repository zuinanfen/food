<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserve extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('reserve_mdl');
		$this->load->model('user_mdl');
	}

	public function index () {
		$startTime = $this->get('startTime');
		$endTime = $this->get('endTime');
		$status = $this->get('status');
		$page = $this->get('page');
		if(!isset($page)){
			$page=1;
		}
		if(!isset($startTime)){
			$startTime = date('Y-m-d', strtotime('-1 week'));
			$endTime = date('Y-m-d', strtotime('today'));
		}
		$startTime = $startTime.' 00:00:01';
		$endTime = $endTime.' 23:59:59';

		if(strtotime($endTime) - strtotime($startTime) > 60*60*24*60){
			$this->set_error(static::RET_WRONG_INPUT, "不能统计超过60天的数据");	
			return $this->output_json();
		}
		if($status==null || $status=='all'){
			$status = 'all';
		}else{
			$status = intval($status);
		}

		$where = array(
			'startTime'  => $startTime,
			'endTime'    => $endTime,
		);
		if($status!==null && $status!=='all'){
			$where['status']  = $status;
		}

		$allNum = $this->reserve_mdl->countSearch($where);
		$list = $this->reserve_mdl->search($page,$where);

		$reserveStatus = $this->config->item('reserveStatus');
		$reserveStatusColor = $this->config->item('reserveStatusColor');

		if(!empty($list)){
			foreach ($list as $k => $v) {
				$list[$k]['reserveStatusName'] = $reserveStatus[$v['status']];
				$list[$k]['ctime'] = date('m-d H:i:s',strtotime($v['ctime']));
				$list[$k]['reserveStatusColor'] = $reserveStatusColor[$v['status']];
			}
		}

		$data = array(
			'reserveStatus'   => $reserveStatus,
			'status'          => $status,
			'startTime'       => date('Y-m-d',strtotime($startTime)),
			'endTime'         => date('Y-m-d',strtotime($endTime)),
			'list'            => $list,
			'allNum'          => intval($allNum),
			'page'            => intval($page),
 		);
		$this->output_data($data);
	}
	public function add () {
		$data = array();
		$this->output_data($data);
	}
	public function addnew(){
		$obj = $this->reserve_mdl->gen_new();

		$phone = $this->post('phone');
		if(empty($phone)){
			$this->set_error(static::RET_WRONG_INPUT, "联系人手机号码不能为空！");	
			return $this->output_json();
		}

		$name = $this->post('name');
		if(empty($name)){
			$this->set_error(static::RET_WRONG_INPUT, "联系人姓名不能为空！");	
			return $this->output_json();
		}

		$addr = $this->post('addr');
		if(empty($addr)){
			$addr = ' ';
		}

		$desc = $this->post('desc');
		if(empty($desc)){
			$this->set_error(static::RET_WRONG_INPUT, "请写菜品详细说明！");	
			return $this->output_json();
		}

		$amount = $this->post('amount');
		if(!empty($amount) && !preg_match("/^[0-9]+(.[0-9]{2})?$/", $amount)){
			$this->set_error(static::RET_WRONG_INPUT, "金额不正确，小数点后应为2位");	
			return $this->output_json();
		}

		$obj->phone = $phone;
		$obj->name = $name;
		$obj->addr = $addr;
		$obj->desc = $desc;
		$obj->amount = $amount;
		$obj->ctime = date('Y-m-d H:i:s');
		$obj->user_id = $this->sysData['user_id'];

		//系统自动审核通过
		// $obj->status = 0;


		$this->reserve_mdl->set($obj);
		
		return $this->output_json();
	}
	public function show(){
		$id = $this->get('id');
		if(empty($id)){
			echo '单号不正确！';
			die;
		}
		$id = intval($id);
		$res = $this->reserve_mdl->get($id);
		
		$reserveStatus = $this->config->item('reserveStatus');
		$reserveStatusColor = $this->config->item('reserveStatusColor');


		$res->reserveStatusName = $reserveStatus[$res->status];
		$res->reserveStatusColor = $reserveStatusColor[$res->status];


		$userInfo = $this->user_mdl->get_by_id($res->user_id);
		$res->username = $userInfo['name'];

		$detail = json_decode(json_encode($res), true);

		$this->output_data(
		 array(
		 	'id'   => $id,
			'detail' => $detail
		 	)
			
		);
	}
	public function cancel(){
		$id = $this->post('id');
		if(empty($id)){
			$this->set_error(static::RET_WRONG_INPUT, "单号不正确！");	
			return $this->output_json();
		}
		$id = intval($id);
		$res = $this->reserve_mdl->get($id);

		//判断用户是否一致
		if($res->user_id != $this->sysData['user_id']){
			if($this->sysData['role_id']!=1&&$this->sysData['role_id']!=100){
				$this->set_error(static::RET_WRONG_INPUT, "您没有权限撤销该预订单！");	
				return $this->output_json();
			}
			
		}
		//判断状态是否可以撤销
		if(!in_array($res->status,array(0,1,4))){
			$this->set_error(static::RET_WRONG_INPUT, "该报销单状态不允许撤销！");	
			return $this->output_json();
		}

		$obj = array(
			'status' => 4,
		);

		$this->reserve_mdl->update($id,$obj);
		return $this->output_json();
	}
	public function done(){
		$id = $this->post('id');
		if(empty($id)){
			$this->set_error(static::RET_WRONG_INPUT, "单号不正确！");	
			return $this->output_json();
		}
		$id = intval($id);
		$res = $this->reserve_mdl->get($id);


		//判断状态是否可以确认
		if($res->status!=0){
			$this->set_error(static::RET_WRONG_INPUT, "该报销单状态不允许结算！");	
			return $this->output_json();
		}

		$obj = array(
			'status' => 1,
		);

		$this->reserve_mdl->update($id,$obj);
		return $this->output_json();
	}
}
