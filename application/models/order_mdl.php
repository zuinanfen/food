<?php	
class Order_mdl extends NB_Model {
	
	const T_NAME = 't_order';

	static $status = array (
		0 => '正常',
		1 => '冻结',
	);

	/**********************************************************
	 * inherit gen_new,get,set,list_all functions from parent *
	 *********************************************************/

	public function list_by_status($status=null, $return_by_id=false) {
		$res = array();

		$this->db->from(self::T_NAME);
		if (!empty($status))
			$this->db->where_in('status',$status);
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
