<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* if ( ! function_exists('generate_otp')) {
	function generate_otp(){
		$characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
        return $randomString; 

	}
} */

/* if (! function_exists('generateRandomString')) {
    function generateRandomString($length=8){
            $randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"), 0, $length);
            return strtoupper($randomletter);
  }
} */


if(! function_exists('formate_date')){
	function formate_date($date){
		return  date("d, M Y g:s a", strtotime($date));
	}
}

/* if(! function_exists('authorization')){
	function authorization($requestmethod){
		if (strtolower($requestmethod)=='post') {
			return true;
		} else {
			return false;
		}
		

	}
} */


/* if (! function_exists('isvalidMethodType')) {
	function isvalidMethodType($requestMethod, $neededMethod) {
            if($requestMethod == $neededMethod){
                return true;
            }else{
                return false;
            }
        }
} */

/* if (! function_exists('postdata')){
    function postdata($data){
            if(!empty($data)){
                foreach($data as $key=>$value) {
                    if($value != "" || $value != null){
                        $_POST[$key] = $value;
                    }
                }
            }
        }
} */



function permission(){
	$CI =& get_instance();
	$session_arr = $CI->session->userdata('session_arr');
	$per = $CI->db->select('permission')->where('id',$session_arr['admin_id'])->get('tbl_admin')->row_array();
	return $ArrPer = json_decode($per['permission']);
	
}






 

?>