<?php	
class Orderdish_mdl extends NB_Model {
	
	const T_NAME = 't_order_dish';
	
	
	
	// static $dish_status = array(
	// 	0 => '待处理',
	// 	1 => '处理中',
	// 	2 => '处理完',
	// 	3 => '已付款',

	// 	8 => '已撤销'
	// );

	/**********************************************************
	 * inherit gen_new,get,set,list_all functions from parent *
	 *********************************************************/

	public function list_by_status($status=array(), $return_by_id=false) {
		$res = array();
		$this->db->from(self::T_NAME);
		if (!empty($status)){

			$this->db->where_in('status',$status);
		}
		$this->db->order_by('ctime', 'asc');
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
	//根据订单号获取有效菜品
	public function orderlist_by_status($orderId, $status=array()){
		$this->db->where('order_id',$orderId);
        $this->db->where_in('status',$status);
        $query = $this->db->get(self::T_NAME);
        $rows = $query->result_array();
        if(empty($rows)){
        	return false;
        }
		return $rows;
	}
	//获取单个订单有效菜品列表
	public function get_dish_list($orderId){

		$status = $this->config->item('dishStatus');
		unset($status['8']); //删除掉已撤销状态
		// $statusKey = array_keys($status));
		// $statusKey = array(0,1,2);
		foreach ($status as $key => $value) {
			$statusKey[] = $key;
		}
        // $this->db->where('order_id',$orderId);
        // $this->db->where_in('status',$statusKey);
        
        // $query = $this->db->get(self::T_NAME);
        // $rows = $query->result_array();

		$statusKey = implode(',',$statusKey);

        $sql = "select * from ".self::T_NAME." where order_id='{$orderId}' and status in ({$statusKey}) order by ctime asc";
        $query = $this->db->query($sql);
        $rows = $query->result_array();
        if(empty($rows)){
        	return false;
        }
		return $rows;
	}
	//获取单个订单有效菜品列表
	public function get_all_dish_list($orderId){

		$status = $this->config->item('dishStatus');
		foreach ($status as $key => $value) {
			$statusKey[] = $key;
		}
		$statusKey = implode(',',$statusKey);

        $sql = "select * from ".self::T_NAME." where order_id='{$orderId}' and status in ({$statusKey}) order by ctime asc";
        $query = $this->db->query($sql);
        $rows = $query->result_array();
        if(empty($rows)){
        	return false;
        }
		return $rows;
	}

	//更新菜品状态
	public function update_status($id, $status){
		$data = array(
            'status'    => $status,
            'mTime'   => date('Y-m-d H:i:s'),
        );
        $this->db->update(self::T_NAME, $data, array('id'=>$id));
	}
	//获取最早下单的几个未制作的菜
	public function get_old_dish(){
		$autoUpdateDishNum = $this->config->item('autoUpdateDishNum');

		//查询制作中的菜品有几个
		$rows = $this->list_by_status(array(1));
		$do_num = count($rows);
		//假如制作中的菜品不够，则自动补上
		if($autoUpdateDishNum>$do_num){
			$this->db->where('status', 0);
	        $query = $this->db->get(self::T_NAME, $autoUpdateDishNum-$do_num, 0);
	        $this->db->order_by('ctime', 'asc');
	        $rows = $query->result_array();
	        if(empty($rows)){
	        	return false;
	        }
			return $rows;
		}

		return false;

        
	}
}
