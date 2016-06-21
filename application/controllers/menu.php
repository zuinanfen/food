<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('dish_mdl');
		$this->load->model('option_mdl');
	}

	public function index ()
	{
		$dish_list = $this->dish_mdl->list_by_status(array(0));
		$option_list = $this->option_mdl->list_all(TRUE);

		$this->output_data(array(
			'list' => $dish_list,
			'option_list' => $option_list
		));
	}

	public function cart () {
		$order_dish = @json_decode($_COOKIE['order_dish']);
		$dish_list = $this->dish_mdl->list_by_status(array(0), TRUE);
		$option_list = $this->option_mdl->list_all(TRUE);

		$this->output_data(array(
			'cart_list' => $order_dish,
			'dish_list' => $dish_list,
			'option_list' => $option_list
		));
	}

}
