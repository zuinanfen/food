<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends NB_Controller {

	protected $_allow_role = array(1);
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
	public function edit () {
		$id = $this->get('id', 'num');
		$order_detail = $this->order_mdl->get($id);
		$user_list = $this->user_mdl->list_by_roleid(array(3));
		$dish_list = $this->dish_mdl->list_all(TRUE);
		$option_list = $this->option_mdl->list_all(TRUE);
		$this->output_data(array(
			'detail' => $order_detail,
			'src_type' => Order_mdl::$src_type,
			'pay_type' => Order_mdl::$pay_type,
			'status_list' => Order_mdl::$status,
			'user_list' => $user_list,
			'dish_list' => $dish_list,
			'option_list' => $option_list
		));
	}

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

	public function set ()
	{
		$id = $this->post("id");
		if (empty($id)) {
			$this->set_error(static::RET_WRONG_INPUT, "错误的参数ID");	
			return $this->output_json();
		}

		$obj = $this->order_mdl->get($id);
		if (empty($obj)) {
			$this->set_error(static::RET_ERROR_DATA, "找不到对象");	
			return $this->output_json();
		}

		$src = $this->post("src"); if (isset($src) && $src>=0) $obj->src = $src;
		$table_id = $this->post("table_id"); if (isset($table_id) && !empty($table_id)) $obj->table_id = $table_id;
		$order_time = $this->post("order_time", 'date'); if (isset($order_time) && !empty($order_time)) $obj->order_time = $order_time;
		$order_user = $this->post("order_user", 'integer'); if (isset($order_user) && $order_user>=0) $obj->order_user = $order_user;
		$status = $this->post("status", 'integer'); if (isset($status) && $status>=0) $obj->status = $status;
		$dish_list = $this->post("dish_list", 'json'); if (isset($dish_list) && !empty($dish_list)) $obj->dish_list = $dish_list;
		$dish_num = $this->post("dish_num", 'integer'); if (isset($dish_num) && $dish_num>=0) $obj->dish_num = $dish_num;
		$remark = $this->post("remark"); if (isset($remark) && !empty($remark)) $obj->remark = $remark;
		$amount = $this->post("amount", 'money'); if (isset($amount) && $amount>=0) $obj->amount = $amount;
		$pay_amount = $this->post("pay_amount", 'money'); if (isset($pay_amount) && $pay_amount>=0) $obj->pay_amount = $pay_amount;
		$discount = $this->post("discount", 'number'); if (isset($discount) && $discount>=0) $obj->discount = $discount;
		$pay_type = $this->post("pay_type", 'integer'); if (isset($pay_amount) && $pay_amount>=0) $obj->pay_amount = $pay_amount;

		$this->order_mdl->set($obj);
		$this->output_json();
	}
}
