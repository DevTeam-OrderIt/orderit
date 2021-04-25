<?php
error_reporting(0);
header("Access-Control-Allow-Headers: Origin, token, X-Requested-With, Content-Type, content-type, Accept, Authorization");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel', 'user');
        $this->load->model('app_model');
        date_default_timezone_set("Asia/Kolkata");
        //$this->load->model('Orders', 'order');
        $this->form_validation->set_error_delimiters('~', '');
        $this->jsonData = json_decode(file_get_contents("php://input"));
    }

    // regietrt
    public function register(){
        try {
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            // Form Validation
            $this->form_validation->set_rules('first_name', 'first name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'last name', 'trim|required');
            $this->form_validation->set_rules('email', 'email', 'trim|required');
            $this->form_validation->set_rules('phone', 'phone', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required');

               
            if($this->form_validation->run() == FALSE){
                $err = getErrors(validation_errors());
                response('validation failed', 'false', (object)[], $err);
            } else{
                $check_email = $this->db->where(['email'=>$this->jsonData->email])->get('users')->num_rows();
                if ($check_email==0) {
                    $check_phone = $this->db->where(['phone'=>$this->jsonData->phone])->get('users')->num_rows();
                        if ($check_phone==0) {
                            $this->jsonData->add_on = date('d-m-Y H:i:s');
                            $this->jsonData->status=1;
                            $q = $this->app_model->insert('users',$this->jsonData);
                            $user_id=$this->db->insert_id();
                            $this->db->where(['user_id'=>$user_id])->update('users',['userid'=>'USER'.$user_id]);
                            $result = $this->user->get_login_token($user_id);
                            response('register success!', true, (object)$result);
                        } else {
                            response('validation failed', 'false', (object)[], 'mobile number already exits.');
                        }
                        
                }else{

                    response('validation failed', 'false', (object)[], 'email already exits.');
                }    

                    
                }
                
                
            
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }







    // Login
    public function login(){
        try {
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            // Form Validation
            $this->form_validation->set_rules('login_type', 'login_type', 'trim|required');
            $this->form_validation->set_rules('username', 'username', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required');
               
            if($this->form_validation->run() == FALSE){
                $err = getErrors(validation_errors());
                response('validation failed', 'false', (object)[], $err);
            } else{
                 
                 if ($this->jsonData->login_type == "email") {
                     $email_login = $this->db->where(['email'=>$this->jsonData->username,'password'=>$this->jsonData->password])->get('users');
                     if ($email_login->num_rows() > 0) {
                         $result = $this->user->get_login_token($email_login->row()->user_id);
                         $this->db->where(['email'=>$this->jsonData->username])->update('users',['device_token'=>$this->jsonData->device_token]);
                         response('login success!', true, (object)$result);
                     } else {

                         response("Invalid login Creadentials", 'false', (object)[]);
                     }
                     
                 } else if ($this->jsonData->login_type == "phone") {
                     $phone_login = $this->db->where(['phone'=>$this->jsonData->username,'password'=>$this->jsonData->password])->get('users');
                     if ($phone_login->num_rows() > 0) {
                         $result = $this->user->get_login_token($phone_login->row()->user_id);
                         $this->db->where(['phone'=>$this->jsonData->username])->update('users',['device_token'=>$this->jsonData->device_token]);
                         response('login success!', true, (object)$result);
                     } else {

                         response("Invalid login Creadentials", 'false', (object)[]);
                     }

                 } else {
                     response('something went wrong', 'false', (object)[], $err);
                 }
                  
                  
            }
                
                
            
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }
    
    // verify OTP
   public function verify_otp(){
        try {
             isValidMethodType($this->input->method(), 'post');
             postdata($this->jsonData);
             $this->form_validation->set_rules('phone', 'phone', 'trim|required');   
             $this->form_validation->set_rules('otp', 'otp', 'trim|required');   
             if($this->form_validation->run() == FALSE){
                $err = getErrors(validation_errors());
                response('validation failed', 'false', (object)[], $err);
             } else{
                  $res = $this->user->check_mobile_otp($this->jsonData);
                  response('login success!', true, (object)$res);
                
               
            }
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }
    
    
    
    
    
    

    public function delivery_address(){
        try {
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            // Form validation
            $this->form_validation->set_rules('door_no', 'door_no', 'trim|required');
            $this->form_validation->set_rules('floo_no', 'floo_no', 'trim|required');
            $this->form_validation->set_rules('building_no', 'building_no', 'trim|required');
            $this->form_validation->set_rules('appartment_name', 'appartment_name', 'trim|required');
            $this->form_validation->set_rules('street', 'street', 'trim|required');
            $this->form_validation->set_rules('near_by', 'near_by', 'trim|required');
            $this->form_validation->set_rules('locality', 'locality', 'trim|required');
            $this->form_validation->set_rules('city', 'city', 'trim|required');
            $this->form_validation->set_rules('district', 'district', 'trim|required');
            $this->form_validation->set_rules('state', 'state', 'trim|required');
            $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', false, (object)[], $err);
            } else{
                $user = authenticateUser();
                $address = $this->jsonData;
                $address->user_id=$user->user_id;
                //print_r($address);
                $this->db->insert('tbl_delivery_address',$address);
                response('address save success.', true, (object)[]);
            }
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }

    // delivery address update
    public function delivery_address_update(){
        try {
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            // Form validation
            $this->form_validation->set_rules('address_id', 'address_id', 'trim|required');
            /*$this->form_validation->set_rules('door_no', 'door_no', 'trim|required');
            $this->form_validation->set_rules('floo_no', 'floo_no', 'trim|required');
            $this->form_validation->set_rules('building_no', 'building_no', 'trim|required');
            $this->form_validation->set_rules('appartment_name', 'appartment_name', 'trim|required');
            $this->form_validation->set_rules('street', 'street', 'trim|required');
            $this->form_validation->set_rules('near_by', 'near_by', 'trim|required');
            $this->form_validation->set_rules('locality', 'locality', 'trim|required');
            $this->form_validation->set_rules('city', 'city', 'trim|required');
            $this->form_validation->set_rules('district', 'district', 'trim|required');
            $this->form_validation->set_rules('state', 'state', 'trim|required');
            $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
            */
            if($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', false, (object)[], $err);
            } else{
                $user = authenticateUser();
                $address = $this->jsonData;
                $address_id = $address->address_id;
                unset($address->address_id);
                
                //print_r($address);
                $this->db->where(['id'=>$address_id,'user_id'=>$user->user_id])->update('tbl_delivery_address',$address);
                response('address save success.', true, (object)[]);
            }
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }



    
    // update token
    public function delete_address(){
        try{
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            $user = authenticateUser();
            $this->form_validation->set_rules('address_id', 'address id', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', false, (object)[], $err);
            } else{
                $res = $this->db->where(['id'=>$this->jsonData->address_id])->delete('tbl_delivery_address');
                response('Address delete success', true, []);
            }
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }


    public function address_list() {
        try {
            isValidMethodType($this->input->method(), 'get');
            $user = authenticateUser();
            $data = $this->db->get_where('tbl_delivery_address',['user_id'=>$user->user_id])->result();
            response('address list', true, $data);
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }

    // profile
    public function profile() {
        try {
            isValidMethodType($this->input->method(), 'get');
            $user = authenticateUser();
            $data = $this->db->get_where('users',['user_id'=>$user->user_id])->row_array();
            response('profile success', true, $data);
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }

    // profile update
    public function profileupdate() {
        try {
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);

            $this->form_validation->set_rules('first_name', 'first_name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'last_name', 'trim|required');
            
            if ($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', 'false', (object)[], $err);  
            } else {
                $user = authenticateUser();
                $updateData=$this->jsonData;
                $this->db->where(['user_id'=>$user->user_id])->update('users',$updateData);
                $data = $this->db->get_where('users',['user_id'=>$user->user_id])->row_array();
                response('update success', true, (object)$data);
            }
           
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }

    public function change_password() {
        try {
            isValidMethodType($this->input->method(), 'post');
            
            $this->form_validation->set_rules('oldpassword', 'oldpassword', 'trim|required');
            $this->form_validation->set_rules('newpassword', 'newpassword', 'trim|required');
            $this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
            
            if ($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', false, (object)[], $err);  
            } else {
                $oldpassword = md5($_POST['oldpassword']);
                $this->user->checkPassword($_POST['user_id'], $oldpassword);
                $newpassword = md5($_POST['newpassword']);
                $this->user->update($_POST['user_id'], ['password'=> $newpassword]);
                response('Password change success', true, []);
            }
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }




    // forgot password
    public function forgotpassword() {
        try {
            isValidMethodType($this->input->method(), 'post');
            $this->form_validation->set_rules('email_id', 'email_id', 'trim|required');
            // check form validation
            if ($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', false, (object)[], $err);
            } else {
                $userDetails = $this->user->emailExists($this->input->post('email_id'));
                $body = getForgotTemplate($userDetails['name'], $userDetails['password']);
                sendEmail($this->input->post('email_id'), 'Reset Password', $body);
                response('success', true, []);
            }
            
            
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }
    
    public function makeUrl($userDetails, $type = null) {
        $date = date("Y-m-d H:i:s");
        $newtimestamp = strtotime($date. ' + 5 minute');
        $data['email'] = $userDetails->email;
        $data['id'] = $userDetails->id;
        $data['exp'] = $newtimestamp *1000;
        $encoded_token = AUTHORIZATION::generateToken($data);
        if($type == null){
            return base_url()."kartikonline/api/index.php/resetpassword?token=$encoded_token";
        } else{
            return base_url()."kartikonline/api/index.php/verify?token=$encoded_token";
        }
    }

    
    
    public function passwordupdate() {
        try {
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            
            $this->form_validation->set_rules('token', 'token', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', 'false', (object)[], $err);
            } else {
                $verifyData = AUTHORIZATION::validateToken($this->jsonData->token);
                $current_datetime = strtotime(date("Y-m-d H:i:s"));
                if(!$current_datetime * 1000 > $verifyData->exp){
                    http_response_code(401);
                    response('Token expired!', false, [], 'Token Expired!');
                } else { 
                    $this->user->updateNewPassword($verifyData, $this->jsonData);
                    response('Password has been updated successfully', true, []);
                }
            }
            
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }
    
     public function myorder() {
        try {
            isValidMethodType($this->input->method(), 'get');
            $user = authenticateUser();
            $st = $this->input->get('st');
            if(empty($st)){
                $st = 0;
            }
            $data = $this->order->myorder($user, $st);
            response('myorder details', true, $data);
        } catch (Exception $e) {
            response($e->getMessage(), false, []);
        }
    }


    // add to cart
    public function addtocart() {
        try {
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);

            $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
            //$this->form_validation->set_rules('quantity', 'quantity', 'trim|required');
            $this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
            $this->form_validation->set_rules('unit_id', 'unit_id', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', 'false', (object)[], $err);  
            } else {
                $user = authenticateUser();

                $product_id = $this->jsonData->product_id;
                $quantity = $this->jsonData->quantity;
                $user_id = $this->jsonData->user_id;
                
                
                $product = $this->db->get_where('product',['id'=>$this->jsonData->product_id])->row_array();


                 if ($quantity > 0) {
                    if ($product['discount_type']=='%') {
                        $price = $product['mrp_price']- ($product['mrp_price']*$product['discount'])/100;
                    } else {
                        $price = $product['mrp_price'] - $product['discount'];
                    }
                    

                    $cart = array(
                        'token'=>uniqe_device(),
                        'product_id'=>$product_id,
                        'quantity'=>$quantity,
                        'discount'=>$product['discount'],
                        'discount_type'=>$product['discount_type'],
                        'total_price'=>$price*$quantity,
                        'price_per_unit'=>$product['mrp_price'],
                        'status'=>'0',
                        'user_id'=>$user_id,
                        'unit_name'=>$this->jsonData->unit_id,
                    );
                    $cart_check = $this->db->get_where('cart',['product_id'=>$product_id,'user_id'=>$user_id,'status'=>'0'])->row_array();
                    if ($cart_check==0) {
                        $this->db->insert('cart', $cart);
                        $message='Add to cart success.';
                    } else {
                        $this->db->where(['product_id'=>$product_id,'user_id'=>$user_id,'status'=>'0'])->update('cart',$cart);
                        $message='cart update success.';
                    }
                    
                } else {
                    $this->db->delete('cart',['product_id'=>$product_id,'user_id'=>$user_id,'status'=>'0']);
                    $message='remove success.';
                }
                
                

                response($message, true, (object)[]);
            }
           
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }

     
}