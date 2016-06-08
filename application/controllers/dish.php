<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dish extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('dish_mdl');
	}

	public function index () {
		$dish_list = $this->dish_mdl->list_by_status();
		$this->output_data(array(
			'list' => $dish_list
		));
	}

	public function add ()
	{
		$obj = $this->dish_mdl->gen_new();
		$obj->name = "test";
		$this->dish_mdl->set($obj);
	}

	public function set ()
	{
	}
}
