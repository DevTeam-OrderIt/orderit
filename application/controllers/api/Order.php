<?php
error_reporting(0);
header("Access-Control-Allow-Headers: Origin, token, X-Requested-With, Content-Type, content-type, Accept, Authorization");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
defined('BASEPATH') OR exit('No direct script access allowed');


class Order extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel', 'user');
        $this->load->model('Product_model', 'product');
        $this->form_validation->set_error_delimiters('~', '');
        $this->jsonData = json_decode(file_get_contents("php://input"));
    }



    public function confirm_order() {
        try {
            isValidMethodType($this->input->method(), 'post');
            $user = authenticateUser();
            $this->form_validation->set_rules('payment_id', 'payment_id', 'trim|required');
            $this->form_validation->set_rules('payment_method', 'payment_method', 'trim|required');
            $this->form_validation->set_rules('address_id', 'address_id', 'trim|required');
            $this->form_validation->set_rules('amount', 'amount', 'trim|required');

            $order_id = $this->product->generateOrderId();
            
            $user = $this->db->get_where('users',['user_id'=>$user->user_id])->row_array();
            $add = $this->db->get_where('tbl_delivery_address',['id'=>$this->jsonData->address_id])->row_array();
            $door_no = ($add['door_no'] != '') ? 'door no- '.$add['door_no'] : '';
            $floo_no = ($add['floo_no'] != '') ? ', flor no- '.$add['floo_no'] : '';
            $building_no = ($add['building_no'] != '') ? ', building no- '.$add['building_no'] : '';
            $appartment_name = ($add['appartment_name'] != '') ? ', appartment name- '.$add['appartment_name'] : '';
            $street = ($add['street'] != '') ? ', street- '.$add['street'] : '';
            $near_by = ($add['near_by'] != '') ? ', near by- '.$add['near_by'] : '';
            $locality = ($add['locality'] != '') ? ', locality- '.$add['locality'] : '';
            $city = ($add['city'] != '') ? ', city- '.$add['city'] : '';
            $district = ($add['district'] != '') ? ', district- '.$add['district'] : '';
            $state = ($add['state'] != '') ? ', state- '.$add['state'] : '';
            $pincode = ($add['pincode'] != '') ? ', pincode- '.$add['pincode'] : '';


            $shiping_address = $door_no.$floo_no.$building_no.$appartment_name.$street.$near_by.$locality.$city.$district.$state.$pincode;
            $details=[];
            $details['name'] = $user['first_name'].' '.$user['last_name'];
            $details['phone'] = $user['phone'];
            $details['email'] = $user['email'];
            
            $order=array(
                'order_id'=>$order_id,
                'user_id'=>$user['user_id'],
                'token'=>uniqe_device(),
                'amount'=>$this->jsonData->amount,
                'shipping_address'=>$shiping_address,
                'customer_name'=>$user['first_name'].' '.$user['last_name'],
                'customer_phone'=>$user['phone'],
                'customer_email'=>$user['email'],
                'order_status'=>'0',
                'delivery_boys_id'=>0,
                'create_date'=>date('Y-m-d H:i:s'),
                'payment_date'=>date('Y-m-d H:i:s'),
                'payment_status'=>'1',
                'payment_method'=>$this->jsonData->payment_method,
                'payment_id'=>$this->jsonData->payment_id,

            );
            
            $q = $this->db->insert('orders',$order);
            $this->db->where(['user_id'=>$user['user_id'],'status'=>'0'])->update('cart',['status'=>'1']);
            
            response('Order success', true, []);
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }

    public function view_cart() {
        try {
            isValidMethodType($this->input->method(), 'get');
            $user = authenticateUser();
            /*echo $user->user_id;*/
            $cart_data = $this->db->get_where('cart',['user_id'=>$user->user_id,'status'=>'0'])->result_array();
            $cart_list=[];
            $amount=[];
            $discount=[];
            
            foreach ($cart_data as $cart) {
                $c['quantity']=$cart['quantity'];
                if ($cart['discount_type']=='%') {
                    $price = $cart['price_per_unit'] - ($row->mrp_price*$cart['discount'])/100;
                } else {
                    $price = $cart['price_per_unit'] - $cart['discount'];
                }
                $c['mrp_price']= strval($cart['price_per_unit']);
                $c['total_price'] = strval($cart['total_price']);
                $c['discount_type']=$cart['discount_type'];
                $c['discount']= strval($cart['discount']);
                //$c['total_price']= $cart['total_price'];
                $c['product_id']=$cart['product_id'];

                $product = $this->db->get_where('product',['id'=>$cart['product_id']])->row_array();

                $c['product_name']=$product['product_name'];
                $c['other_name']=$product['other_name'];
                

                $c['images'] = $this->get_product_images($product['images']);
                array_push($cart_list, $c);
                array_push($amount, $cart['total_price']);
                array_push($discount, $c['discount']);
                
            }
            $amount = array_sum($amount);
            $discount = array_sum($discount);
            $data['total_mrp_price']=strval($amount+$discount);
            $data['amount']=strval($amount);
            $data['discount']=strval($discount);
            $data['delivery_charge']=strval(40);
            $data['cart_list']=$cart_list;
                

            response('cart list', true, $data);
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }

    // view cart count product
    public function cart_count() {
        try {
            isValidMethodType($this->input->method(), 'get');
            $user = authenticateUser();
            $total_price = $this->db->select_sum('total_price')->get_where('cart',['user_id'=>$user->user_id,'status'=>'0'])->row()->total_price;
            $total_count = $this->db->get_where('cart',['user_id'=>$user->user_id,'status'=>'0'])->num_rows();
            
            $cart_list=[];
            $cart_list["total_price"] = $total_price;
            $cart_list["total_count"] = $total_count;
            
            response('cart details', true, $cart_list);
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
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


    // order list
    // Login
    public function order_list(){
        try {
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            $user = authenticateUser();
            // Form Validation
            $this->form_validation->set_rules('status', 'status', 'trim|required');
            
               
            if($this->form_validation->run() == FALSE){
                $err = getErrors(validation_errors());
                response('validation failed', 'false', (object)[], $err);
            } else{
                $data = $this->db->order_by('create_date')->get_where('orders',['user_id'=>$user->user_id])->result_array();
                $order_list=[];
                foreach ($data as $order) {
                    $or['order_id']=$order['order_id'];
                    $or['create_date']=$order['create_date'];
                    $or['order_status']=$order['order_status'];
                    $or['amount']=$order['amount'];
                    $or['payment_date']=$order['payment_date'];
                    $or['payment_status']=$order['payment_status'];
                    $or['payment_method']=$order['payment_method'];
                    $or['payment_id']=$order['payment_id'];

                    $cart_data = $this->db->get_where('cart',['user_id'=>$user->user_id,'order_id'=>$order['order_id']])->result_array();
                    $product_list=[];
                    
                    foreach ($cart_data as $cart) {
                        $c['quantity']=$cart['quantity'];
                        $c['discount']=$cart['discount'];
                        $c['total_price']=$cart['total_price'];
                        $c['product_id']=$cart['product_id'];

                        $product = $this->db->get_where('product',['id'=>$cart['product_id']])->row_array();

                        $c['product_name']=$product['product_name'];
                        $c['other_name']=$product['other_name'];
                        $c['images'] = $this->get_product_images($product['images']);
                        array_push($product_list, $c);
                        
                    }

                    $or['products']=$product_list;
            

                    array_push($order_list, $or);

                }
                response('order list', true, $order_list); 
                  
            }
                
                
            
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }
    
     
    
}