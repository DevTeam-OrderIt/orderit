<?php
error_reporting(0);
header("Access-Control-Allow-Headers: Origin, token, X-Requested-With, Content-Type, content-type, Accept, Authorization");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
defined('BASEPATH') OR exit('No direct script access allowed');


class Category extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel', 'user');
        $this->load->model('Dashboard_model', 'dashboard');
        $this->form_validation->set_error_delimiters('~', '');
        $this->jsonData = json_decode(file_get_contents("php://input"));
    }



    public function category_list() {
        try {
            isValidMethodType($this->input->method(), 'get');
            $user = authenticateUser();
            $categories = $this->dashboard->categories();
            response('category list', true, $categories);
        } catch (Exception $e) {
            response($e->getMessage(), false, (object)[]);
        }
    }
   
    
    
}