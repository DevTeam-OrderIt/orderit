<?php
class Product_model extends CI_Model
{

    function __construct()
	{
		parent::__construct();
	}

	public function product_list(){
       $this->db->select('p.product_name,p.other_name,p.mrp_price,p.price,p.no_of_product,p.discount,p.offer_msg,c.name,u.unite_name,p.description,p.services,p.units,p.search_tags');
       $this->db->from('product p');
       $this->db->join('category c','c.id=p.category_id','INNER');
       $this->db->join('unit u','u.id=p.unit_id','INNER');
       $this->db->where(['u.delete_status'=>'0']);
       $this->db->order_by('p.id','DESC');
       $query = $this->db->get();
       return $query->result_array();
	}
  
  function generateOrderId(){
      $last_row =$this->db->select('order_id')->order_by('id',"desc")->limit(1)->get('orders');
      if ($last_row->num_rows() > 0) {
        $or=$last_row->result_array();
        preg_match_all('!\d+!', $or[0]['order_id'], $matches);
        $order = $matches[0][0]+1;
        $order ='ORDER'.$order;
        
      } else {
        $order = 'ORDER1000';
      }
      
      return $order;
      
  }
	

  


  


  


  



}

?>