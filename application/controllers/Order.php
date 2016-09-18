<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends NB_Controller {

	// protected $_allow_role = array(1);
	function __construct () {
		parent::__construct();
		$this->load->model('order_mdl');
		$this->load->model('user_mdl');
		$this->load->model('dish_mdl');
		// $this->load->model('option_mdl');
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

		$cookies = $this->input->cookie();
		$ctime = date('Y-m-d H:i:s');
        $orderId = $this->getOrderId($cookies['id'], strtotime($ctime));

        $obj->id = $orderId;
        $obj->src = $order_src;
        $obj->table_id = $order_table_seat;
        $obj->uid = $cookies['id'];
        $obj->status = 0;
        // $obj->dish_list = json_encode($dish_list);
        $obj->ctime = $ctime;
        $obj->mtime = $ctime;
		$obj->dish_num = count($dish_list);


        //先循环插入菜品
        $amount = $this->insertOrderDish($orderId, $dish_list); //获取总价

        $obj->amount = $amount;
        $obj->pay_amount = $amount;
        //继续插入订单
		$this->order_mdl->set($obj);
		$this->output_json(array('orderId'=>$orderId));
	}
	private function insertOrderDish($orderId, $dish_list){
		$obj = $this->orderdish_mdl->gen_new();
		$obj->order_id = $orderId;
		$obj->uid = $this->input->cookie('id');
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
			$obj->pay_amount = $totalPrice;
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

		// //重新结算订单
		// $dishList = $this->orderdish_mdl->get_dish_list($orderId);
		// if(count($dishList)<2){
		// 	$this->set_error(static::RET_WRONG_INPUT, "该订单只有一个菜品，无法删除，请直接撤销订单！");
		// 	return $this->output_json();
		// }
		//读取菜品状态，只有未处理，和处理中的允许撤销
		$info = $this->orderdish_mdl->get($dishId);
		if(!in_array($info['status'], array(0,1))){
			$this->set_error(static::RET_WRONG_INPUT, "该菜品不允许撤销！");
			return $this->output_json();
		}


		//更改菜品状态
		$this->orderdish_mdl->update_status($dishId, 8);
		//读取有效的菜品
		$res = $this->orderDishInit($orderId);

		//更改订单价格和商品数量
		$update_data = array(
			// 'dish_list' => json_encode($orderDishList),
			'dish_num'  => $res['dish_num'],
			'amount'    => $res['amount'],
			'status'    => $res['status'],
			'pay_amount'=> $res['pay_amount'],
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
	//加菜
	public function addDish(){
		$orderId = $this->post('orderId');
		if(!preg_match("/^[A-Za-z0-9]+$/",$orderId)){
			$this->set_error(static::RET_WRONG_INPUT, "非法请求");
			return $this->output_json();
		}

		$detail = $this->order_mdl->get($orderId);
		if($detail == false){
			$this->set_error(static::RET_WRONG_INPUT, "订单数据不存在！");
			return $this->output_json();
		}

		if(!in_array($detail['status'], array(0,1,2))){
			$this->set_error(static::RET_WRONG_INPUT, "该订单状态不允许添加菜品！");	
			return $this->output_json();
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

        $this->insertOrderDish($orderId, $dish_list); //循环插入菜品

        // $new_dish_list = json_decode($detail['dish_list'], true) + $dish_list;

        

        //计算菜品总价，菜品数量，菜品list
        $res = $this->orderDishInit($orderId);


		$data = array(
			'status'   => $res['status'],
			'dish_num' => $res['dish_num'],
			'amount'   => $res['amount'],
			'pay_amount' => $res['pay_amount'],
		);

        //继续插入订单
		$this->order_mdl->update($orderId, $data);
		$this->output_json();

	}

	//初始化订单菜品，计算一些数据
	private function orderDishInit($orderId){

		//获取菜品列表
        $db_dish_list = $this->orderdish_mdl->get_dish_list($orderId);
        if(!$db_dish_list){
 			return array('amount'=>0,'dish_num'=>0,'status'=>8);
        }

        $amount = 0;
        $pay_amount = 0;
        $dish_num = count($db_dish_list);


        $status_arr = array();

        $dishStatus = $this->config->item('dishStatus');

        foreach ($dishStatus as $k => $v) {
    		$status_arr[$k] = 0;
    	}

        if($dish_num>0){
			foreach ($db_dish_list as $k => $v) {
        		$amount = bcadd($amount, $v['total_price'], 2);
        		$pay_amount = bcadd($pay_amount, $v['pay_amount'], 2);
        		$status_arr[$v['status']] = intval($status_arr[$v['status']]) + 1;
        	}
        }

        $res = array('amount'=>$amount,'dish_num'=>$dish_num,'pay_amount'=>$pay_amount,'status'=>8);

        //以菜品状态来决定订单状态
        if($status_arr[0]>0){ //有未完成的菜品
        	$res['status'] = 0;
        	return $res;
        }
        if($status_arr[1]>0){ //有处理中的菜品
        	$res['status'] = 1;
        	return $res;
        }
        
        if($status_arr[2] == $dish_num){  //若所有菜都已经上菜，则订单为为菜上齐状态
        	$res['status'] = 2;
        	return $res;
        }
        return $res;
	}
	public function change_amount(){
		$pay_amount = $this->post('pay_amount');
		if(empty($pay_amount)){
			$this->set_error(static::RET_WRONG_INPUT, "实收金额不能为空");	
			return $this->output_json();
		}
		if(!preg_match("/^[0-9]+(.[0-9]{2})?$/", $pay_amount)){
			$this->set_error(static::RET_WRONG_INPUT, "实收金额格式不正确，小数点后面应该有两位数");	
			return $this->output_json();
		}
		$dishId = $this->post('dishId');
		if(empty($dishId)){
			$this->set_error(static::RET_WRONG_INPUT, "数据出错，请联系管理员");	
			return $this->output_json();
		}
		$orderId = $this->post('orderId');
		if(empty($orderId)){
			$this->set_error(static::RET_WRONG_INPUT, "订单id不能为空！");	
			return $this->output_json();
		}
		$detail = $this->order_mdl->get($orderId);
		if($detail == false){
			$this->set_error(static::RET_WRONG_INPUT, "订单数据不存在！");
			return $this->output_json();
		}
		$now = time();
		$order_date = strtotime($detail['ctime']);
		if($now - $order_date > 60*60*24){
			$this->set_error(static::RET_WRONG_INPUT, "无法更改12小时之前的菜品价格，请联系管理员！");
			return $this->output_json();
		}
		$info = $this->orderdish_mdl->get($dishId);
		if(empty($info)){
			$this->set_error(static::RET_WRONG_INPUT, "菜品数据不存在！");
			return $this->output_json();
		}
		if($pay_amount == $info['total_price']){
			$discount = 0;
		}else{
			$discount = ceil($pay_amount/$info['total_price']*10000)/100;
		}
		$this->orderdish_mdl->update_pay($dishId,$pay_amount,$discount);

		//计算订单金额
		//计算菜品总价，菜品数量，菜品list
        $res = $this->orderDishInit($orderId);
        if( $res['amount'] == $res['pay_amount']){
			$discount = 0;
		}else{
			$discount = ceil($res['pay_amount']/$res['amount']*10000)/100;
		}
		$data = array(
			'amount'   => $res['amount'],
			'pay_amount' => $res['pay_amount'],
			'discount'  => $discount,
		);

        //继续插入订单
		$this->order_mdl->update($orderId, $data);
		$this->output_json();		

	}
}
