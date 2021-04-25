<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	
	function __construct()
	{

		parent::__construct();
		$this->app_title=APP_NAME;
		date_default_timezone_set("Asia/Calcutta");
		$this->load->model('app_model');
		$this->load->model('dashboard_model');
		if (empty($this->session->userdata('session_arr'))) {
			redirect('admin/login');
		}

	}
	public function index(){
		 $data['app_title']=$this->app_title;
		 $data['title']='Dashboard';
	     $data['menu']='dashboard';
	     $data['child_menu']='';
	     $data['users_count'] = $this->db->get_where('users',['delete_status'=>'0'])->num_rows();
	     $data['product_count'] = $this->db->get_where('product',['delete_status'=>'0'])->num_rows();
		 $data['order_count'] = $this->db->get('orders')->num_rows();
		 $data['new_orders'] = $this->db->get_where('orders',['order_status'=>'0'])->num_rows();
		 $data['in_process'] = $this->db->get_where('orders',['order_status'=>'1'])->num_rows();
		 $data['complete'] = $this->db->get_where('orders',['order_status'=>'2'])->num_rows();
		 
	     $this->load->view('admin/dashboard',$data);
   }

   public function chart(){
   		 $data['app_title']=$this->app_title;
		 $data['title']='Dashboard';
	     $data['menu']='dashboard';
	     $this->load->view('admin/chart',$data);
   }

  


}

?>