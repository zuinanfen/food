<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('role_mdl');
	}

	public function index () {
		$list = $this->role_mdl->list_by_status();
		$this->output_data(array(
			'list' => $list
		));
	}

	public function add ()
	{
		$obj = $this->role_mdl->gen_new();
		$obj->name = "role_test";
		$this->user_mdl->set($obj);
	}

	public function set ()
	{
	}
}
