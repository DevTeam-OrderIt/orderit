<?php
class Dashboard_model extends CI_Model
{
	

	public function categories(){
		$data = $this->db->select('id,name,image')->order_by('name')->get('category')->result();
		$category=[];
		foreach ($data as $row) {
		    if ($row->image!='') {
		        $row->image = base_url().'public/image_gallary/upload/'.$row->image;
		    }
		    
		    array_push($category, $row);
		    
		}
		return $category;
	}

	public function getBanners(){
		$data = $this->db->select('title,description,images')->where(['delete_status'=>'0'])->order_by('id','desc')->get('slider')->result();
		$banner=[];
		foreach ($data as $row) {
		    if ($row->images!='') {
		        $row->images = base_url().'public/image_gallary/upload/'.$row->images;
		    }
		    
		    array_push($banner, $row);
		    
		}
		return $banner;
	}


	// get tranidng view product
	public function trandingProduct(){
		$data = $this->db->order_by('product_name')->get_where('product',['delete_status'=>'0','services'=>'trending'])->result();
        return $product = $this->data_formate($data);		
	}

	// get tranidng view product
	public function getRecentViewProduct(){
		$data = $this->db->order_by('product_name')->limit(10)->get_where('product',['delete_status'=>'0','services'=>'trending'])->result();
        return $product = $this->data_formate($data);		
	}



	// product data formate
	public function data_formate($data){
        $product=[];
        foreach ($data as $row) {
            if ($row->images!='') {
                $img_arr = explode(',', $row->images);
                $img_r=[];
                foreach ($img_arr as $img) {
                   $imgs = base_url().'public/image_gallary/upload/'.$img;
                   array_push($img_r, $imgs);
                }
            }

            $p['id']=$row->id;
            $p['product_name']=$row->product_name;
            $p['other_name']=$row->other_name;
            $p['images']=$img_r;
            $p['offer_msg']=$row->offer_msg;
            if ($row->discount_type=='%') {
                $price = $row->mrp_price - ($row->mrp_price*$row->discount)/100;
            } else {
                $price = $row->mrp_price - $row->discount;
            }
            
            $p['price']=$price;
            $p['mrp_price']=$row->mrp_price;
            $p['discount']=$row->discount;
            $p['discount_type']=$row->discount_type;

            array_push($product, $p);
            
        }
        return $product;
    }



}

?>