<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Slider extends CI_Controller
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
	     $data['title']='Slider';
	     $data['menu']='slider';
	     $data['child_menu']='';
	     $data['slider']=$this->app_model->getAllList('slider',array('delete_status'=>'0'),'id','DESC');
	     $this->load->view('admin/slider/manage',$data);
   }

    public function add(){
    	$data['app_title']=$this->app_title;
	    $data['title']='Slider';
	    $data['menu']='slider';
	    $data['child_menu']='';
    	$this->form_validation->set_rules('title','title','trim|required');
    	$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

	     if($this->form_validation->run()){
	     	$posts=$this->input->post();
	     	if (count($_FILES) == 0) {
	     		$posts['images']='';
	     	} else {
	     		$files = fileUpload();
	       		$filename = $files[0];
	        	$posts['images']=$filename;
	     	}
	     	$posts['status']=1;
	        $q = $this->app_model->insert('slider',$posts);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Add Successfully.');
	    	    redirect('admin/slider/add');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Add Failed.');
	    		redirect('admin/slider/add/');
	        }
    	}
    	$this->load->view('admin/slider/add',$data);
     
    }


	 public function view(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='Post Edit';
		$data['menu']='post';
		$data['child_menu']='';
		$data['id'] = $id;
		$data['post']= $this->app_model->get_special_details('post',array('id'=>$id));
		$this->load->view('admin/post/view',$data);
    }
    

    public function edit(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='Slider Edit';
		$data['menu']='slider';
		$data['id'] = $id;
		$data['child_menu']='';
		$data['slider']= $this->app_model->get_special_details('slider',array('id'=>$id));
    	$this->load->view('admin/slider/edit',$data);
    }

    public function update($id=null){

    	$id = $this->uri->segment(4);
    	$this->form_validation->set_rules('title','title','trim|required');
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if($this->form_validation->run()){
	     	$post = $this->input->post();
	     	    
	     	if (count($_FILES) == 0) {
	     		return true;
	     	} else {
	     		$files = fileUpload();
	       		$filename = $files[0];
	       		if ($filename!='') {
	       			$post['images']=$filename;
	       		}
	        	
	     	}

          	$q = $this->app_model->update('slider',$post,['id'=>$id]);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Update Successfully.');
	    	    redirect('admin/slider/edit/'.$id);
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Update Failed.');
	    		redirect('admin/slider/edit/'.$id);
	        }
    	}
     

	}

   public function delete($id){
   	    $q = $this->app_model->update('slider',array('delete_status'=>'1'),array('id'=>$id));
	  	if ($q==true) {
		$this->session->set_flashdata('class', 'success');
		    $this->session->set_flashdata('message', 'Delete Successfully.');
		    redirect('admin/slider');
			
		} else {
			$this->session->set_flashdata('class', 'error');
			$this->session->set_flashdata('message', 'Delete Failed.');
			redirect('admin/slider');
	    }
   }


   public function status($status,$id){

   		if ($status==1) {
   			$q = $this->app_model->update('slider',array('status'=>$status),array('id'=>$id));
   			$message='Active Successfully.';
   			$class='success';
   		} else {
   			$q = $this->app_model->update('slider',array('status'=>$status),array('id'=>$id));
   			$message='Block Successfully.';
   			$class='error';
   		}
   		if ($q==true) {
			    $this->session->set_flashdata('class', $class);
			    $this->session->set_flashdata('message', $message);
			    redirect('admin/slider');
				
			} else {
				$this->session->set_flashdata('class', 'error');
				$this->session->set_flashdata('message', 'Status Change Failed.');
				redirect('admin/slider');
		    }
     }


     
	  





}


?>