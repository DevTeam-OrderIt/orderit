<?php

	function isvalidMethodType($requestMethod, $neededMethod) {
		if($requestMethod != $neededMethod)
			throw new Exception("route not found");
	}

        // refactor error message
        function getErrors($errors){
            $CI =& get_instance();
            return $CI->form_validation->error_array();
        }


        // format body data

        function postdata($data){
            if(!empty($data)){
                foreach($data as $key=>$value) {
                    if($value != "" || $value != null){
                        $_POST[$key] = $value;
                    }
                }
            }
        }


        function generateRandomString($length=8){
            $randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"), 0, $length);
            return $randomletter."".time();
        }

        function uniqe_device(){
            $CI =& get_instance();
            if ($CI->agent->is_browser())
            {
                $agent = $CI->agent->browser().' '.$CI->agent->version();
            }
            elseif ($CI->agent->is_robot())
            {
                $agent = $CI->agent->robot();
            }
            elseif ($CI->agent->is_mobile())
            {
                $agent = $CI->agent->mobile();
            }
            else
            {
                $agent = 'Unidentified User Agent';
            }

            return strtolower($agent.$CI->agent->platform());
        }



        // Format user login data

        function data_format($data, $fields) {
            $newData = [];
            foreach ($fields as $key) {
                $newData[$key] = $data[$key];
            }
            return $newData;
        }

        // validate token

        function authenticateUser(){
            $CI =& get_instance();
            $token = $CI->input->get_request_header('token');
            $user = AUTHORIZATION::validateToken($token);
            if(!$user)
                throw new Exception("authentication failed", 1);
            return $user;
        }


        // get discounted price
        function getFinalPrice($total, $discount){
            if($discount){
                $per = ($discount/$total)*100;
                return $total - $per;
            } else{
                return $total;
            }
        }


        // Generate Otp
        function generatePIN($digits = 4){
            $i = 0; //counter
            $pin = ""; //our default pin is blank.
            while($i < $digits){
                //generate a random number between 0 and 9.
                $pin .= mt_rand(0, 9);
                $i++;
            }
            return $pin;
        }
         


        function response($msg, $status, $data, $err=null) {
            $res = [
                'message'=> $msg,
                'status'=> $status,
                'data'=> $data
            ];
            if($err != null){
                $res['errors'] = $err;
            }
            echo json_encode($res);
        }


        function OrderTemplate($data) {
        return '<html> 
            <head>
                <title>New order</title>
            </head>
          <section style="background: #fafafa; margin: 0 auto; padding: 30px 10%;">
          <div class="image-holder" style="margin: 10px auto; margin-bottom: 30px; text-align: center; width: 167px;"><img src="'.base_url().'public/assets/img/logo.png" height="200" width="200" />
          <h3>ORDER IT ONLINE </h3>
          </div>
          <h4>New Order</h4>
          <p>Name : Ajit Kumar</p>
          <p>Phone no : 9634725012</p>
          <p>Gender : Male</p>
          <p>Address : NOida</p>
          <p>description : Test mail</p>
          <p>Thanks. <br/><b>ORDER IT ONLINE</b></p>
          </section>
          </html>';
        }

        // Register user template 
        function getWelcomeTemplate($user_name) {
           return '<html> 
                    <head>
                        <title>Verify email</title>
                    </head>
                  <section style="background: #fafafa; margin: 0 auto; padding: 30px 10%;">
                  <div class="image-holder" style="margin: 10px auto; margin-bottom: 30px; text-align: center; width: 167px;">
                  <img src="http://demosite7.com/guardone/public/image_gallary/logo.jpg" height="200" width="200"/>
                  <h3>'.APP_NAME.'</h3>
                  </div>
                  <h4>Hi '.$name.'</h4>
                    <p>Welcome to MONEY-WEALTH TECHNOLOGY TEAM.</p>
                  <p>Please confirm your email address by clicking the fancy looking button below!.</p>
                  <p><button style="background-color: #e35128; height: 30px; border-radius: 5px; color: white; font-weight: bold;"><a style="text-decoration: none; color:white;" href="'.$url.'">Confirm Email</a></button></p>
                    <p>if you are having trouble clicking the password reset button, Copy and paste the Url below into your browser.</p>
                    <p>'.$url.'</p>
                    <p>Thanks. <br/><b>'.APP_NAME.' Team</b></p>
                  </section>
                  </html>';
        }


        function EmailSent($to, $subject, $body) {
            $CI =& get_instance();
             // The mail sending protocol.
            $config['protocol'] = 'smtp';
            // SMTP Server Address for Gmail.
            $config['smtp_host'] = 'ssl://smtp.googlemail.com';
            // SMTP Port - the port that you is required
            $config['smtp_port'] = 587;
            // SMTP Username like. (abc@gmail.com)
            $config['smtp_user'] = 'phpfresher1.milkyway@gmail.com';
            // SMTP Password like (abc***##)
            $config['smtp_pass'] = '9634725012';
            $config['mailtype'] = 'html';
            // Load email library and passing configured values to email library
            $CI->load->library('email', $config);
            // Sender email address orderitonline24@gmail.com
            $CI->email->from('phpfresher1.milkyway@gmail.com', APP_NAME);
            // Receiver email address.for single email
            $CI->email->to($to);
            // Subject of email
            $CI->email->subject($subject);
            // Message in email
            $CI->email->message($body);
            // It returns boolean TRUE or FALSE based on success or failure
           return $CI->email->send();
        }


        
        function send_push($device_id,$message, $title,$date) {
            $url = 'https://fcm.googleapis.com/fcm/send';
            $api_key = 'AAAAWM0Nnfs:APA91bENryCZwVUGByy_rpNyiT-UdPsx8A2RauugUNplirYv98hg6DrPlnMzUPSO4IMBf3HFWx-fTTbyDxPMSE4oX4aD8DZO6iFOrc_uKJAlRSDdRDsyIPbBKcnBQ8B3sPUcoMZyfWXc';
                        
            $fields = array (
                'registration_ids' => $device_id,
                'notification' => array (
                        "body" => $message,
                        "title"=> $title,
                        "date"=>$date
                )
            );

            //header includes Content type and api key
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key='.$api_key
            );
                        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            return $result;

        }

        function send_notification($data){
            //print_r($data);
            $CI =& get_instance();
            $user_ids = explode(',', $data['user_ids']);
            $device_token_arr = $CI->db->select('device_token')->where_in('id',$user_ids)->get('tbl_user')->result_array();
            $device_token=[];
            foreach ($device_token_arr as $row) {
                if ($row['device_token']!='') {
                    $device_token[]=$row['device_token'];
                }
               
            }
            $message = $data['message'];
            $title = $data['title'];
            $date = $data['date'];
            send_push($device_token, $message, $title,$date);
        }

        function notification_rakeupdate($user_ids){
            $CI = & get_instance();
            $user_ids = explode(',', $user_ids);
            $CI->db->select('u.device_token,mr.sr_no,mr.loading_date,mr.user_id');
            $CI->db->from('tbl_user u');
            $CI->db->join('master_rake mr','mr.user_id=u.id','INNER');
            //$CI->db->where('device_token <>','');
            $CI->db->where_in('u.id',$user_ids);
            $q = $CI->db->get();
            $result = $q->result_array();
          
            foreach ($result as $row) {
                $device_token[]=$row['device_token'];
                $message='Your new serial number is '.$row['sr_no'];
                $title='Master Rake Update';
                $date=$row['loading_date'];
                $CI->db->insert('notification',['user_ids'=>$row['user_id'],'title'=>$title,'message'=>$message,'date'=>date('Y-m-d H:i:s')]);
                send_push($device_token, $message, $title,$date);
                
            }
        }

        
        
        
        function fileUpload() {
            $fileCount = count($_FILES['files']['name']);
            $CI =& get_instance();
            $uploadData = [];
            for($i = 0; $i < $fileCount; $i++){
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];
                
                $file_ext = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);
                $fileName = time().'_'.generateRandomString(20).'.'.$file_ext;
                // File upload configuration
                $uploadPath = './public/image_gallary/upload';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = '*';
                $config['file_name'] = $fileName;
                
                // Load and initialize upload library
                $CI->load->library('upload', $config);
                $CI->upload->initialize($config);
                
                // Upload file to server
                
                if($CI->upload->do_upload('file')){
                    // Uploaded file data
                    $fileData = $CI->upload->data();
                    $uploadData[] = $fileName;
                } else{
                    return array('');
                    $error = array('error' => $CI->upload->display_errors());
                    print_r($error); die;
                }
            }
            
            return $uploadData;
            // print_r($uploadData); die;
        }
        
        
        // send email
        function contactTemplate($message,$title) {
			 return '<html> 
                <head>
                    <title>Support</title>
                </head>
              <section style="background: #fafafa; margin: 0 auto; padding: 30px 10%;">
              <div class="image-holder" style="margin: 10px auto; margin-bottom: 30px; text-align: center; width: 167px;"><img src="'.base_url().'public/assets/img/logo.png" height="200" width="200" />
              <h3>AZAD FOUNDATION NGO</h3>
              </div>
              <p>Welcome to AZAD FOUNDATION NGO !</p>
              <h4>'.$title.'</h4>
              <p>'.$message.'</p>
              <p>Thanks. <br/><b>AZAD FOUNDATION NGO TEAM</b></p>
              </section>
              </html>';
        }
		
		 function sendEmail($to, $subject, $body){
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['mailtype'] = 'html';
			$CI =& get_instance();
            $CI->email->initialize($config);
            $CI->email->from('info@azadfoundation.net', 'AZAD FOUNDATION');
            $CI->email->to($to);
			$CI->email->subject($subject);
            $CI->email->message($body);
            if($CI->email->send()){
              return true;
            }
            throw new Exception("Something went wrong.", 1);
        }

       /* function sendEmail($to, $subject, $body){
                $url = 'https://api.sendgrid.com/';
                $user = 'bcbud32';
                $pass = '%IPEXux$gZFSiPvl%f1';
                $json_string = array(
                  'to' => array(
                    $to
                  ),
                  'category' => 'test_category'
                );
                
                $params = array(
                    'api_user'  => $user,
                    'api_key'   => $pass,
                    'x-smtpapi' => json_encode($json_string),
                    'to'        => $to,
                    'subject'   => $subject,
                    'html'      => $body,
                    'text'      => 'AZAD FOUNDATION',
                    'from'      => "AZAD@azadiasacademy.com",
                  );
                $request =  $url.'api/mail.send.json';
                $session = curl_init($request);
                curl_setopt ($session, CURLOPT_POST, true);
                curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
                curl_setopt($session, CURLOPT_HEADER, false);
                curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($session);
                if($response){
                  return true;
                }
                throw new Exception("Something went wrong.", 1);
                curl_close($session);
        }*/


         function get_all_date($start_date,$end_date,$date){
            //echo $start_date;echo $end_date;echo $date;
            $begin = new DateTime($start_date);
            $end = new DateTime($end_date);
            $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
            $date=[];
            foreach($daterange as $date){
                if ($date->format("d")==$date) {
                     echo $date->format("Y-m-d");
                }
            }
            //print_r($date);
            //die;
            //return $date;
        }
		
		
		
        
        
        
?>