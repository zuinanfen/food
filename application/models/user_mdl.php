<?php	
class User_mdl extends NB_Model {
	
	const T_NAME = 't_user';

	static $status = array (
		0 => '正常',
		1 => '冻结',
	);

	/**********************************************************
	 * inherit gen_new,get,set,list_all functions from parent *
	 *********************************************************/

	public function get_by_name ($name) {
        //$res = $this->get_by_kvcache(static::T_NAME.'_NAME',$name);
        //if (!empty($res)) return $res;

		$res = null; 

		$this->db->from(static::T_NAME); 
		$this->db->where('name',$name); 
		$query = $this->db->get(); 
		if($query && $query->num_rows() > 0){ 
			$res = $query->row_object(); 
		}

        //$this->set_by_kvcache(static::T_NAME.'_NAME', $name, $res);
		return $res; 
	}
}
