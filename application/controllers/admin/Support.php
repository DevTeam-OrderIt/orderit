<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Support extends CI_Controller
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
	
	public function deletes(){
	   $checkboxval=explode(',',$_POST['checkboxval']);
	   foreach($checkboxval as $key=>$val){
	    
	    	$q =	$this->app_model->update('support',['delete_status'=>'1'],['id'=>$val]);
	   }

     	if ($q==true) {
			    $this->session->set_flashdata('class', 'success');
			    $this->session->set_flashdata('message', 'Successfully deleted.');
			    redirect('admin/support');
				
			} else {
				$this->session->set_flashdata('class', 'error');
				$this->session->set_flashdata('message', 'event is not deleted');
				redirect('admin/support');
		    }
		    
	}
	public function index(){
		 $data['app_title']=$this->app_title;
	     $data['title']='support';
	     $data['menu']='support';
	     $data['child_menu']='';
	     $data['post']=$this->app_model->getAllList('support',array('delete_status'=>'0'),'id','DESC');
	     $this->load->view('admin/support/manage',$data);
   }

    public function add(){
    	$data['app_title']=$this->app_title;
	    $data['title']='support';
	    $data['menu']='support';
	    $data['child_menu']='';
    	$this->form_validation->set_rules('title','title','trim|required');
    	$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

	     if($this->form_validation->run()){
	     	$posts=$this->input->post();
	     	if (count($_FILES) == 0) {
	     		$posts['images']='';
	     	} else {
	     		$files = fileUpload();
	       		$filename = implode(',', $files);
	        	$posts['images'] = $filename;
	     	}

	        $posts['datetime']=date('Y-m-d H:i:s');
	        $posts['create_by']='AZAD Foundation';
	        
	        $q = $this->app_model->insert('support',$posts);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Add Successfully.');
	    	    redirect('admin/support/add');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Add Failed.');
	    		redirect('admin/support/add/');
	        }
    	}
    	$this->load->view('admin/support/add',$data);
     
    }


	 public function view(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='support';
		$data['menu']='support';
		$data['child_menu']='';
		$data['id'] = $id;
		$data['post']= $this->app_model->get_special_details('support',array('id'=>$id));
		$this->load->view('admin/support/view',$data);
    }
    

    public function edit(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='support';
		$data['menu']='support';
		$data['id'] = $id;
		$data['child_menu']='';
		$data['post']= $this->app_model->get_special_details('support',array('id'=>$id));
    	$this->load->view('admin/support/edit',$data);
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

          	$q = $this->app_model->update('support',$post,['id'=>$id]);
          	if ($q==true) {
          		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Update Successfully.');
	    	    redirect('admin/support/edit/'.$id);
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'error');
	    		$this->session->set_flashdata('message', 'Update Failed.');
	    		redirect('admin/support/edit/'.$id);
	        }
    	}
     

	}

   public function delete($id){
   	    $q = $this->app_model->update('support',array('delete_status'=>'1'),array('id'=>$id));
	  	if ($q==true) {
		$this->session->set_flashdata('class', 'success');
		    $this->session->set_flashdata('message', 'Delete Successfully.');
		    redirect('admin/support');
			
		} else {
			$this->session->set_flashdata('class', 'error');
			$this->session->set_flashdata('message', 'Delete Failed.');
			redirect('admin/support');
	    }
   }


   


     public function approve($id){
     	$q =	$this->app_model->update('volunteer',['is_approved'=>'1'],['id'=>$id]);

     	if ($q==true) {
			    $this->session->set_flashdata('class', 'success');
			    $this->session->set_flashdata('message', 'volunteer approved Successfully.');
			    redirect('admin/upcoming');
				
			} else {
				$this->session->set_flashdata('class', 'error');
				$this->session->set_flashdata('message', 'volunteer approved Failed.');
				redirect('admin/upcoming');
		    }

     }

     public function doner(){
     	 $id = $this->uri->segment(4);
     	 $data['app_title']=$this->app_title;
	     $data['title']='support';
	     $data['menu']='support';
	     $data['child_menu']='';
	     $data['doner'] = $this->app_model->getAllList('support_donation',array('id'=>$id),'id','DESC');
	     $this->load->view('admin/support/list',$data);

     }
	 
	  





}


?>