<?php	
class Order_mdl extends NB_Model {
	
	const T_NAME = 't_order';
	
	// static $status = array(
	// 	0 => '待处理',
	// 	1 => '处理完',
	// 	2 => '已付款',


	// 	8 => '已撤销'
	// );
	// static $src_type = array(
	// 	1 => '堂食',
	// 	2 => '百度外卖',
	// 	3 => '美团外卖',
	// 	4 => '电话订餐',
	// 	5 => '其他',
	// );
	// static $pay_type = array(
	// 	1 => '现金',
	// 	2 => '支付宝',
	// 	3 => '微信',
	// 	4 => '外卖App',
	// 	5 => '其他',
	// );

	/**********************************************************
	 * inherit gen_new,get,set,list_all functions from parent *
	 *********************************************************/

	public function list_by_status($status=null, $return_by_id=false) {
		$res = array();

		$this->db->from(self::T_NAME);
		if (!empty($status))
			$this->db->where_in('status',$status);
		$this->db->order_by('ctime', 'DESC');
		$query = $this->db->get();
		if($query && $query->num_rows() > 0){ 
			$res = $query->result_object();
		}   

		if ($return_by_id) {
			$res_new = array();
			foreach ($res as $obj) {
				$res_new[$obj->id] = $obj;
			}
			return $res_new;
		}
		return $res;
	}
	public function get($orderId){
		echo $orderId;
		$res = array();

		$this->db->from(self::T_NAME);
		$this->db->where_in('id',$orderId);
		$query = $this->db->get();
		if($query && $query->num_rows() > 0){ 
			$res = $query->result_object();
		}else{
			return false;
		}
		return $res;
	}
}
