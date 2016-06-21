<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class NB_Model extends CI_Model {

    protected $kvcache_switch_on = FALSE;

	function __construct () {
		if (!static::T_NAME) {
			exit("need T_NAME!");
		}
		parent::__construct();
		$this->load->database();
	}

	public function get_insert_id(){
		return $this->db->insert_id();
	}

	public function gen_new ($obj = null){ 
		$obj_new = new stdClass(); 
		$obj_new->id = NULL; 

		$obj_new->ctime	= isset($obj->ctime)? $obj->ctime : date("Y-m-d H:i:s");
		$obj_new->mtime	= isset($obj->mtime)? $obj->mtime : date("Y-m-d H:i:s");
		return $obj_new; 
	}
	
	public function get($id){
        //$res = $this->get_by_kvcache(static::T_NAME,$product_id);
        //if (!empty($res)) return $res;

		$res = null; 

		$this->db->from(static::T_NAME); 
		$this->db->where('id',$id); 
		$query = $this->db->get(); 
		if($query && $query->num_rows() > 0){ 
			$res = $query->row_object(); 
		}

        //$this->set_by_kvcache(static::T_NAME, $id, $res);
		return $res; 
	}
	
	public function set($obj){
		$obj->mtime = date('Y-m-d H:i:s');
        //$this->set_by_kvcache(static::T_NAME,$obj->id, $obj);
		return $this->db->replace(static::T_NAME, $obj); 
	}

	public function list_all($return_by_id=false) {
		$res = array();

		$this->db->from(static::T_NAME);
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
		} else {
			return $res;
		}
	}

	// ================ private functions ================
	protected function array2map($res, $key='id') {
		$res_new = array();
		foreach ($res as $obj) {
			if (isset($obj->$key)) {
				$res_new[$obj->$key] = $obj;
			}
		}

		return $res_new;
	}
	
	protected function get_cache_table ($tablename) {
		return $tablename.'_cache';
	}
	
	protected function replicate_create_cache_table ($tablename) {
		$res = $this->db->query("CREATE TABLE IF NOT EXISTS ". $this->get_cache_table($tablename) ." LIKE {$tablename}");
		if ($res) {
			$this->db->query("ALTER TABLE ". $this->get_cache_table($tablename) ." ENGINE=MEMORY");
		}
		$res = $this->db->query("TRUNCATE TABLE ". $this->get_cache_table($tablename));
		return $res;
	}

	protected function get_by_kvcache ($tablename, $key) {
        return $this->kvcache_switch_on? $this->kv_cache->hget($tablename, $key) : NULL;
    }

    protected function set_by_kvcache ($tablename, $key, $val) {
        if ($this->kvcache_switch_on) {
            if (is_null($val)) {
                $this->kv_cache->hdel($tablename, $key);
            } else {
                $this->kv_cache->hset($tablename, $key, $val);
            }
        }
    }
	
}

