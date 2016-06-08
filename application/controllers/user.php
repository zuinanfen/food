<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('user_mdl');
		$this->load->model('role_mdl');
	}

	public function index () {
		$user_list = $this->user_mdl->list_by_status();
		$this->output_data(array(
			'list' => $user_list
		));
	}
	public function edit () {
		$id = $this->get('id', 'num');
		$user_detail = $this->user_mdl->get($id);

		$role_list = $this->role_mdl->list_by_status();
		$this->output_data(array(
			'detail' => $user_detail,
			'role_list' => $role_list
		));
	}

	public function add () {
		$role_list = $this->role_mdl->list_by_status();
		$this->output_data(array(
			'role_list' => $role_list
		));
	}

	public function add_submit ()
	{
		$obj = $this->user_mdl->gen_new();
		$obj->name = "test";
		$this->user_mdl->set($obj);
	}

	public function set ()
	{
	}
}
