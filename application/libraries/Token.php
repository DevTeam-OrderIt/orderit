<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @ajit kumar
 */
class Token 
{
	
	function __construct()
	{
		$this->CI = & get_instance();
		
	}

    public function create_token($mobile){
    	$token = md5($mobile.date('His'));
    	$this->CI->app_model->update('tbl_user',array('access_token'=>$token),array('mobile_number'=>$mobile));
    	return $token;
    }

    public function get_token($where){
    	$result = $this->CI->app_model->get_special_details('tbl_user',$where);
    	if ($result['access_token']!=Null) {
    		$token = $this->CI->input->get_request_header('token');
            if ($result['access_token']==$token) {
               return true;
            } else {
               return false;
            }
            

    	}
    	
    }


  


}


?>