<?php
error_reporting(0);
header("Access-Control-Allow-Headers: Origin, token, X-Requested-With, Content-Type, content-type, Accept, Authorization");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
defined('BASEPATH') OR exit('No direct script access allowed');


class Product extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel', 'user');
        $this->form_validation->set_error_delimiters('~', '');
        $this->jsonData = json_decode(file_get_contents("php://input"));
    }



    public function trending_product() {
        try {
            isValidMethodType($this->input->method(), 'get');
            $user = authenticateUser();
            $data = $this->db->order_by('product_name')->get_where('product',['delete_status'=>'0','services'=>'trending'])->result();
            $product = $this->data_formate($data);
            response('product list', true, $product);
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }




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
                //$row->images = base_url().'public/image_gallary/upload/'.$row->images;
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


    public function product_list() {
        try {
            isValidMethodType($this->input->method(), 'get');
            $user = authenticateUser();
            $data = $this->db->order_by('product_name')->get_where('product',['delete_status'=>'0'])->result();
            $product = $this->data_formate($data);
            response('product list', true, $product);
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }

    // product data
    public function category_product(){
        try{
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            $user = authenticateUser();
            $this->form_validation->set_rules('category_id', 'category_id', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', false, (object)[], $err);
            } else{
                $data = $this->db->order_by('product_name')->get_where('product',['delete_status'=>'0','category_id'=>$this->jsonData->category_id])->result();
                $product = $this->data_formate($data);
                response('product list', true, $product);
            }
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }


    // product details 
    public function product_details(){
        try{
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            $user = authenticateUser();
            $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', false, (object)[], $err);
            } else{
                $productDetails=[];
                $data = $this->db->order_by('product_name')->get_where('product',['delete_status'=>'0','id'=>$this->jsonData->product_id])->row_array();
                $productDetails['id'] = $data['id'];
                $productDetails['product_name'] = $data['product_name'];
                $productDetails['other_name'] = $data['other_name'];

                $productDetails['images'] = $this->get_product_images($data['images']);
                $productDetails['offer_msg'] = $data['offer_msg'];
                if ($data['discount_type'] == '%') {
                    $price = $data['mrp_price'] - ($data['mrp_price']*$data['discount'])/100;
                } else {
                    $price = $data['mrp_price'] - $data['discount'];
                }
                
                
                $productDetails['price'] = $price;
                $productDetails['mrp_price'] = $data['mrp_price'];
                $productDetails['discount'] = $data['discount'];
                $productDetails['discount_type'] = $data['discount_type'];
                $productDetails['units'] = $this->get_units($data['units']);

                $cart_check = $this->db->get_where('cart',['product_id'=>$this->jsonData->product_id,'user_id'=>$user->user_id,'status'=>'0'])->row_array();
            
                if (count($cart_check) > 0) {
                        $productDetails['add_in_cart'] = true;
                        $productDetails['quantity'] = $cart_check['quantity'];

                    } else {
                        $productDetails['add_in_cart'] = false;
                        $productDetails['quantity'] = 0;
                    }
                  
                response('product details', true, $productDetails);
            }
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }

    function get_units($units){

        $unit_id_arr = explode(',', $units);
        $unitss = '';
        $all_unit=[];
        foreach ($unit_id_arr as $key=>$value) {
             $unit = $this->db->get_where('unit',['id'=>$value])->row_array();
             $r['unite_value'] = $unit['unite_value'];
             $r['unite_name'] = $unit['unite_name'];
             array_push($all_unit, $r);
        }
        return $all_unit;
    }


    public function get_product_images($images){
        $img_r=[];
        if ($images!='') {
            $img_arr = explode(',', $images);
            $img_r=[];
            foreach ($img_arr as $img) {
               $imgs = base_url().'public/image_gallary/upload/'.$img;
               array_push($img_r, $imgs);
            }
            
        }
        return $img_r;
    }
   
    
    
}