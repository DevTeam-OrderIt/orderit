<?php
error_reporting(0);
header("Access-Control-Allow-Headers: Origin, token, X-Requested-With, Content-Type, content-type, Accept, Authorization");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel', 'user');
        $this->load->model('Dashboard_model', 'dashboard');
        $this->form_validation->set_error_delimiters('~', '');
        $this->jsonData = json_decode(file_get_contents("php://input"));
    }



    public function all(){
        try {
            isValidMethodType($this->input->method(), 'get');
            $user = authenticateUser();
            $check_user = $this->db->where('user_id',$user->user_id)->get('users')->num_rows();
            
            if($check_user > 0){
                $categories = $this->dashboard->categories();
                $banners = $this->dashboard->getBanners();
                $recentView = $this->dashboard->getRecentViewProduct();
                $trandingProduct = $this->dashboard->trandingProduct();
                $data = ['categories'=>$categories, 'banners'=> $banners, 'recentView'=> $recentView, 'trandingProduct'=>$trandingProduct];
                response('success', true, $data);
            }else{
                response('No User Found', false, (object)[]);
            }
              
        } catch (Exception $e){
            response($e->getMessage(), false, []);
        }
    }


    // product serach api
    public function serach_product(){
        try{
            isValidMethodType($this->input->method(), 'post');
            postdata($this->jsonData);
            $user = authenticateUser();
            $this->form_validation->set_rules('search', 'search', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $err = getErrors(validation_errors());
                response('validation failed', false, (object)[], $err);
            } else{
                 $this->db->like('product_name', $this->jsonData->search);
                 $this->db->or_like('other_name', $this->jsonData->search);
                 $this->db->or_like('search_tags', $this->jsonData->search);
                 $query = $this->db->get('product');
                 $data =  $query->result();
                 $product = $this->dashboard->data_formate($data);
                 response('product list', true, $product);
            }
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }



   
    
    
}