<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends NB_Controller {

	function __construct () {
		parent::__construct();
		$this->load->library('Validatecode');
	}

	public function apply () {
		


		$this->output_data(
			
		);
	}
	public function apply_add () {
		


		
	}
	public function showcode(){
		session_start();
		$this->validatecode->showImage();   //输出到页面中供 注册或登录使用
		$_SESSION["code"]=$this->validatecode->getCheckCode();  //将验证码保存到服务器中
	}
	
}
