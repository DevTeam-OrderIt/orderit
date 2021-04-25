<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notification extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->app_title=APP_NAME;
		$this->load->model('app_model');
		$this->load->model('dashboard_model');
		$this->load->model('Product_model','product');
		$this->load->library('CSVReader');
		if (empty($this->session->userdata('session_arr'))) {
			redirect('admin/login');
		}
		date_default_timezone_set("Asia/Kolkata");
		$this->load->helper('notify');

	}

	public function index(){
		$data['app_title']=$this->app_title;
		$data['title']='Notification';
		$data['menu']='notification';
		$data['child_menu']='';
		$this->form_validation->set_rules('user_id','customer name','trim|required');
		
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if ($this->form_validation->run()==true) {
			$customer_name = $this->input->post('customer_name');

	     	$q = $this->app_model->insert('orders',$order);
            if ($q==true) {
	    		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Order Create Successfully.');
	    	    redirect('admin/order/add');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'danger');
	    		$this->session->set_flashdata('message', 'Order Create Failed.');
	    		redirect('admin/order/add');
	        }
		}
		$this->load->view('admin/notification/send',$data);

   }


	
}
?>