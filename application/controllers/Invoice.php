<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('invoice_mdl');
		$this->load->model('user_mdl');
	}

	public function index () {
		$invoiceType = $this->config->item('invoiceType');
		$invoiceStatus = $this->config->item('invoiceStatus');
		$invoiceStatusColor = $this->config->item('invoiceStatusColor');
		$list = $this->invoice_mdl->userGet($this->sysData['user_id']);
		if(!empty($list)){
			foreach ($list as $k => $v) {
				$list[$k]['invoiceStatusName'] = $invoiceStatus[$v['status']];
				$list[$k]['invoiceTypeName'] = $invoiceType[$v['type']];
				$list[$k]['ctime'] = date('m-d H:i:s',strtotime($v['ctime']));
				$list[$k]['invoiceStatusColor'] = $invoiceStatusColor[$v['status']];
			}
		}
		

		$this->output_data(array(
			'list'   => $list
		));
	}
	public function add(){

		$invoiceType = $this->config->item('invoiceType');

		$data = array(
			'invoiceType'    => $invoiceType,
		);
		$this->output_data($data);
	}
	public function addnew(){
		$obj = $this->invoice_mdl->gen_new();

		$title = $this->post('title');
		if(empty($title)){
			$this->set_error(static::RET_WRONG_INPUT, "标题不能为空！");	
			return $this->output_json();
		}

		$invoiceType = $this->post('invoiceType');
		if(empty($invoiceType)){
			$this->set_error(static::RET_WRONG_INPUT, "报销类型不能为空！");	
			return $this->output_json();
		}

		$date = $this->post('date');
		if(empty($date)){
			$this->set_error(static::RET_WRONG_INPUT, "请选择费用发生时间！");	
			return $this->output_json();
		}

		$desc = $this->post('desc');
		if(empty($desc)){
			$this->set_error(static::RET_WRONG_INPUT, "请写报销详细说明！");	
			return $this->output_json();
		}

		$amount = $this->post('amount');
		if(!empty($amount) && !preg_match("/^[0-9]+(.[0-9]{2})?$/", $amount)){
			$this->set_error(static::RET_WRONG_INPUT, "金额不正确");	
			return $this->output_json();
		}

		$obj->title = $title;
		$obj->type = $invoiceType;
		$obj->date = $date;
		$obj->desc = $desc;
		$obj->amount = $amount;
		$obj->ctime = date('Y-m-d H:i:s');
		$obj->user_id = $this->sysData['user_id'];

		//系统自动审核通过
		$obj->status = 1;
		$obj->checkTime = date('Y-m-d H:i:s');


		$this->invoice_mdl->set($obj);
		
		return $this->output_json();
	}
	public function show(){
		$id = $this->get('id');
		if(empty($id)){
			echo '报销单号不正确！';
			die;
		}
		$id = intval($id);
		$res = $this->invoice_mdl->get($id);
		
		$invoiceType = $this->config->item('invoiceType');
		$invoiceStatus = $this->config->item('invoiceStatus');
		$invoiceStatusColor = $this->config->item('invoiceStatusColor');


		$res->invoiceStatusName = $invoiceStatus[$res->status];
		$res->invoiceTypeName = $invoiceType[$res->type];
		$res->invoiceStatusColor = $invoiceStatusColor[$res->status];

		if($res->check_user){
			$userInfo = $this->user_mdl->get_by_id($res->check_user);
			$res->check_username = $userInfo['name'];
		}else{
			$res->check_username = '系统自动审核';
		}

		if($res->done_user){
			$userInfo = $this->user_mdl->get_by_id($res->done_user);
			$res->done_username = $userInfo['name'];
		}
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
			$this->set_error(static::RET_WRONG_INPUT, "报销单号不正确！");	
			return $this->output_json();
		}
		$id = intval($id);
		$res = $this->invoice_mdl->get($id);

		//判断用户是否一致
		if($res->user_id != $this->sysData['user_id']){
			$this->set_error(static::RET_WRONG_INPUT, "只允许申请人自己撤销报销单！");	
			return $this->output_json();
		}
		//判断状态是否可以撤销
		if(!in_array($res->status,array(0,1,4))){
			$this->set_error(static::RET_WRONG_INPUT, "该报销单状态不允许撤销！");	
			return $this->output_json();
		}

		$obj = array(
			'status' => 3,
		);

		$this->invoice_mdl->update($id,$obj);
		return $this->output_json();
	}
	public function listall(){
		$startTime = $this->get('startTime');
		$endTime = $this->get('endTime');
		$status = $this->get('status');
		$user_id = $this->get('user_id');
		$type = $this->get('type');
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

		if(strtotime($endTime) - strtotime($startTime) > 60*60*24*30){
			$this->set_error(static::RET_WRONG_INPUT, "不能统计超过30天的数据");	
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
		if(!empty($user_id)){
			$where['user_id']  = $user_id;
		}
		if($status!==null && $status!=='all'){
			$where['status']  = $status;
		}
		if(!empty($type)){
			$where['type']  = $type;
		}

		$invoiceType = $this->config->item('invoiceType');
		$invoiceStatus = $this->config->item('invoiceStatus');
		$invoiceStatusColor = $this->config->item('invoiceStatusColor');

		$allNum = $this->invoice_mdl->countSearch($where);

		$list = $this->invoice_mdl->search($page,$where);


		if(!empty($list)){
			foreach ($list as $k => $v) {
				$list[$k]['invoiceStatusName'] = $invoiceStatus[$v['status']];
				$list[$k]['invoiceTypeName'] = $invoiceType[$v['type']];
				$list[$k]['ctime'] = date('m-d H:i:s',strtotime($v['ctime']));
				$list[$k]['invoiceStatusColor'] = $invoiceStatusColor[$v['status']];
				$userInfo = $this->user_mdl->get_by_id($v['user_id']);
				$list[$k]['username'] = $userInfo['name'];
			}
		}
		
		$res = $this->user_mdl->list_by_roleid(array(1,2,3,4));
		$user_list = array();
		foreach ($res as $key => $value) {
			$user_list[$value->id] = $value->name;
		}

		$data = array(
			'invoiceStatus'   => $invoiceStatus,
			'invoiceType'     => $invoiceType,
			'status'          => $status,
			'user_id'         => intval($user_id),
			'type'            => intval($type),
			'startTime'       => date('Y-m-d',strtotime($startTime)),
			'endTime'         => date('Y-m-d',strtotime($endTime)),
			'list'            => $list,
			'user_list'       => $user_list,
			'allNum'          => intval($allNum),
			'page'            => intval($page),
 		);
		$this->output_data($data);
	}

}
