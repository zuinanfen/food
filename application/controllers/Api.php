<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends NB_Controller {
	protected $key = 'appzuinanfen!@#';


	function __construct () {
		parent::__construct();
		$this->load->model('discountconfig_mdl');
		$this->load->model('discountcard_mdl');
		$check = $this->check();
		// if(!$check){
		// 	echo 'no access!';
		// 	die;
		// }
	}
	//验证权限
	private function check(){
		$time = $this->get('time');
		$skey = $this->get('skey');
		if(empty($time) || empty($skey)){
			return false;
		}
		if(time() - $time >　60*3){ //3分钟超时

		}
		if(md5($key.$time) != $skey){
			return false;
		}

	}
	public function cardlist(){
		$list = $this->discountconfig_mdl->list_by_status(1);
		// $discountType = $this->config->item('discountType');
		$this->output_json(
			array(
				'list' => $list,
			)
		);
	}
}
