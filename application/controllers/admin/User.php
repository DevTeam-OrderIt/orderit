<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->app_title=APP_NAME;
		$this->load->model('app_model');
		$this->load->model('dashboard_model');
		if (empty($this->session->userdata('session_arr'))) {
			redirect('admin/login');
		}
		date_default_timezone_set("Asia/Kolkata");
		$this->load->helper('notify');

	}
	


	public function index(){
		 $data['app_title']=$this->app_title;
	     $data['title']='Users';
	     $data['menu']='user';
	     $data['child_menu']='';

	      if(isset($_POST['search'])){
			 $zip_code = $this->input->post('zip_code');
			 $state = $this->input->post('state');
			 $city = $this->input->post('city');
			 $data['user']=$this->dashboard_model->search_volunteer($zip_code,$state,$city);
		 }else{
			 $data['user']=$this->app_model->getAllList('users',array('delete_status'=>'0'),'user_id','DESC');
	     }
		
	     $this->load->view('admin/user/manage-user',$data);
   }



   public function add(){
		$data['app_title']=$this->app_title;
		$data['title']='Users';
		$data['menu']='user';
		$data['child_menu']='';
		$this->form_validation->set_rules('first_name','first name','trim|required');
		$this->form_validation->set_rules('last_name','last name','trim|required');
		$this->form_validation->set_rules('phone','mobile number','numeric|trim|required|callback_check_mobile|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('email','email id','trim|required|valid_email|callback_check_email');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if ($this->form_validation->run()==true) {
			$users['first_name']=$this->input->post('first_name');
			$users['last_name']=$this->input->post('last_name');
			$users['phone']=$this->input->post('phone');
			$users['email']=$this->input->post('email');
	     	if (count($_FILES) == 0) {
	     		$users['image']='';
	     	} else {
	     		$files = fileUpload();
	       		$filename = $files[0];
	        	$users['image']=$filename;
	     	}
	     	$users['add_on']=date('Y-m-d H:i:s');
			$users['last_update']=date('Y-m-d H:i:s');
			$users['status']='1';
			$q = $this->app_model->insert('users',$users);
            $user_id=$this->db->insert_id();
            $this->db->where(['user_id'=>$user_id])->update('users',['userid'=>'USER'.$user_id]);
            $adderss=array(
            	'door_no'=>$this->input->post('door_no'),
            	'floo_no'=>$this->input->post('floo_no'),
            	'building_no'=>$this->input->post('building_no'),
            	'appartment_name'=>$this->input->post('appartment_name'),
            	'street'=>$this->input->post('street'),
            	'near_by'=>$this->input->post('near_by'),
            	'locality'=>$this->input->post('locality'),
            	'city'=>$this->input->post('city'),
            	'district'=>$this->input->post('district'),
            	'state'=>$this->input->post('state'),
            	'pincode'=>$this->input->post('pincode'),
            	'user_id'=>$user_id,
            	'default'=>'1'
            );

            $this->db->insert('tbl_delivery_address',$adderss);


    		/*$verifyUrl = $this->makeUrl((object)['id'=> $user_id, 'emailId'=> $data['email_id']], 'verify');
            $template = getWelcomeTemplate($data['first_name'], $verifyUrl);
            EmailSent($data['email_id'], 'Confirm Email', $template);*/
	    	if ($q==true) {
	    		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Users add Successfully.');
	    	    redirect('admin/user/add');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'danger');
	    		$this->session->set_flashdata('message', 'Users add Failed.');
	    		redirect('admin/user/add');
	        }
		}
		
		$this->load->view('admin/user/add-user',$data);

   }




   public function check_mobile($mobile){
   		$result = $this->db->where(['phone'=>$mobile])->count_all_results('users');
   		if ($result==0) {
   			return true;
   		} else {
   			 $this->form_validation->set_message('check_mobile', 'Mobile number already exists.');
             return false;
   		}
   		
   }

   public function check_email($email){
   		$result = $this->db->where(['email'=>$email])->count_all_results('users');
   		if ($result==0) {
   			return true;
   		} else {
   			 $this->form_validation->set_message('check_email', 'Email id already exists.');
             return false;
   		}
   }
  


   public function makeUrl($userDetails, $type = null) {
        $date = date("Y-m-d H:i:s");
        $newtimestamp = strtotime($date. ' + 5 minute');

        $data['email'] = $userDetails->emailId;
        $data['id'] = $userDetails->id;
        $data['exp'] = $newtimestamp *1000;
        $encoded_token = AUTHORIZATION::generateToken($data);
        $emailVerifyUrl = "http://localhost:4200/#/auth/verifyemail";
        $forgotPasswordUrl = "http://localhost:4200/#/auth/forgotpassword";
        /* $emailVerifyUrl = "https://demosite7.com/appindia-hallbook/demo/#/auth/verifyemail";
         $forgotPasswordUrl = "https://demosite7.com/appindia-hallbook/demo/#/auth/forgotpassword";*/
        if($type == null) {
            return $forgotPasswordUrl."?token=$encoded_token";
        } else{
            return $emailVerifyUrl."?token=$encoded_token";
        }
    }


	 public function view(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='User view';
		$data['menu']='user';
		$data['child_menu']='';
		$data['id'] = $id;
		$data['user']= $this->app_model->get_special_details('users',array('user_id'=>$id));
		$data['order']= $this->db->order_by('id',"desc")->limit(1)->get_where('orders',['user_id'=>$id])->row_array();
		$this->load->view('admin/user/view-user',$data);
    }
    

    public function edit(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='User Edit';
		$data['menu']='user';
		$data['id'] = $id;
		$data['child_menu']='';
		$data['user']= $this->app_model->get_special_details('users',array('user_id'=>$id));
		$data['adderss']=$this->db->get_where('tbl_delivery_address',['user_id'=>$id])->row_array();
		$this->load->view('admin/user/edit-user',$data);
    }

    public function update($id=null){

    	$id = $this->uri->segment(4);
    	$this->form_validation->set_rules('first_name','first name','trim|required');
		$this->form_validation->set_rules('last_name','last name','trim|required');
		$this->form_validation->set_rules('phone','mobile number','numeric|trim|required');
		$this->form_validation->set_rules('email','email id','trim|required|valid_email');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if ($this->form_validation->run()==true ) {
			$users['first_name']=$this->input->post('first_name');
			$users['last_name']=$this->input->post('last_name');
			$users['phone']=$this->input->post('phone');
			$users['email']=$this->input->post('email');
			//$users=$this->input->post();
	     	if (count($_FILES) > 0) {
	     		$files = fileUpload();
	     		$filename = $files[0];
	     		if ($filename!='') {
	     			$users['image'] = $filename;
	     		}
	        	
	     	}
	     	$adderss=array(
            	'door_no'=>$this->input->post('door_no'),
            	'floo_no'=>$this->input->post('floo_no'),
            	'building_no'=>$this->input->post('building_no'),
            	'appartment_name'=>$this->input->post('appartment_name'),
            	'street'=>$this->input->post('street'),
            	'near_by'=>$this->input->post('near_by'),
            	'locality'=>$this->input->post('locality'),
            	'city'=>$this->input->post('city'),
            	'district'=>$this->input->post('district'),
            	'state'=>$this->input->post('state'),
            	'pincode'=>$this->input->post('pincode'),
            	'default'=>'1'
            );

            $this->app_model->update('tbl_delivery_address',$adderss,['user_id'=>$id]); 
	     	$q = $this->app_model->update('users',$users,array('user_id'=>$id));
	    	if ($q==true) {
	    		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'User Update Successfully.');
	    	    redirect('admin/user/edit/'.$id);
	    	} else {
	    		$this->session->set_flashdata('class', 'danger');
	    		$this->session->set_flashdata('message', 'User Update Failed.');
	    		redirect('admin/user/edit/'.$id);
	        }
		}
	     
	}

   public function delete($id){
	   	$this->db->delete('tbl_delivery_address',['user_id'=>$id]);
		$q = $this->db->delete('users',array('user_id'=>$id));
		if ($q==true) {
		$this->session->set_flashdata('class', 'success');
		    $this->session->set_flashdata('message', 'Users Delete Successfully.');
		    redirect('admin/user');
			
		} else {
			$this->session->set_flashdata('class', 'error');
			$this->session->set_flashdata('message', 'Users Delete Failed.');
			redirect('admin/user');
	    }
   }


   public function status($status,$id){

   		if ($status==1) {
   			$q = $this->app_model->update('users',array('status'=>$status),array('user_id'=>$id));
   			$message='Active Users Successfully.';
   			$class='success';
   		} else {
   			$q = $this->app_model->update('users',array('status'=>$status),array('user_id'=>$id));
   			$message='Block Users Successfully.';
   			$class='error';
   		}
   		if ($q==true) {
			    $this->session->set_flashdata('class', $class);
			    $this->session->set_flashdata('message', $message);
			    redirect('admin/user');
				
			} else {
				$this->session->set_flashdata('class', 'error');
				$this->session->set_flashdata('message', 'Users Status Change Failed.');
				redirect('admin/user');
		    }
     }


     

     public function verifyemail() {
        try {
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            
            $this->form_validation->set_rules('token', 'token', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', 'false', (object)[], $err);
            } else{
                $verifyData = AUTHORIZATION::validateToken($this->jsonData->token);
                $current_datetime = strtotime(date("Y-m-d H:i:s"));
                if($this->user->checkEmailVerified($verifyData->email)){
                    throw new Exception("Your account already verified!", 1);
                }
                if($current_datetime * 1000 > $verifyData->exp){
                    response('Token expired!', false, [], 'Token Expired!');
                } else{ 
                    $this->user->verifyEmail($verifyData->email);
                    response('Email Verified successfully!', true, []);
                }
            }
           } catch (Exception $e) {
               response($e->getMessage(), false, (object)[]);
           }
    }
	  





}


?>