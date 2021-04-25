<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Staff extends CI_Controller
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
	     $data['title']='Staff';
	     $data['menu']='staff';
	     $data['child_menu']='';

	      
		 $data['user']=$this->app_model->getAllList('staff',array('email !='=>''),'id','DESC');
	     $this->load->view('admin/staff/manage',$data);
   }



   public function add(){
		$data['app_title']=$this->app_title;
		$data['title']='Staff';
		$data['menu']='staff';
		$data['child_menu']='';
		$this->form_validation->set_rules('first_name','first name','trim|required');
		$this->form_validation->set_rules('last_name','last name','trim|required');
		$this->form_validation->set_rules('phone','mobile number','numeric|trim|required|callback_check_mobile|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('email','email id','trim|required|valid_email|callback_check_email');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if ($this->form_validation->run()==true) {
			$users=$this->input->post();
	     	if (count($_FILES) == 0) {
	     		$users['image']='';
	     	} else {
	     		$files = fileUpload();
	       		$filename = $files[0];
	        	$users['image']=$filename;
	     	}
	     	
			$q = $this->app_model->insert('staff',$users);
            
	    	if ($q==true) {
	    		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Users add Successfully.');
	    	    redirect('admin/staff/add');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'danger');
	    		$this->session->set_flashdata('message', 'Users add Failed.');
	    		redirect('admin/staff/add');
	        }
		}
		
		$this->load->view('admin/staff/add',$data);

   }




   public function check_mobile($mobile){
   		$result = $this->db->where(['phone'=>$mobile])->count_all_results('staff');
   		if ($result==0) {
   			return true;
   		} else {
   			 $this->form_validation->set_message('check_mobile', 'Mobile number already exists.');
             return false;
   		}
   		
   }

   public function check_email($email){
   		$result = $this->db->where(['email'=>$email])->count_all_results('staff');
   		if ($result==0) {
   			return true;
   		} else {
   			 $this->form_validation->set_message('check_email', 'Email id already exists.');
             return false;
   		}
   }
  


    public function edit(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='User Edit';
		$data['menu']='user';
		$data['id'] = $id;
		$data['child_menu']='';
		$data['user']= $this->app_model->get_special_details('staff',array('id'=>$id));
		$this->load->view('admin/staff/edit',$data);
    }

    public function update($id=null){

    	$id = $this->uri->segment(4);
    	$this->form_validation->set_rules('first_name','first name','trim|required');
		$this->form_validation->set_rules('last_name','last name','trim|required');
		$this->form_validation->set_rules('phone','mobile number','numeric|trim|required');
		$this->form_validation->set_rules('email','email id','trim|required|valid_email');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if ($this->form_validation->run()==true ) {
			$users=$this->input->post();
	     	if (count($_FILES) > 0) {
	     		$files = fileUpload();
	     		$filename = $files[0];
	     		if ($filename!='') {
	     			$users['image'] = $filename;
	     		}
	        	
	     	} 
	     	
    		$q = $this->app_model->update('staff',$users,array('id'=>$id));
	    	if ($q==true) {
	    		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Staff Update Successfully.');
	    	    redirect('admin/staff/edit/'.$id);
	    	} else {
	    		$this->session->set_flashdata('class', 'danger');
	    		$this->session->set_flashdata('message', 'Staff Update Failed.');
	    		redirect('admin/staff/edit/'.$id);
	        }
		}
	     
	}

   public function delete($id){
   	$q = $this->app_model->delete('staff',array('id'=>$id));
	  	if ($q==true) {
		$this->session->set_flashdata('class', 'success');
		    $this->session->set_flashdata('message', 'Staff Delete Successfully.');
		    redirect('admin/staff');
			
		} else {
			$this->session->set_flashdata('class', 'error');
			$this->session->set_flashdata('message', 'Staff Delete Failed.');
			redirect('admin/staff');
	    }
   }

   public function monthly_order(){
   	$delivery_boys_id = $this->input->post('id');
   	$query = $this->db->query('select year(create_date) as year, month(create_date) as month, count(id) as total from orders where delivery_boys_id='.$delivery_boys_id.' group by year(create_date), month(create_date)');  
   	$result = $query->result(); 
   	$tr ='';
   	foreach($result as $row)
        {  
		$monthNum = $row->month;
        $dateObj = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
            /*name has to be same as in the database. */
            $tr .= "<tr> 
                        <td>$row->year</td>
                        <td>$monthName</td>  
                        <td>$row->total</td> 
                        
                   </tr>"; 
        } 

        echo $tr;
        die();  

   }

    


}


?>