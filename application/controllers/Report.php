<?

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('order_mdl');
		$this->load->model('orderdish_mdl');
	}

	public function index () {
		$startTime = $this->get('startTime');
		$endTime = $this->get('endTime');
		if(!isset($startTime)){
			$startTime = date('Y-m-d', strtotime('-1 week'));
			$endTime = date('Y-m-d', strtotime('today'));
		}
		$startTime = $startTime.' 00:00:01';
		$endTime = $endTime.' 23:59:59';

		if(strtotime($endTime) - strtotime($startTime) > 60*60*24*20){
			$this->set_error(static::RET_WRONG_INPUT, "不能统计超过20天的数据");	
			return $this->output_json();
		}
		$list = $this->order_mdl->list_by_time($startTime, $endTime);

		$data = array();

		foreach ($list as $k => $v) {
			$ctime = $v['ctime'];
			$timeKey = date('Y-m-d', strtotime($v['ctime']) );
			if(!isset($data[$timeKey])){
				$data[$timeKey] = array(
					'orderNum'   => 0,  //订单总数
					'amountNum'  => 0, //订单总金额
					'cancelNum'  => 0, //取消订单数量
					'waitNum'    => 0, //待处理订单数量
					'doNum'      => 0, //处理中订单数量
					'doneNum'    => 0,// 菜上齐订单数量
					'payNum'     => 0, //已付款订单数量
					'pay_amount' => 0, //折扣总金额
				);
			}
			$data[$timeKey]['orderNum'] = $data[$timeKey]['orderNum'] + 1;

			switch ($v['status']) {
				case '0':
					$data[$timeKey]['waitNum'] = $data[$timeKey]['waitNum'] + 1;
					break;
				case '1':
					$data[$timeKey]['doNum'] = $data[$timeKey]['doNum'] + 1;
					break;
				case '2':
					$data[$timeKey]['doneNum'] = $data[$timeKey]['doneNum'] + 1;
					break;
				case '3':
					$data[$timeKey]['payNum'] = $data[$timeKey]['payNum'] + 1;
					break;
				case '8':
					$data[$timeKey]['cancelNum'] = $data[$timeKey]['cancelNum'] + 1;
					break;
				default:
					# code...
					break;
			}
			
			$data[$timeKey]['amountNum'] = bcadd($data[$timeKey]['amountNum'], $v['amount'], 2);
			$data[$timeKey]['pay_amount'] = bcadd($data[$timeKey]['pay_amount'], $v['pay_amount'], 2);

		

		}
		$this->output_data(array(
			'startTime' => $startTime,
			'endTime'  => $endTime,
			'list'   => $data,

		));
	}


}