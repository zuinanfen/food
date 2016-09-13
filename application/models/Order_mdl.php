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

		$this->db->from(self::T_NAME,100,0);  //最多一百条
		$this->db->where('shop_id',$this->shop_id);
		if (!empty($status))
			$this->db->where_in('status',$status);
		$this->db->order_by('ctime', 'DESC');
		$query = $this->db->get();
		if($query && $query->num_rows() > 0){ 
			$res = $query->result_array();
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
	public function countSearch(){
		// $this->db->from(self::T_NAME);
		$where = "shop_id='{$this->shop_id}'";
		$this->db->where($where);
		$num = $this->db->count_all_results(self::T_NAME);

		return $num;
	}
	public function search($page){
		$this->db->from(self::T_NAME);
		$where = "shop_id='{$this->shop_id}'";

		$this->db->where($where);
		$this->db->order_by('ctime', 'desc');
		$perPage = $this->sysData['perPage'];

		$startNum = ($page-1)*$perPage;

		$this->db->limit($perPage,$startNum);
		$query = $this->db->get();
		$res = $query->result_array();
		if(empty($res)){
			return array();
		} 
		return $res;
	}
	public function get($orderId){
		$where = array(
            'id'   => $orderId,
            'shop_id'  => $this->shop_id
        );
        $this->db->where($where);
        $query = $this->db->get(self::T_NAME);
        $row = $query->result_array();
        if(empty($row)){
        	return false;
        }
		return $row[0];
	}
	//更新订单状态
	public function update_status($orderId, $status){
		$data = array(
            'status'    => $status,
            'mTime'   => date('Y-m-d H:i:s'),
        );
        $this->db->update(self::T_NAME, $data, array('id'=>$orderId));
	}
	//更改订单内容
	public function update( $orderId, $update_data= array()){
		$update_data['mTime'] = date('Y-m-d H:i:s');
        $this->db->update(self::T_NAME, $update_data, array('id'=>$orderId));
	}
	//list by time
	public function list_by_time($startTime, $endTime){
		$this->db->from(self::T_NAME);
		$this->db->where("shop_id='{$this->shop_id}' and ctime>'{$startTime}' and ctime<'{$endTime}'");
		$this->db->order_by('ctime', 'desc');
		$query = $this->db->get();
		$res = $query->result_array();
		if(empty($res)){
			return array();
		} 
		return $res;
	}
}
