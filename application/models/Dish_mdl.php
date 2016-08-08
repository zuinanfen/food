<?php	
class Dish_mdl extends NB_Model {
	
	const T_NAME = 't_dish';

	static $status = array (
		0 => '正常',
		1 => '已下架',
		2 => '未上架',
	);

	/**********************************************************
	 * inherit gen_new,get,set,list_all functions from parent *
	 *********************************************************/

	public function list_by_status($status=null, $return_by_id=false) {
		$res = array();

		$this->db->from(self::T_NAME);
		if (!empty($status))
			$this->db->where_in('status',$status);
		$this->db->order_by('sort','DESC');
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
