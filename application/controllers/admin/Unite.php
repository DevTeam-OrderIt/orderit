<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Unite extends CI_Controller
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
	     $data['title']='Unite';
	     $data['menu']='unite';
	     $data['child_menu']='';
		 $data['unite'] = $this->db->get_where('unit',['delete_status'=>'0'])->result_array();
	     $this->load->view('admin/unite/manage',$data);
   }

    public function add(){
    	$data['app_title']=$this->app_title;
	    $data['title']='Unite';
	    $data['menu']='unite';
	    $data['child_menu']='';
    	$this->form_validation->set_rules('unite_name','name','trim|required');
    	$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

	     if($this->form_validation->run()){
	     	$unit = $this->input->post();
	     	
	     	$q = $this->app_model->insert('unit',$unit);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Add Successfully.');
	    	    redirect('admin/unite/add');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Add Failed.');
	    		redirect('admin/unite/add/');
	        }
    	}
    	$this->load->view('admin/unite/add',$data);
     
    }



    

    public function edit(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='Unite';
		$data['menu']='unit';
		$data['id'] = $id;
		$data['child_menu']='';
		$data['unit'] = $this->app_model->get_special_details('unit',array('id'=>$id));
    	$this->load->view('admin/unite/edit',$data);
    }

    public function update($id=null){

    	$id = $this->uri->segment(4);
    	$this->form_validation->set_rules('unite_name','name','trim|required');
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if($this->form_validation->run()){
	     	$unit = $this->input->post();
	     	
	     	$q = $this->app_model->update('unit',$unit,['id'=>$id]);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Update Successfully.');
	    	    redirect('admin/unite/edit/'.$id);
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Update Failed.');
	    		redirect('admin/unite/edit/'.$id);
	        }
    	}

		
		
     

	}

   public function delete($id){
   	$q = $this->db->delete('unit',array('id'=>$id));
	  	if ($q==true) {
		$this->session->set_flashdata('class', 'success');
		    $this->session->set_flashdata('message', 'Delete Successfully.');
		    redirect('admin/unite');
			
		} else {
			$this->session->set_flashdata('class', 'error');
			$this->session->set_flashdata('message', 'Delete Failed.');
			redirect('admin/unite');
	    }
   }






}


?>