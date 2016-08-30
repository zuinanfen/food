<?php	
class Invoice_mdl extends NB_Model {
	
	const T_NAME = 't_invoice';

	/**********************************************************
	 * inherit gen_new,get,set,list_all functions from parent *
	 *********************************************************/
	public function userGet($user_id){
		$where = array(
			'shop_id'  => $this->shop_id,
            'user_id'   => $user_id,
        );

		$this->db->from(self::T_NAME,50,0);  //最多一百条
		$this->db->where($where);
		$this->db->order_by('ctime', 'DESC');
		$res = '';
		$query = $this->db->get();

		if($query && $query->num_rows() > 0){ 
			$res = $query->result_array();
		}
		return $res;
	}
	public function update( $id, $update_data= array()){
		$update_data['mTime'] = date('Y-m-d H:i:s');
        $this->db->update(self::T_NAME, $update_data, array('id'=>$id));
	}
	public function countSearch($data=array()){
		// $this->db->from(self::T_NAME);
		$where = "shop_id='{$this->shop_id}' and ctime>'{$data['startTime']}' and ctime<'{$data['endTime']}'";
		unset($data['startTime']);
		unset($data['endTime']);
		foreach ($data as $key => $value) {
			$where .= " and {$key}='{$value}'";
		}

		$this->db->where($where);
		$num = $this->db->count_all_results(self::T_NAME);

		return $num;
	}
	public function search($page, $data=array()){
		$this->db->from(self::T_NAME);
		$where = "shop_id='{$this->shop_id}' and ctime>'{$data['startTime']}' and ctime<'{$data['endTime']}'";
		unset($data['startTime']);
		unset($data['endTime']);
		foreach ($data as $key => $value) {
			$where .= " and {$key}='{$value}'";
		}


		$this->db->where($where);
		$this->db->order_by('ctime', 'desc');
		$perpage = 20;
		$startNum = ($page-1)*$perpage;

		$this->db->limit($perpage,$startNum);
		$query = $this->db->get();
		$res = $query->result_array();
		if(empty($res)){
			return array();
		} 
		return $res;
	}
}
