<?php	
class Role_mdl extends NB_Model {
	
	const T_NAME = 't_role';

	/************************************************
	 * inherit gen_new,get,set functions from paren *
	 ************************************************/

	public function list_by_status($status=array()) {
		$res = array();

		$this->db->from(self::T_NAME);
		if (!empty($status))
			$this->db->where_in('status',$status);
		$query = $this->db->get();
		if($query && $query->num_rows() > 0){ 
			$res = $query->result_object();
		}   

		return $res;
	}

}
