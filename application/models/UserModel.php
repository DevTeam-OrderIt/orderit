<?php
class UserModel extends CI_Model {

function __construct() {
    // Call the Model constructor
    parent:: __construct();
    $this->table = "users";
}

public function insert($data) {
    // save user data....
    //unset($data->cpassword);
   // $data['password'] = md5($data['password']);
    $data['logintype']='app';
    $data['status']='1';
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
}

// user otp checking 
public function get_login_token($user_id){
    $conditions = ['user_id'=>$user_id];
    $q = $this->db->where($conditions)->get($this->table);
    if(!$q->num_rows()){
        http_response_code(401);
        throw new Exception("Invalid login Creadentials!", 1);
    }
    $user_details = $q->row_array();
    $jwtPayload = array('user_id'=> $user_details['user_id'], 'first_name'=> $user_details['first_name'],'last_name'=>$user_details['last_name'], 'phone'=> $user_details['phone']);
    $token = $token = AUTHORIZATION::generateToken($jwtPayload);
    return [
        'user_id' => $user_details['user_id'],
        'first_name' => $user_details['first_name'],
        'last_name' => $user_details['last_name'],
        'phone'=>$user_details['phone'],
        'email'=>$user_details['email'],
        'token'=> $token
        
    ];
}


// check old password
public function checkPassword($user_id, $oldPassword) {
    $q = $this->db->where(['id'=> $user_id, 'password'=> $oldPassword])->get($this->table);
    if($q->num_rows()){
        return true;
    } else{
        http_response_code(409);
        throw new Exception("Your old password Does not matched", 1);
        
    }
}




public function update($user_id, $data) {
    return $this->db->where('id', $user_id)->update($this->table, $data);
}


// update user token
public function updateToken($data) {
    return $this->db->where('id', $data->user_id)->update($this->table, ['fcmToken'=>$data->fcmToken]);
}


// check mobile number
public function hasMobileUnique($mobileNumber){
    $q = $this->db->where('mobile_number', $mobileNumber)->get($this->table);
    if($q->num_rows() > 0){
        http_response_code(409);
        throw new Exception("The mobile number already in used.", 409);
    }
    return true;
}

// check email id exists
public function hasEmailIdUnique($emailId){
    $q = $this->db->where('email', $emailId)->get($this->table);
    if($q->num_rows() > 0){
        http_response_code(409);
        throw new Exception("The Email ID already in used.", 409);
    }
    return true;
}

// check user exists or not
public function userExists($user_id) {
    $q = $this->db->where('id', $user_id)->get('users');
    if($q->num_rows() > 0){
       return $q->row_array();
    } 
    http_response_code(409);
    throw new Exception("User does not exixts!", 409);
}

// check user by email
public function emailExists($email_id) {
    $q = $this->db->where('email', $email_id)->get($this->table);
    if( $q->num_rows() > 0 ) {
        return $q->row_array();
    }
    http_response_code(409);
    throw new Exception("User does not exists!", 1);
    
}



public function getUserDetails($email){
    $q = $this->db->where('email', $email)->get($this->table);
    if($q->num_rows()){
        return $q->row_array();
    } else{
        return [];
    }
}



// check user email verified
public function checkEmailVerified($email) {
    $q = $this->db->where(['emailId'=> $email, 'email_verified'=> 1])->get('users');
    if($q->num_rows() > 0){
        return true;
    } else{
        return false;
    }
}

// verify email
public function verifyEmail($email) {
    $q = $this->db->where('emailId', $email)->update('users', ['email_verified'=>1]);
    return true;
}


public function deleteExpireOtp(){
    return $this->db->query("DELETE FROM otp WHERE `updated_at` < DATE_SUB(NOW(), INTERVAL 5 MINUTE)");
}

public function updateNewPassword($user, $data) {
    $password = md5($data->password);
    $id = $user->id;
    return $this->db->where('id', $id)->update($this->table, ['password'=> $password]);

}

public function game_type($package_id){
    $this->db->select('teams');
    $this->db->from('cricket_post');
    $this->db->like('packages',$package_id);
    $q = $this->db->get();
    return $q->result_array();
}

public function check_social_login($data){
    $data['add_on']=date('Y-m-d H:i:s');
    $data['status']='1';
    $conditions = ['email'=> $data['email'] ];
    $this->db->update('tbl_user',['device_id'=>$data['device_id']],['email'=>$data['email']]);
    $q = $this->db->where($conditions)->get($this->table)->row_array();
    if (!empty($q)) {
        if ($q['logintype']==$data['logintype']) {
            return $q;
        }
        return $q;
       // http_response_code(409);
        //throw new Exception("The Email ID already in used.", 409);

    } else {
        $this->db->insert('tbl_user',$data);
        $user_id = $this->db->insert_id();
        return $this->db->get_where('tbl_user',['id'=>$user_id])->row_array();
    }
    /*$data['add_on']=date('Y-m-d H:i:s');
    $conditions = ['email'=> $data['email'] ];
    $q = $this->db->where($conditions)->get($this->table);
    if(!$q->num_rows()){
        $this->db->insert($this->table, $data);
        $q = $this->db->where($conditions)->get($this->table);
        return $q->row_array();
    }else{
        return $q->row_array();
    }*/
}

public function facebook_login($oauth_uid,$logintype){
    $conditions = ['oauth_uid'=> $oauth_uid, 'logintype'=> $logintype];
    $this->db->update('tbl_user',['device_id'=>$data['device_id']],['email'=>$data['email']]);
    $q = $this->db->where($conditions)->get($this->table);
    if(!$q->num_rows()){
        $this->db->insert($this->table, $conditions);
        $q = $this->db->where($conditions)->get($this->table);
    }
    return $q->row_array();
}


public function get_post($package_id,$game_type){
    $sql='SELECT * FROM cricket_post WHERE FIND_IN_SET("'.$package_id.'",packages) AND FIND_IN_SET("'.$game_type.'",game)  AND delete_status="0" order by post_date asc';
    $q = $this->db->query($sql);
    return $q->result_array();
    
    
    /*$this->db->select('*');
    $this->db->from('cricket_post cr');
    $this->db->where('FIND_IN_SET("'.$package_id.'",packages)');
    $this->db->where('FIND_IN_SET("'.$game_type.'",game)');
    $q = $this->db->get();
    return $q->result_array();*/
}

public function get_games($game_type){
    $sql='SELECT * FROM cricket_post WHERE FIND_IN_SET("'.$game_type.'",game)  AND delete_status="0" order by post_date asc';
    $q = $this->db->query($sql);
    return $q->result_array();
    
}

public function active_package($email){
    $this->db->select('*');
    $this->db->from('tbl_user e');
    $this->db->join('tbl_order o','e.id=o.user_id','INNER');
    $this->db->where(['e.email'=>$email,'o.expire_date >'=>date('Y-m-d')]);
    $q= $this->db->get();
    return $q->num_rows();
}

public function get_game($package_id){
    return $this->db->select('game')->where(['id'=>$package_id])->get('tbl_package')->row_array();
}




    
    
    
    
}








?>