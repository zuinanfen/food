<?php	
class User_mdl extends NB_Model {
	
	const T_NAME = 't_user';
	// static $role_id = array(
	// 	0 => '未分配',
	// 	1 => '系统管理员',
	// 	2 => '厨师',
	// 	3 => '点餐员',
	// 	4 => '上菜员',
	// );
	// static $status = array (
	// 	0 => '正常',
	// 	1 => '冻结',
	// );

	/**********************************************************
	 * inherit gen_new,get,set,list_all functions from parent *
	 *********************************************************/

	public function list_by_roleid($role_list, $return_by_id=false) {
		$res = array();
		$this->db->from(static::T_NAME);
		$this->db->where_in('role_id',$role_list); 
		$query = $this->db->get(); 
		if($query && $query->num_rows() > 0){ 
			$res = $query->result_object(); 
		}

		if ($return_by_id) {
			return $this->array2map($res);
		}

		return $res; 
	}

	public function get_by_uid ($uid) {
        //$res = $this->get_by_kvcache(static::T_NAME.'_NAME',$name);
        //if (!empty($res)) return $res;

		$res = null; 

		$this->db->from(static::T_NAME); 
		$this->db->where('uid',$uid); 
		$query = $this->db->get(); 
		if($query && $query->num_rows() > 0){ 
			$res = $query->row_object(); 
		}

        //$this->set_by_kvcache(static::T_NAME.'_NAME', $name, $res);
		return $res; 
	}
}
