<?php	
class Income_mdl extends NB_Model {
	
	const T_NAME = 't_income';

	/**********************************************************
	 * inherit gen_new,get,set,list_all functions from parent *
	 *********************************************************/
	public function list_by_date($date,$incomeType=0){
		$where = array(
            'shop_id'  => $this->shop_id,
            'date'   => $date,
        );
        if($incomeType!=0){
        	$where['type_id'] = $incomeType;
        }
        $this->db->where($where);
        $query = $this->db->get(self::T_NAME);
        $row = $query->result_array();
        if(empty($row)){
        	return false;
        }
		return $row;
	}

	// public function list_by_time($startTime, $endTime){
	// 	$this->db->from(self::T_NAME);
	// 	$this->db->where("shop_id='{$this->shop_id}' and date>'{$startTime}' and date<'{$endTime}'");
	// 	$this->db->order_by('ctime', 'desc');
	// 	$query = $this->db->get();
	// 	$res = $query->result_array();
	// 	if(empty($res)){
	// 		return array();
	// 	} 
	// 	return $res;
	// }
	
}
