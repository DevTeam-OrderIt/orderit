<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller
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
		$this->load->library('pdf');
		date_default_timezone_set("Asia/Kolkata");
		$this->load->helper('notify');

	}
	


	public function index(){
		 $data['app_title']=$this->app_title;
	     $data['title']='order';
	     $data['menu']='order';
	     $data['child_menu']='';
	     $data['orders']=$this->app_model->getAllList('orders',array('order_id !='=>''),'create_date','DESC');
	     $this->load->view('admin/order/manage',$data);
   }



   public function add(){
		$data['app_title']=$this->app_title;
		$data['title']='order';
		$data['menu']='order';
		$data['child_menu']='';
		$this->form_validation->set_rules('customer_name','customer name','trim|required');
		$this->form_validation->set_rules('customer_phone','customer phone','trim|required');
		$this->form_validation->set_rules('customer_email','customer email','trim|required');
		$this->form_validation->set_rules('user_id','user name','trim|required');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if ($this->form_validation->run()==true) {
			$customer_name = $this->input->post('customer_name');
			$customer_phone = $this->input->post('customer_phone');
			$customer_email = $this->input->post('customer_email');
			$user_id = $this->input->post('user_id');
			$shiping_address = $this->input->post('shiping_address');
			
			$product_id = $this->input->post('product_id[]');
			$quantity = $this->input->post('quantity[]');
			$discount_type = $this->input->post('discount_type[]');
			$discount = $this->input->post('discount[]');
			$price_per_unit = $this->input->post('price_per_unit[]');
			$total_price = $this->input->post('price[]');

			$order_id = $this->product->generateOrderId();

			foreach ($product_id as $key => $value) {
				$cart = array(
					'token'=>uniqe_device(),
					'product_id'=>$product_id[$key],
					'quantity'=>$quantity[$key],
					'discount'=>$discount[$key],
					'discount_type'=>$discount_type[$key],
					'total_price'=>$total_price[$key],
					'price_per_unit'=>$price_per_unit[$key],
					'status'=>'1',
					'user_id'=>$user_id,
					'order_id'=>$order_id
				);
			    $this->db->insert('cart', $cart);
			}
			



			
			$payment_status = $this->input->post('payment_status');
			$payment_method = $this->input->post('payment_method');
			$order_status = $this->input->post('order_status');
			$delivery_boys = $this->input->post('delivery_boys');

			
			
			$order=array(
				'order_id'=>$order_id,
				'user_id'=>$user_id,
				'token'=>uniqe_device(),
				'amount'=>array_sum($total_price),
				'shipping_address'=>$shiping_address,
				'customer_name'=>$customer_name,
				'customer_phone'=>$customer_phone,
				'customer_email'=>$customer_email,
				'order_status'=>$order_status,
				'delivery_boys_id'=>$delivery_boys,
				'create_date'=>date('Y-m-d H:i:s'),
				'payment_date'=>date('Y-m-d H:i:s'),
				'payment_status'=>$payment_status,
				'payment_method'=>$payment_method

			);




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
		$this->load->view('admin/order/add',$data);

   }

  

	public function price_calculate(){
	   	 $id = $this->input->post('id');
	   	 $product = $this->db->select('*')->get_where('product',['id'=>$id])->row_array();
	   	 $selected_unit = $this->db->select('*')->get_where('unit',['id'=>$product['unit_id']])->row_array();
	   	 $units = $this->db->select('units')->get_where('product',['id'=>$id])->row_array();
	   	 $unit_id_arr = explode(',', $units['units']);
	   	 $unitss = '';
	   	 $all_unit=[];
	   	 foreach ($unit_id_arr as $key=>$value) {
	   	 	 $unit = $this->db->get_where('unit',['id'=>$value])->row_array();
	   	 	 $r['unite_value'] = $unit['unite_value'];
	   	 	 $r['unite_name'] = $unit['unite_name'];
	   	 	 array_push($all_unit, $r);
	   	 }
	   	 $product['selected_unit']=$selected_unit['unite_value'];
	   	 $product['selected_unit_name']=$selected_unit['unite_name'];
	   	 $product['all_unit']=$all_unit;
	   	 echo json_encode($product);
		 die;

	   }
   


    public function edit(){
    	$id = $this->uri->segment(4);
    	$data['app_title']=$this->app_title;
    	$data['title']='Order Edit';
		$data['menu']='order';
		$data['id'] = $id;
		$data['child_menu']='';
		$data['order'] = $this->app_model->get_special_details('orders',array('id'=>$id));
		$this->load->view('admin/order/edit',$data);
    }

    public function update($id=null){
    	$id = $this->uri->segment(4);
    	$this->form_validation->set_rules('customer_name','customer name','trim|required');
		$this->form_validation->set_rules('customer_phone','customer phone','trim|required');
		$this->form_validation->set_rules('customer_email','customer email','trim|required');
		$this->form_validation->set_rules('user_id','user name','trim|required');
		$this->form_validation->set_rules('product_id','select product','trim|required');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if ($this->form_validation->run()==true) {
			$customer_name = $this->input->post('customer_name');
			$customer_phone = $this->input->post('customer_phone');
			$customer_email = $this->input->post('customer_email');
			$user_id = $this->input->post('user_id');
			$shiping_address = $this->input->post('shiping_address');
			$product_id = $this->input->post('product_id');
			$quantity = $this->input->post('quantity');
			$discount = $this->input->post('discount');
			$price_per_unit = $this->input->post('price_per_unit');
			$total_price = $this->input->post('price');
			$amount = $this->input->post('amount');
			$payment_status = $this->input->post('payment_status');
			$payment_method = $this->input->post('payment_method');
			$order_status = $this->input->post('order_status');
			$delivery_boys = $this->input->post('delivery_boys');
			$unit_name = $this->input->post('unit_name');

		    $getcart= $this->db->select('cart_id')->get_where('orders',['id'=>$id])->row_array();
		    $cart = array('token'=>uniqe_device(),'product_id'=>$product_id,'quantity'=>$quantity,'discount'=>$discount,'total_price'=>$total_price,'price_per_unit'=>$price_per_unit,'unit_name'=>$unit_name);
			$this->app_model->update('cart', $cart,['id'=>$getcart['cart_id']]);
			 
			
			$order = array(
				'user_id'=>$user_id,
				'amount'=>$amount,
				'shipping_address'=>$shiping_address,
				'customer_name'=>$customer_name,
				'customer_phone'=>$customer_phone,
				'customer_email'=>$customer_email,
				'order_status'=>$order_status,
				'delivery_boys_id'=>$delivery_boys,
				'create_date'=>date('Y-m-d H:i:s'),
				'payment_date'=>date('Y-m-d H:i:s'),
				'payment_status'=>$payment_status,
				'payment_method'=>$payment_method
			);




	     	$q = $this->app_model->update('orders',$order,['id'=>$id]);
         	if ($q==true) {
	    		$this->session->set_flashdata('class', 'success');
	    	    $this->session->set_flashdata('message', 'Order Update Successfully.');
	    	    redirect('admin/order/edit/'.$id);
	    	} else {
	    		$this->session->set_flashdata('class', 'danger');
	    		$this->session->set_flashdata('message', 'Order Update Failed.');
	    		redirect('admin/order/edit/'.$id);
	        }
		}
	     
	}

   public function delete($id){
   	$getcart = $this->db->select('cart_id')->get_where('orders',['id'=>$id])->row_array();
	$this->db->delete('cart',['id'=>$getcart['cart_id']]);  
	$q = $this->db->delete('orders',['id'=>$id]);    
	  if ($q==true) {
		$this->session->set_flashdata('class', 'success');
		    $this->session->set_flashdata('message', 'Order Delete Successfully.');
		    redirect('admin/order');
			
		} else {
			$this->session->set_flashdata('class', 'error');
			$this->session->set_flashdata('message', 'Order Delete Failed.');
			redirect('admin/order');
	    }
   }



   public function order_details($id){
   	    $product_name='';
   	    $quantity=0;
   	    $discount= [];
   	    $total_price=[];
   	    $price_per_unit ='Rs. ';
   	    $unit_name = '';
		$order = $this->db->get_where('orders',['id'=>$id])->row_array();
		
		$card_data = $this->db->where(['token'=>$order['token'],'order_id'=>$order['order_id']])->get('cart')->result_array();
		$product_list='';
		foreach ($card_data as $cart) {
			 $product = $this->db->select('product_name,unit_id')->get_where('product',['id'=>$cart['product_id']])->row_array();
             $product_name  .= $product['product_name'].', ';
             $quantity +=$cart['quantity']; 
             $unit = $this->db->get_where('unit',['id'=>$product['unit_id']])->row_array();
             $product_list .='<tr><td>'.$product['product_name'].'</td><td>'.$unit['unite_name'].' X '.$cart['quantity'].'</td></tr>';
             array_push($discount, $cart['discount']*$cart['quantity']);
             array_push($total_price, $cart['total_price']);
        }
		$users = $this->db->get_where('users',['user_id'=>$order['user_id']])->row_array();
        
		$orderdata=[];
		$orderdata['product_name']=$product_list;
		$orderdata['quantity']=$quantity;
		$orderdata['discount']='Rs. '.array_sum($discount);
		$orderdata['total_price']='Rs. '.array_sum($total_price);
		$orderdata['order_id']=$order['order_id'];
		$orderdata['id']=$order['id'];
		$orderdata['order_id']=$order['order_id'];
		$orderdata['user_name']=$users['first_name'].' '.$users['last_name'];;
		$orderdata['amount']=$order['amount'];
		$orderdata['shipping_address']=$order['shipping_address'];
		$orderdata['customer_name']=$order['customer_name'];
		$orderdata['customer_phone']=$order['customer_phone'];
		$orderdata['customer_email']=$order['customer_email'];
		$orderdata['order_status']=$order['order_status'];
		$delivery_boys = $this->db->get_where('staff',['id'=>$order['delivery_boys_id']])->row_array();
        $orderdata['delivery_boy']=$delivery_boys['first_name'].' '.$delivery_boys['last_name'];
		$orderdata['create_date']=$order['create_date'];
		$orderdata['payment_date']=$order['payment_date'];
		$orderdata['payment_status']=$order['payment_status'];
		$orderdata['payment_method']=$order['payment_method'];

		return $orderdata;

   }


   public function get_order_details(){
   		$id = $this->input->post('id');
   		$orderdata = $this->order_details($id);
   		echo json_encode($orderdata);
   		die;
   }


   public function get_units(){
   		 $id = $this->input->post('id');
   		 $product=[];
	   	 $units = $this->db->select('units')->get_where('product',['id'=>$id])->row_array();
	   	 $unit_id_arr = explode(',', $units['units']);
	   	 $unitss = '';
	   	 foreach ($unit_id_arr as $key=>$value) {
	   	 	 $unit = $this->db->get_where('unit',['id'=>$value])->row_array();
	   	 	 $unitss .='<option value="'.$unit['unite_value'].'">'.$unit['unite_name'].'</option>';
	   	 }
	   	 $product['units']=$unitss;
	   	 echo json_encode($product);
	   	 die;

   }


   public function invoice(){
   		$product_id = $this->input->post('product_id');
   		$order = $this->db->get_where('orders',['id'=>$product_id])->row_array();
		$arr_cart = explode(',', $order['cart_id']);
		$card_data = $this->db->where(['token'=>$order['token'],'order_id'=>$order['order_id']])->get('cart')->result_array();
		$data['card_data'] = $card_data;
		$data['order'] = $order;
        $data['title']=APP_NAME;
        $fileName = 'product'.time();
        //$this->load->view('admin/invoice',$data);
        $html = $this->load->view('admin/invoice',$data,true);
        $this->pdf->pdf_create($html,$fileName);  

    }

    public function get_user_details(){
    	$id = $this->input->post('id');
   		$user = $this->db->get_where('users',['user_id'=>$id])->row_array();
   		$add = $this->db->get_where('tbl_delivery_address',['user_id'=>$id])->row_array();
   		$door_no = ($add['door_no'] != '') ? 'door no- '.$add['door_no'] : '';
   		$floo_no = ($add['floo_no'] != '') ? ', flor no- '.$add['floo_no'] : '';
   		$building_no = ($add['building_no'] != '') ? ', building no- '.$add['building_no'] : '';
   		$appartment_name = ($add['appartment_name'] != '') ? ', appartment name- '.$add['appartment_name'] : '';
   		$street = ($add['street'] != '') ? ', street- '.$add['street'] : '';
   		$near_by = ($add['near_by'] != '') ? ', near by- '.$add['near_by'] : '';
   		$locality = ($add['locality'] != '') ? ', locality- '.$add['locality'] : '';
   		$city = ($add['city'] != '') ? ', city- '.$add['city'] : '';
   		$district = ($add['district'] != '') ? ', district- '.$add['district'] : '';
   		$state = ($add['state'] != '') ? ', state- '.$add['state'] : '';
   		$pincode = ($add['pincode'] != '') ? ', pincode- '.$add['pincode'] : '';


   		$address = $door_no.$floo_no.$building_no.$appartment_name.$street.$near_by.$locality.$city.$district.$state.$pincode;
   		$details=[];
   		$details['name'] = $user['first_name'].' '.$user['last_name'];
   		$details['phone'] = $user['phone'];
   		$details['email'] = $user['email'];
   		$details['address'] = $address;
   		echo json_encode($details);
   		die;
    }


    





}

?>