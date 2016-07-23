<?php	
class Order_mdl extends NB_Model {
	
	const T_NAME = 't_order';
	
	static $status = array(
		0 => '待处理',
		1 => '已上菜',
		2 => '已结账'
	);
	static $src_type = array(
		0 => '堂食',
		1 => '百度外卖',
		2 => '美团外卖',
		3 => '电话订餐',
		9 => '其他',
	);
	static $pay_type = array(
		0 => '现金',
		1 => '支付宝',
		2 => '微信',
		3 => '外卖App',
		9 => '其他',
	);

	/**********************************************************
	 * inherit gen_new,get,set,list_all functions from parent *
	 *********************************************************/

	public function list_by_status($status=null, $return_by_id=false) {
		$res = array();

		$this->db->from(self::T_NAME);
		if (!empty($status))
			$this->db->where_in('status',$status);
		$this->db->order_by('order_time', 'DESC');
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

}
