<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('order_mdl');
	}

	public function index () {
		$order_list = $this->order_mdl->list_by_status();
		$this->output_data(array(
			'list' => $order_list
		));
	}

	public function add ()
	{
		$obj = $this->order_mdl->gen_new();
		$obj->name = "test";
		$this->order_mdl->set($obj);
	}

	public function set ()
	{
	}
}
