<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller
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
	     $data['title']='Category';
	     $data['menu']='category';
	     $data['child_menu']='';
		 $data['category']=$this->db->get_where('category',['delete_status'=>'0'])->result_array();
	     $this->load->view('admin/category/manage',$data);
   }

    public function add(){
    	$data['app_title']=$this->app_title;
	    $data['title']='Category';
	    $data['menu']='category';
	    $data['child_menu']='';
    	$this->form_validation->set_rules('name','name','trim|required');
    	$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

	     if($this->form_validation->run()){
	     	$category = $this->input->post();
	     	if (count($_FILES) == 0) {
	     		$category['image']='';
	     	} else {
	     		$files = fileUpload();
	       		$filename = $files[0];
	        	$category['image']=$filename;
	     	}
	     	
	     	$q = $this->app_model->insert('category',$category);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Add Successfully.');
	    	    redirect('admin/category/add');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Add Failed.');
	    		redirect('admin/category/add/');
	        }
    	}
    	$this->load->view('admin/category/add',$data);
     
    }

    

    public function edit(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='Category Edit';
		$data['menu']='category';
		$data['id'] = $id;
		$data['child_menu']='';
		$data['category']= $this->app_model->get_special_details('category',array('id'=>$id));
    	$this->load->view('admin/category/edit',$data);
    }

    public function update($id=null){

    	$id = $this->uri->segment(4);
    	$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if($this->form_validation->run()){
	     	$category = $this->input->post();
	     	if (count($_FILES) == 0) {
	     		$category['image']='';
	     	} else {
	     		$files = fileUpload();
	       		$filename = $files[0];
	        	$category['image']=$filename;
	     	}
	     	
	     	$q = $this->app_model->update('category',$category,['id'=>$id]);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Update Successfully.');
	    	    redirect('admin/category/edit/'.$id);
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Update Failed.');
	    		redirect('admin/category/edit/'.$id);
	        }
    	}

     

	}

   public function delete($id){
   	$q = $this->app_model->update('category',['delete_status'=>'1'],array('id'=>$id));
	  	if ($q==true) {
		$this->session->set_flashdata('class', 'success');
		    $this->session->set_flashdata('message', 'Delete Successfully.');
		    redirect('admin/category');
			
		} else {
			$this->session->set_flashdata('class', 'error');
			$this->session->set_flashdata('message', 'Delete Failed.');
			redirect('admin/category');
	    }
   }




}


?>