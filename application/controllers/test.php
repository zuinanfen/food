<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('user_mdl');
	}

	public function index () {
		$user_list = $this->user_mdl->list_by_status();
		$this->output_data(array(
			'list' => $user_list
		));
	}

	public function add ()
	{
		$obj = $this->user_mdl->gen_new();
		$obj->name = "test";
		$this->user_mdl->set($obj);
	}

	public function set ()
	{
	}
}
