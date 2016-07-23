<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends NB_Controller {

	protected $_allow_role = array(1,3);
	function __construct () {
		parent::__construct();
		$this->load->model('dish_mdl');
		$this->load->model('order_mdl');
	}

	public function index ()
	{
		$dish_list = $this->dish_mdl->list_by_status(array(0));

		$this->output_data(array(
			'list' => $dish_list,
			'src_type' => Order_mdl::$src_type,
		));
	}

	public function cart () {
		$order_dish = @json_decode($_COOKIE['order_dish']);
		if(empty($order_dish)){
			$order_dish = array();
		}
		$dish_list = $this->dish_mdl->list_by_status(array(0), TRUE);

		$this->output_data(array(
			'cart_list' => $order_dish,
			'dish_list' => $dish_list,
			'src_type' => Order_mdl::$src_type
		));
	}

}
