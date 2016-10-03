<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('income_mdl');
		$this->load->model('order_mdl');
		$this->load->model('orderdish_mdl');
	}

	public function index () {
		$startTime = $this->get('startTime');
		$endTime = $this->get('endTime');
		$type = $this->get('type');
		if(!isset($startTime)){
			$startTime = date('Y-m-d', strtotime('-15 days'));
			$endTime = date('Y-m-d', strtotime('today'));
		}
		$startTime = $startTime.' 00:00:01';
		$endTime = $endTime.' 23:59:59';

		if(strtotime($endTime) - strtotime($startTime) > 60*60*24*40){
			$this->set_error(static::RET_WRONG_INPUT, "不能统计超过40天的数据");	
			return $this->output_json();
		}
		$reportData = $this->report($startTime, $endTime);

		$incomeType = $this->config->item('incomeType');
		$list = array();
		$beginTimeStamp = strtotime($startTime);
		$endTimeStamp = strtotime($endTime);
    	for($i=$endTimeStamp;$i>=$beginTimeStamp;$i-=(24*3600)){
    		$_date = date('Y-m-d', $i);
    		$list[$_date] = array();
		}


		foreach ($list as $k => $v) {
			$list[$k]['report'] = $reportData[$k];
			$list[$k]['totalNum'] = 0;
			$res = $this->income_mdl->list_by_date($k, $type);

			if(empty($res)){
				continue;
			}
			foreach ($res as $key => $value) {
				$list[$k]['totalNum'] = bcadd($list[$k]['totalNum'], $value['amount'], 2);
			}
		}
		
		$data = array(
			'startTime' => $startTime,
			'endTime'  => $endTime,
			'incomeType'  => $incomeType,
			'type'     => $type,
			'list'   => $list,
			'typeName'  => '全部',
		);
		if($type!=0){
			$data['typeName'] = $incomeType[$type];
		}

		$this->output_data($data);
	}
	private function report($startTime, $endTime){
		$list = $this->order_mdl->list_by_time($startTime, $endTime);

		$data = array();
		$beginTimeStamp = strtotime($startTime);
		$endTimeStamp = strtotime($endTime);
    	for($i=$endTimeStamp;$i>=$beginTimeStamp;$i-=(24*3600)){
    		$_date = date('Y-m-d', $i);
    		$data[$_date] = array();
		}
		foreach ($data as $k => $v) {
			$data[$k] = array(
				'orderNum'   => 0,  //订单总数
				'amountNum'  => 0, //订单总金额
				'cancelNum'  => 0, //取消订单数量
				'waitNum'    => 0, //待处理订单数量
				'doNum'      => 0, //处理中订单数量
				'doneNum'    => 0,// 菜上齐订单数量
				'payNum'     => 0, //已付款订单数量
				'pay_amount' => 0, //折扣总金额
			);
			foreach ($list as $key => $value) {
				$timeKey = date('Y-m-d', strtotime($value['ctime']) );
				if($k!=$timeKey){
					continue;
				}
				$data[$k]['orderNum'] = $data[$timeKey]['orderNum'] + 1;
				if($value['status']==2 || $value['status']==3){
					$data[$k]['amountNum'] = bcadd($data[$k]['amountNum'], $value['amount'], 2);
					$data[$k]['pay_amount'] = bcadd($data[$k]['pay_amount'], $value['pay_amount'], 2);
				}
				
				switch ($value['status']) {
					case '0':
						$data[$k]['waitNum'] = $data[$k]['waitNum'] + 1;
						break;
					case '1':
						$data[$k]['doNum'] = $data[$k]['doNum'] + 1;
						break;
					case '2':
						$data[$k]['doneNum'] = $data[$k]['doneNum'] + 1;
						break;
					case '3':
						$data[$k]['payNum'] = $data[$k]['payNum'] + 1;
						break;
					case '8':
						$data[$k]['cancelNum'] = $data[$k]['cancelNum'] + 1;
						break;
					default:
						# code...
						break;
				}
				
			}
			
		
		}
		return $data;
	}
	public function show(){
		$date = $this->get('date');
		if(!isset($date)){
			echo '参数错误!';
			die;
		}
		$list = $this->income_mdl->list_by_date($date);

		$incomeType = $this->config->item('incomeType');
		
		$totalNum = 0;
		if(!empty($list)){
			foreach ($list as $key => $value) {
				$totalNum = bcadd($totalNum, $value['amount'], 2);
			}
		}
		

		$this->output_data(array(
			'date'    => $date,
			'list'    => $list,
			'incomeType' => $incomeType,
			'totalNum' => $totalNum,
		));
	}
	public function add(){

		$obj = $this->income_mdl->gen_new();

		$incomeType = $this->post('incomeType');
		if(!preg_match("/^[1-9][0-9]*$/", $incomeType)){
			$this->set_error(static::RET_WRONG_INPUT, "错误的收款类型");	
			return $this->output_json();
		}

		$amount = $this->post('amount');
		if(!empty($amount) && !preg_match("/^[0-9]+(.[0-9]{2})?$/", $amount)){
			$this->set_error(static::RET_WRONG_INPUT, "收款金额不正确");	
			return $this->output_json();
		}
		$date = $this->post('date');

		if(empty($date)){
			$this->set_error(static::RET_WRONG_INPUT, "结算日期不正确");	
			return $this->output_json();
		}

		$incomeType_name = $this->post('incomeType_name');
		if(empty($incomeType_name)){
			$this->set_error(static::RET_WRONG_INPUT, "收款类型名称不正确！");	
			return $this->output_json();
		}



        $obj->ctime = date('Y-m-d H:i:s');
        $obj->shop_id = $this->shop_id;
        $obj->user_id = $this->sysData['user_id'];
        $obj->type_id = $incomeType;
     	$obj->type_name = $incomeType_name;
     	$obj->date = $date;
     	$obj->amount = $amount;

     	$obj->username = $this->sysData['username'];        


        //继续插入订单
		$this->income_mdl->set($obj);
		$this->output_json();
	}

}
