<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Team extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->app_title = APP_NAME;
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
	     $data['title']='Team view';
	     $data['menu']='team';
	     $data['child_menu']='';

	      if(isset($_POST['search'])){
			 $zip_code = $this->input->post('zip_code');
			 $state = $this->input->post('state');
			 $city = $this->input->post('city');
			 $data['user']=$this->dashboard_model->search_volunteer($zip_code,$state,$city);
		 }else{
			 $data['user']=$this->app_model->getAllList('team',array('delete_status'=>'0'),'id','DESC');
	     }
		
	     $this->load->view('admin/team/manage',$data);
   }

    public function add(){
    	$data['app_title']=$this->app_title;
	    $data['title']='Team view';
	    $data['menu']='team';
	    $data['child_menu']='';
    	$this->form_validation->set_rules('name','name','trim|required');
    	$this->form_validation->set_rules('email','email','trim|required');
    	$this->form_validation->set_rules('phon_no','phone no','trim|required');
    	$this->form_validation->set_rules('gender','gender','trim|required');
    	$this->form_validation->set_rules('address','address','trim|required');
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

	     if($this->form_validation->run()){
	     	$teamData=$this->input->post();
	     	    $d = explode('/',$this->input->post('dob'));
                $teamData['dob'] = $d[2].'-'.$d[1].'-'.$d[0];
	     	if (count($_FILES) == 0) {
	     		$teamData['image']='';
	     	} else {
	     		$files = fileUpload();
	       		$filename = $files[0];
	        	$teamData['image']=$filename;
	     	}

	        $teamData['join_date']=date('Y-m-d H:i:s');
	        $teamData['status']='1';
	     	
          	$q = $this->app_model->insert('team',$teamData);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Add Successfully.');
	    	    redirect('admin/team/add');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Add Failed.');
	    		redirect('admin/team/add/');
	        }
    	}
    	$this->load->view('admin/team/add',$data);
     
    }





	 public function view(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='Team Edit';
		$data['menu']='team';
		$data['child_menu']='';
		$data['id'] = $id;
		$data['user']= $this->app_model->get_special_details('team',array('id'=>$id));
		$this->load->view('admin/team/view',$data);
    }
    

    public function edit(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='Team Edit';
		$data['menu']='team';
		$data['id'] = $id;
		$data['child_menu']='';
		$data['user']= $this->app_model->get_special_details('team',array('id'=>$id));
    	$this->load->view('admin/team/edit',$data);
    }

    public function update($id=null){

    	$id = $this->uri->segment(4);
    	$this->form_validation->set_rules('phon_no','phon_no','trim|required');
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if($this->form_validation->run()){
	     	$teamData=$this->input->post();
	     	    $d = explode('/',$this->input->post('dob'));
                $teamData['dob'] = $d[2].'-'.$d[1].'-'.$d[0];
	     	if (count($_FILES) == 0) {
	     		return true;
	     	} else {
	     		$files = fileUpload();
	       		$filename = $files[0];
	        	$teamData['image']=$filename;
	     	}

          	$q = $this->app_model->update('team',$teamData,['id'=>$id]);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Update Successfully.');
	    	    redirect('admin/team/edit/'.$id);
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Update Failed.');
	    		redirect('admin/team/edit/'.$id);
	        }
    	}

		
		
     

	}

   public function delete($id){
   	$q = $this->app_model->update('volunteer',array('delete_status'=>'1','status'=>'0'),array('id'=>$id));
	  	if ($q==true) {
		$this->session->set_flashdata('class', 'success');
		    $this->session->set_flashdata('message', 'Delete Successfully.');
		    redirect('admin/team');
			
		} else {
			$this->session->set_flashdata('class', 'error');
			$this->session->set_flashdata('message', 'Delete Failed.');
			redirect('admin/team');
	    }
   }


   public function status($status,$id){

   		if ($status==1) {
   			$q = $this->app_model->update('team',array('status'=>$status),array('id'=>$id));
   			$message='Active Successfully.';
   			$class='success';
   		} else {
   			$q = $this->app_model->update('team',array('status'=>$status),array('id'=>$id));
   			$message='Block Successfully.';
   			$class='error';
   		}
   		if ($q==true) {
			    $this->session->set_flashdata('class', $class);
			    $this->session->set_flashdata('message', $message);
			    redirect('admin/team');
				
			} else {
				$this->session->set_flashdata('class', 'error');
				$this->session->set_flashdata('message', 'Status Change Failed.');
				redirect('admin/team');
		    }
     }


     public function approve($id){
     	$q =	$this->app_model->update('volunteer',['is_approved'=>'1'],['id'=>$id]);

     	if ($q==true) {
			    $this->session->set_flashdata('class', 'success');
			    $this->session->set_flashdata('message', 'volunteer approved Successfully.');
			    redirect('admin/user');
				
			} else {
				$this->session->set_flashdata('class', 'error');
				$this->session->set_flashdata('message', 'volunteer approved Failed.');
				redirect('admin/user');
		    }

     }
	 
	  





}


?>