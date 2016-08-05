<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {
    function __construct() {
        // parent::__construct();
        $this->ci = & get_instance();
        $this->order_status = $this->ci->config->item('orderStatus');
        $this->order_source = $this->ci->config->item('orderSource');
        $this->pay_type = $this->ci->config->item('payType');
        $this->dish_status = $this->ci->config->item('dishStatus');
    }
    public function init_order($order_content){
        $order_content['statusName'] = $this->order_status[$order_content['status']];
        $order_content['sourceName'] = $this->order_source[$order_content['src']];
        $order_content['payTypeName'] = $this->pay_type[$order_content['pay_type']];
        $order_content['orderTime'] = date('m-d H:i:s', strtotime($order_content['ctime']));
        $order_content['dish_list'] = json_decode($order_content['dish_list'], true);        
        return $order_content;
    }
    public function init_dish($dish_content){
        $dish_content['select_options'] = json_decode($dish_content['select_options'], true);
        $dish_content['statusName'] = $this->dish_status[$dish_content['status']];

        return $dish_content;
    }
}
