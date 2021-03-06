<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->app_title="Satcapp";
		$this->load->model('app_model');
		date_default_timezone_set("Asia/Calcutta");
		if (empty($this->session->userdata('session_arr'))) {
			redirect('admin/login');
		}

	}
	public function index(){
		
		 $session_arr= $this->session->userdata('session_arr');
		 $data['app_title']=$this->app_title;
		 $data['title']='Setting';
	     $data['menu']='setting';
	     $data['child_menu']='profile';
		 $data['admin']=$this->app_model->get_special_details('tbl_admin',array('id'=>$session_arr['admin_id']));
	     $data['id']=$session_arr['admin_id'];
		 $this->load->view('admin/setting/setting_profile',$data); 
   }

   public function profile($id=null){
  		$id = $this->uri->segment(4);
    	$this->form_validation->set_rules('first_name','first Name','trim|required');
    	$this->form_validation->set_rules('last_name','last Name','trim|required');
    	$this->form_validation->set_rules('email','email','trim|required');
    	$this->form_validation->set_rules('mobile_number','mobile number','trim|required');
        $this->form_validation->set_rules('username','username','trim|required');

    	$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
		 
	     if($this->form_validation->run()){
	         $data=array(
	    			'first_name' => $this->input->post('first_name'),
	    			'last_name' => $this->input->post('last_name'),
	    			'mobile_number' => $this->input->post('mobile_number'),
	    			'username' => $this->input->post('username'),
	    			'ip_address' => $this->input->ip_address(),
	    			'last_update' => date('Y-m-d H:i:s'),
	    			'email' => $this->input->post('email')
    			
	    	 );
            
          	$q = $this->app_model->update('tbl_admin',$data,array('id'=>$id));
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Admin Profle Update Successfully.');
	    	    redirect('admin/setting');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Admin Profle Update Failed.');
	    		redirect('admin/setting');
	        }
    	}
     

	}
	
	public function password(){
		 $session_arr= $this->session->userdata('session_arr');
		 $data['app_title']=$this->app_title;
		 $data['title']='Setting';
	     $data['menu']='setting';
	     $data['child_menu']='password';
		 $data['id']=$session_arr['admin_id'];
		 $this->form_validation->set_rules('old_pass','old password','required|callback_oldpassword_check');
    	 $this->form_validation->set_rules('conf_pass','confirm password','required');
		 $this->form_validation->set_rules('new_pass','new password','required|matches[conf_pass]');
		 
		
    	$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
		if($this->form_validation->run()==true){
			$old_pass = $this->input->post('old_pass');
			$new_pass = $this->input->post('new_pass');
			$conf_pass = $this->input->post('conf_pass');
			
			$updateArr=array('password'=>md5($new_pass),'last_update'=>date('Y-m-d H:i:s'));
			$q = $this->app_model->update('tbl_admin',$updateArr,array('id'=>$session_arr['admin_id']));
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Admin Password Update Successfully.');
	    	    redirect('admin/setting/password');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Admin Password Update Failed.');
	    		redirect('admin/setting/password');
	        }
			
		}
		 
		 $this->load->view('admin/setting/change_password',$data); 
	}
	
	public function oldpassword_check($old_password){
		   $session_arr= $this->session->userdata('session_arr');
		   $id=$session_arr['admin_id'];
		   $admin = $this->app_model->get_special_details('tbl_admin',array('id'=>$id));
		   $old_pass = md5($old_password);
		  
		   if($old_pass != $admin['password']){
			  $this->form_validation->set_message('oldpassword_check', 'Old password not match');
			  return FALSE;
		   } 
		   return TRUE;
	}

  

  


}

?>