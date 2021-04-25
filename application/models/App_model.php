<?php
class App_model extends CI_Model
{
	public function get_special_details($table,$where){
       $this->db->select('*');
       $this->db->from($table);
       $this->db->where($where);
       $query = $this->db->get();
       return $query->row_array();
	}
    public function insert($table,$data){
       return  $this->db->insert($table,$data);
    }

    public function insert_id($table,$data){
    	$this->db->insert($table,$data);
    	return $this->db->insert_id();
    }

    public function update($table,$data,$where){
    	return $this->db->where($where)->update($table,$data);
    }

    public function getRowById($table,$where){
       $this->db->select('*');
       $this->db->from($table);
       $this->db->where($where);
       $query = $this->db->get();
       return $query->row_array();
    }

    public function getResultById($table,$where){
      $this->db->select('*');
      $this->db->from($table);
      $this->db->where($where);
      $query = $this->db->get();
      return $query->result_array();
    }

    public function getAllList($table,$where,$orderBy,$ascOrDesc){
      $this->db->select('*');
      $this->db->from($table);
      $this->db->where($where);
      $this->db->order_by($orderBy,$ascOrDesc);
      $query = $this->db->get();
      return $query->result_array();

    }

    public function countByNumRow($table,$where){
       $this->db->select('*');
       $this->db->from($table);
       $this->db->where($where);
       $query = $this->db->get();
       return $query->num_rows();
    }

    public function delete($table,$where){
       return $this->db->where($where)-> delete($table);
       
    }

    public function crop_img($path){
        $upload_data = $path;
        $this->load->library('image_lib');
        $config["image_library"] = "gd2";
        $config["source_image"] = $upload_data["full_path"];
        $config['create_thumb'] = true;
        $config['maintain_ratio'] = TRUE;
        $config['new_image'] = $upload_data["file_path"] . 'product.png';
        $config['quality'] = "100%";
        $config['width'] = 231;
        $config['height'] = 154;
        $this->image_lib->clear();
        $this->image_lib->initialize($config); 
        $this->image_lib->crop();
        return true;
     }
	 
	 
	 public function userExists($mobile_number) {
        $q = $this->db->where('mobile_number', $mobile_number)->get('tbl_user');
        if($q->num_rows() > 0){
           return $q->row_array();
        } 
        throw new Exception("User does not exixts!", 1);
    }
	
	 
	
}

?>