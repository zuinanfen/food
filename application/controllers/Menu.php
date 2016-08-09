<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends NB_Controller {

	// protected $_allow_role = array(1,3);
	function __construct () {
		parent::__construct();
		$this->load->model('dish_mdl');
		$this->load->model('order_mdl');
		$this->load->model('orderdish_mdl');
		$this->load->model('user_mdl');
		$this->load->library('Order');
		$this->src_type = $this->config->item('orderSource');
	}

	public function index ()
	{
		$dish_list = $this->dish_mdl->list_by_status(array(0));
		
		$this->output_data(array(
			'list' => $dish_list,
			'src_type' => $this->src_type,
		));
	}

	public function cart () {
		// $order_dish = @json_decode($_COOKIE['order_dish']);
		// if(empty($order_dish)){
		// 	$order_dish = array();
		// }
		// $dish_list = $this->dish_mdl->list_by_status(array(0), TRUE);

		$this->output_data(array(
			// 'cart_list' => $order_dish,
			// 'dish_list' => $dish_list,
			'src_type' => $this->src_type
		));
	}
	public function order(){
		$list = $this->order_mdl->list_by_status();

		// $user_list = $this->user_mdl->list_by_roleid(array(3), TRUE);
		// $dish_list = $this->dish_mdl->list_all(TRUE);
		$this->output_data(array(
			'list' => $list,
		));
	}
	public function order_list(){
		$list = $this->order_mdl->list_by_status();
		foreach ($list as $k => $v) {
			$orderInit = $this->order->init_order($v);
			$list[$k] = $orderInit;
		}
		// pr($list);
		$orderStatusColor = $this->config->item('orderStatusColor');
		$this->output_json(array(
			'list' => $list,
			'orderStatusColor'  => $orderStatusColor,

		));
	}
	//查看订单
	public function order_show(){
		$orderId = $this->get('orderId');
		if(!preg_match("/^[A-Za-z0-9]+$/",$orderId)){
			echo '非法请求'; die;
		}

		$detail = $this->order_mdl->get($orderId);
		if($detail == false){
			echo '数据不存在'; die;
		}
		$detail = $this->order->init_order($detail);
		$userInfo = $this->user_mdl->get_by_id($detail['uid']);
		$detail['username'] = $userInfo['name'];

		// $dish_list = $this->orderdish_mdl->get_dish_list($orderId);
		$dish_list = $this->orderdish_mdl->get_all_dish_list($orderId);
		if(empty($dish_list)){
			$dish_list =  array();
		}else{
			foreach ($dish_list as $k => $v) {
				$dish_list[$k] = $this->order->init_dish($v);
			}
		}

		$detail = json_decode(json_encode($detail), true);
		$orderStatusColor = $this->config->item('orderStatusColor');
		$dishStatusColor = $this->config->item('dishStatusColor');
		$this->output_data(array(
			'detail'  => $detail,
			'dishList' => $dish_list,
			'orderStatusColor' => $orderStatusColor,
			'dishStatusColor'  => $dishStatusColor,
		));
	}

	//厨师查看页面
	public function chef(){
		$this->output_data(array(
			
		));
	}
	public function chef_get_list(){
		$list = $this->orderdish_mdl->list_by_status(array(0,1));
		$orderList = array();
		foreach ($list as $k => $v) {
			$v = json_decode(json_encode($v), true);

			if(!isset($orderList[$v['order_id']])){
				$orderInfo = $this->order_mdl->get($v['order_id']);
				$orderInfo = $this->order->init_order($orderInfo);
				$orderList[$v['order_id']] = $orderInfo;
			}else{
				$orderInfo = $orderList[$v['order_id']];
			}
			$v['sourceName'] = $orderInfo['sourceName'];
			$v['source'] = $orderInfo['src'];
			$v['table_id'] = $orderInfo['table_id'];
			$list[$k] = $this->order->init_dish($v);
		}
		//自动更新制作中的菜品
		$update = $this->post('update');
		if($update){
			$this->updateDish();
		}
		$this->output_json(array(
			'list'   => $list,
		));
	}
	//自动更新最早下单的几个菜为制作中
	public function updateDish(){
		$old_list = $this->orderdish_mdl->get_old_dish();
		if($old_list !== false){
			foreach ($old_list as $k => $v) {
				$this->orderdish_mdl->update_status($v['id'], 1);
				//订单状态改为制作中
				$this->order_mdl->update_status($v['order_id'], 1);
			}

		}
		return true;
		
	}
	//上菜员查看页面
	public function serving(){
		$this->output_data(array(
			
		));
	}

	//登陆后首页
	public function logon(){
		
		$this->output_data(array(
			
		));
	}

}
