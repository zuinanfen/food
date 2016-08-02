<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends NB_Controller {

	protected $_allow_role = array(1,3);
	function __construct () {
		parent::__construct();
		$this->load->model('dish_mdl');
		$this->load->model('order_mdl');
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
			'list' => $list
		));
	}
	public function order_list(){
		$list = $this->order_mdl->list_by_status();
		foreach ($list as $k => $v) {
			$orderInit = $this->order->init_order($v);
			$list[$k] = $orderInit;
		}
		// pr($list);
		$this->output_json(array(
			'list' => $list
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

		$this->output_data(array(

		));
	}

}
