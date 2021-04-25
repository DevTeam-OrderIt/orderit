<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller
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
	     $data['title']='Product';
	     $data['menu']='product';
	     $data['child_menu']='';

	      if(isset($_POST['search'])){
			 $zip_code = $this->input->post('zip_code');
			 $state = $this->input->post('state');
			 $city = $this->input->post('city');
			 $data['products']=$this->dashboard_model->search_volunteer($zip_code,$state,$city);
		 }else{
			 $data['products']=$this->app_model->getAllList('product',array('delete_status'=>'0'),'id','DESC');
	     }
		
	     $this->load->view('admin/product/manage-user',$data);
   }



   public function add(){
		$data['app_title']=$this->app_title;
		$data['title']='Users';
		$data['menu']='user';
		$data['child_menu']='';
		$this->form_validation->set_rules('product_name','product name','trim|required|callback_check_product');
		$this->form_validation->set_rules('other_name','other name','trim|required');
		$this->form_validation->set_rules('mrp_price','mrp price','numeric|trim|required');
		//$this->form_validation->set_rules('price','price','numeric|trim|required');
		$this->form_validation->set_rules('category_id','category','trim|required');
		$this->form_validation->set_rules('unit_id','unit','trim|required');
		//$this->form_validation->set_rules('discount','discount','numeric|trim|required');
		//$this->form_validation->set_rules('offer_msg','offer msg','trim|required');
		$this->form_validation->set_rules('no_of_product','total product','numeric|trim|required');
		$this->form_validation->set_rules('search_tags','search tags','trim|required');
		$this->form_validation->set_rules('description','description','trim|required');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if ($this->form_validation->run()==true) {
			$product=$this->input->post();
	     	if (count($_FILES) == 0) {
	     		$product['images']='';
	     	} else {
	     		$files = fileUpload();
	       		$filename = implode(',', $files);
	        	$product['images']=$filename;
	     	}
	     	
	     	if($this->input->post('addunits') != ''){
	     		$product['units'] = implode(',', $this->input->post('addunits'));
	     		unset($product['addunits']);
	     	}
	     	
	     	
			$q = $this->app_model->insert('product',$product);
            if ($q==true) {
	    		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Product add Successfully.');
	    	    redirect('admin/product/add');
	    		
	    	} else {
	    		$this->session->set_flashdata('class', 'danger');
	    		$this->session->set_flashdata('message', 'Product add Failed.');
	    		redirect('admin/product/add');
	        }
		}
		
		$this->load->view('admin/product/add-user',$data);

   }



   public function check_product($product){
   		$result = $this->db->where(['product_name'=>$product])->count_all_results('product');
   		if ($result==0) {
   			return true;
   		} else {
   			 $this->form_validation->set_message('check_product', 'Product already exists.');
             return false;
   		}
   }
  

	public function get_details(){
	   	 $id= $this->input->post('id');
	   	 $d = $this->db->get_where('product',['id'=>$id])->row_array();
	   	 $html='';
   	
   	 	$imgs = explode(',', $d['images']);
   	 	foreach ($imgs as $im=>$v) {
   	 		$html .= '<img src='.base_url().'public/image_gallary/upload/'.$v .' width="100" heigth="100"   >&nbsp;&nbsp;';
   	 	}
   	 	$dec = '<p>'.$d['description'].'</p>';
	   	 echo $html.$dec;

	}
   



    public function edit(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='Product Edit';
		$data['menu']='product';
		$data['id'] = $id;
		$data['child_menu']='';
		$data['product'] = $this->app_model->get_special_details('product',array('id'=>$id));
		$this->load->view('admin/product/edit-user',$data);
    }

    public function update($id=null){
    	$id = $this->uri->segment(4);
    	$this->form_validation->set_rules('product_name','product_name','trim|required');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if ($this->form_validation->run()==true ) {
			$product=$this->input->post();
	     	if (count($_FILES) > 0) {
	     		$files = fileUpload();
	     		$filename = implode(',', $files);
	     		if ($filename!='') {
	     			$product['images'] = $filename;
	     		}
	        	
	     	} 
	     	if ($this->input->post('addunits')!='') {
	     		$product['units'] = implode(',', $this->input->post('addunits'));
	     		unset($product['addunits']);
	     	}
	     	
	     	
    		$q = $this->app_model->update('product',$product,array('id'=>$id));
	    	if ($q==true) {
	    		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Product Update Successfully.');
	    	    redirect('admin/product/edit/'.$id);
	    	} else {
	    		$this->session->set_flashdata('class', 'danger');
	    		$this->session->set_flashdata('message', 'Product Update Failed.');
	    		redirect('admin/product/edit/'.$id);
	        }
		}
	     
	}

   public function delete($id){
   	$q = $this->db->delete('product',array('id'=>$id));
	  	if ($q==true) {
		$this->session->set_flashdata('class', 'success');
		    $this->session->set_flashdata('message', 'Product Delete Successfully.');
		    redirect('admin/product');
			
		} else {
			$this->session->set_flashdata('class', 'error');
			$this->session->set_flashdata('message', 'Product Delete Failed.');
			redirect('admin/product');
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


     

    public function trending(){
	   $checkboxval=explode(',',$_POST['checkboxval']);
	   $this->db->update('product',['services'=>null]);
	   foreach($checkboxval as $key=>$val){
	    	$q =	$this->app_model->update('product',['services'=>'trending'],['id'=>$val]);
	   }

     	if ($q==true) {
			    $this->session->set_flashdata('class', 'success');
			    $this->session->set_flashdata('message', 'Product trending Successfully.');
			    redirect('admin/product');
				
			} else {
				$this->session->set_flashdata('class', 'error');
				$this->session->set_flashdata('message', 'Product trending Failed.');
				redirect('admin/product');
		    }
	}


	public function un_trending(){
	    $q = $this->db->update('product',['services'=>null]);
     	if ($q==true) {
			    $this->session->set_flashdata('class', 'success');
			    $this->session->set_flashdata('message', 'Product Un trending Successfully.');
			    redirect('admin/product');
				
			} else {
				$this->session->set_flashdata('class', 'error');
				$this->session->set_flashdata('message', 'Product trending Failed.');
				redirect('admin/product');
		    }
	}




	public function import(){
	    $data = array();
        $memData = array();
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            //print_r(fgetcsv($csvFile));
            while(($line = fgetcsv($csvFile)) !== FALSE){
                $data[] = $line;
            }
            fclose($csvFile);
            array_shift($data);
            $i=1;
            foreach($data as $row){
                $product = $this->db->get_where('product',['product_name'=>$row[0]])->num_rows();
                $cat = $this->db->select('id')->get_where('category',['name'=>$row[7]])->row_array();
                if($cat){
                    $category=$cat['id'];
                }else{
                    $category=0;
                }
               
                $unt = $this->db->select('id')->get_where('unit',['unite_name'=>$row[11]])->row_array();
                if($unt){
                    $unit=$unt['id'];
                }else{
                    $unit=0;
                }
                
                if($product==0){
                    $pro=array(
                     "product_name"=>$row[0], 
                     "other_name"=>$row[1], 
                     "mrp_price"=>$row[2], 
                     "price"=>$row[3], 
                     "no_of_product"=>$row[4], 
                     "discount"=>$row[5], 
                     "offer_msg"=>$row[6], 
                     "category_id"=>$category, 
                     "unit_id"=>$row[8], 
                     "description"=>$row[9],
                     "services"=>$row[10],
                     "units"=>$unit,
                     "search_tags"=>$row[12]
                      
                    );
                    $this->db->insert('product',$pro);
                }
                $i++;
            }
            $this->session->set_flashdata('class', 'success');
			$this->session->set_flashdata('message', 'Upload Success.');
			redirect('admin/product');
            
        }
      
      
    }
    
    /*
     * Callback function to check file value and type during validation
     */
    public function file_check($str){
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
        }
    
	 }

	 public function download(){
        $data= $this->product->product_list();
        $product=[];
        foreach ($data as $pr) {
        	  $unit_ar = explode(',', $pr['units']);
	          $units = $this->db->where_in('id',$unit_ar)->get('unit')->result_array();;
	          $ut_str = '';
	          foreach ($units as $ut) {
	            $ut_str .= $ut['unite_name'].',';
	          }
	          $products=$pr;
	          $products['units']=$ut_str;

	          $product[] =  $products;
        }
       
	 	header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=product.csv');
		$output = fopen('php://output', 'w');
		fputcsv($output, array('PRODUCT NAME', 'OTHER NAME', 'MRP. PRICE','PRICE','NO. OF PRODUCTS','DISCOUNT','OFFER MESSAGE','CAREGORY','UNIT','DESCRIPTION','SERVICES','ALL UNITS','SEARCH TAGS'));

		if (count($product) >= 0) {
		    foreach ($product as $row) {
		        fputcsv($output, $row);
		    }
		}
	 }


}

?>