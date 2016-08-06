<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('order_mdl');
		$this->load->model('user_mdl');
		$this->load->model('dish_mdl');
		$this->load->model('option_mdl');
		$this->load->model('dishoption_mdl');
		$this->load->model('orderdish_mdl');
		// $this->load->library('session');
	}

	public function index () {
		$order_list = $this->order_mdl->list_by_status();
		$user_list = $this->user_mdl->list_by_roleid(array(3), TRUE);
		$dish_list = $this->dish_mdl->list_all(TRUE);
		$this->output_data(array(
			'list' => $order_list,
			'src_type' => Order_mdl::$src_type,
			'status_list' => Order_mdl::$status,
			'user_list' => $user_list,
			'dish_list' => $dish_list,
		));
	}
	// public function edit () {
	// 	$id = $this->get('id', 'num');
	// 	$order_detail = $this->order_mdl->get($id);
	// 	$user_list = $this->user_mdl->list_by_roleid(array(3));
	// 	$dish_list = $this->dish_mdl->list_all(TRUE);
	// 	$option_list = $this->option_mdl->list_all(TRUE);
	// 	$this->output_data(array(
	// 		'detail' => $order_detail,
	// 		'src_type' => Order_mdl::$src_type,
	// 		'pay_type' => Order_mdl::$pay_type,
	// 		'status_list' => Order_mdl::$status,
	// 		'user_list' => $user_list,
	// 		'dish_list' => $dish_list,
	// 		'option_list' => $option_list
	// 	));
	// }

	protected function getOrderId($uid, $time){
        $id = $time.rand(1000,9999).substr(md5($time.$uid),0,8);
        return strtoupper($id);
    }
	public function add(){
		$obj = $this->order_mdl->gen_new();

		$order_src = $this->post('order_src');
		if(!preg_match("/^[1-9][0-9]*$/", $order_src)){
			$this->set_error(static::RET_WRONG_INPUT, "错误的订单类型");	
			return $this->output_json();
		}

		$order_table_seat = $this->post('order_table_seat');
		if(!empty($order_table_seat) && !preg_match("/^[1-9][0-9]*$/", $order_table_seat)){
			$this->set_error(static::RET_WRONG_INPUT, "错误的座位台号");	
			return $this->output_json();
		}
		if(empty($order_table_seat)){
			$order_table_seat = '';
		}

		$dish_list = $_POST['dish_list'];// 不知道为毛用$this->post('dish_list');接收不到数据，估计是xss拦截
		if(empty($dish_list)){
			$this->set_error(static::RET_WRONG_INPUT, "菜品不能为空！");	
			return $this->output_json();
		}
		try {
			$dish_list = json_decode($dish_list, true);
		} catch (Exception $e) {
			$this->set_error(static::RET_WRONG_INPUT, "参数错误，请联系管理员");	
			return $this->output_json();
		}

		$userData = $_SESSION['NBFOOD'];
		$ctime = date('Y-m-d H:i:s');
        $orderId = $this->getOrderId($userData->id, strtotime($ctime));

        $obj->id = $orderId;
        $obj->src = $order_src;
        $obj->table_id = $order_table_seat;
        $obj->uid = $userData->id;
        $obj->status = 0;
        $obj->dish_list = json_encode($dish_list);
        $obj->ctime = $ctime;
        $obj->mtime = $ctime;
		$obj->dish_num = count($dish_list);


        //先循环插入菜品
        $amount = $this->insertOrderDish($orderId, $dish_list); //获取总价

        $obj->amount = $amount;
        //继续插入订单
		$this->order_mdl->set($obj);
		$this->output_json();
	}
	private function insertOrderDish($orderId, $dish_list){
		$obj = $this->orderdish_mdl->gen_new();
		$obj->order_id = $orderId;
		$userData = $_SESSION['NBFOOD'];
		$obj->uid = $userData->id;
		$ctime = date('Y-m-d H:i:s');
		$obj->ctime = $ctime;
		$obj->mtime = $ctime;

		$order_total_price = 0;

		foreach ($dish_list as $k=>$v) {
			$totalPrice = $v['dishPrice'];
			$select_options = array();


			if(count($v['options'])>0){
				foreach ($v['options'] as $key => $value) {
					$option_detail = $this->dishoption_mdl->getDetail($value);
					array_push($select_options, $option_detail);
					$totalPrice = bcadd($totalPrice, $option_detail->price, 2);
				}
			}

			$obj->dish_key = $k;
			$obj->dish_id = $v['dishId'];
			$obj->name = $v['name'];
			$obj->price = $v['dishPrice'];
			$obj ->status = 0;
			$obj->total_price = $totalPrice;
			$obj->select_options = json_encode($select_options);
			$this->orderdish_mdl->set($obj);

			$order_total_price = bcadd($order_total_price, $totalPrice, 2);
		}
		return $order_total_price;

	}
	//菜品上菜
	public function doneDish(){
		$id = $this->post('id');
		$this->orderdish_mdl->update_status($id, 2); //已经上菜

		//查找该订单是否还有未完成的菜品,没有的话，改成订单已完成
		$orderId = $this->post('orderId');
		$res = $this->orderdish_mdl->orderlist_by_status($orderId,array(0,1));
		if(empty($res)){
			$this->order_mdl->update_status($orderId, 2);
		}
		return $this->output_json();

	}
	//订单删除菜品
	public function delDish(){
		$dishId = $this->post('dishId');
		$orderId = $this->post('orderId');
		$dishKey = $this->post('dishKey');

		//重新结算订单
		$dishList = $this->orderdish_mdl->get_dish_list($orderId);
		if(count($dishList)<2){
			$this->set_error(static::RET_WRONG_INPUT, "该订单只有一个菜品，无法删除，请直接撤销订单！");
			return $this->output_json();
		}
		//更改菜品状态
		$this->orderdish_mdl->update_status($dishId, 8);
		//读取有效的菜品
		$dishList = $this->orderdish_mdl->get_dish_list($orderId);
		
		// //获取订单内容
		// $orderInfo = $this->order_mdl->get($orderId);
		// //修改dish_list包
		// $orderDishList = json_decode($orderInfo['dish_list'], true);
		// unset($orderDishList[$dishKey]);

		//结算新订单的价格
		$totalPrice = 0;
		foreach ($dishList as $k => $v) {
			$totalPrice = bcadd($totalPrice, $v['total_price'], 2);
		}
		//更改订单价格和商品数量
		$update_data = array(
			// 'dish_list' => json_encode($orderDishList),
			'dish_num'  => count($dishList),
			'amount'    => $totalPrice,
		);
		$this->order_mdl->update($orderId, $update_data);
		return $this->output_json();
	}
	//撤销订单
	public function cancelOrder(){
		$orderId = $this->post('orderId');
		$orderStatus = $this->config->item('orderStatus');
		//查询订单状态
		$orderInfo = $this->order_mdl->get($orderId);
		if(!$orderInfo){
			$this->set_error(static::RET_WRONG_INPUT, "订单异常，无法撤销，请联系管理员！");
			return $this->output_json();
		}
		if($orderInfo['status'] != 0){
			$this->set_error(static::RET_WRONG_INPUT, "该订单状态为".$orderStatus[$orderInfo['status']]."，无法撤销！");
			return $this->output_json();
		}
		//将该订单的所有商品都改成撤销状态
		$dish_list = $this->orderdish_mdl->get_all_dish_list($orderId);
		foreach ($dish_list as $k => $v) {
			if($v['status']!=8){
				$this->orderdish_mdl->update_status($v['id'],8);
			}
		}
		//修改订单状态
		$data = array(
			'status'  =>8,
			'amount'  =>0,
			'dish_num'=>0,
		);
		$this->order_mdl->update($orderId,$data);
		return $this->output_json();

	}

}
