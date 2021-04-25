<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->model('App_model', 'app');
        date_default_timezone_set("Asia/Kolkata");
     
	}

	public function upload(){
	    if(isset($_POST['submit'])){
	        $config['upload_path']   = './public/'; 
    		$config['allowed_types'] = '*';
    		$this->load->library('upload', $config);
            if($this->upload->do_upload('file')){
                echo 'uploaded  :'.$this->upload->data()['file_name'];
             }
	     }
    	 $this->load->view('upload');
    }

    public function send_mail(){
    	$data=[];
    	$body = OrderTemplate($data);
        $send = EmailSent('ajit@yopmail.com', 'New Order', $body);
        print($send);
        if ($send==true) {
        	echo 'sent';
        } else {
        	echo 'failed';
        }
        
        
    }






	public function index(){
		$data['app_name']=APP_NAME;
		$data['link']='home';
		//$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
	//	$data['video'] = $this->db->where(['delete_status'=>'0','status'=>'1'])->limit(3)->order_by('id','desc')->get('video')->result_array();
		//$data['team'] = $this->db->where(['delete_status'=>'0','status'=>'1'])->limit(4)->order_by('priority','ASC')->get('team')->result_array();
		//$data['aboutus'] = $this->db->where(['delete_status'=>'0'])->limit(1)->order_by('id','asc')->get('about_us')->result_array();
		//$data['slider'] = $this->db->where(['delete_status'=>'0','status'=>'1'])->order_by('id','desc')->get('slider')->result_array();
		//$data['state_list']=$this->db->select('*')->from('state_list')->get()->result_array();
		$this->load->view('index',$data);

	}

	public function aboutus(){
		$data['app_name']=APP_NAME;
		$data['link']='aboutus';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['aboutus'] = $this->db->where(['delete_status'=>'0'])->order_by('id','asc')->get('about_us')->result_array();
		$this->load->view('about-us',$data);
	}

	public function video(){
		$data['app_name']=APP_NAME;
		$data['link']='video';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['video']=$this->app->getResultById('video',['delete_status'=>'0','status'=>'1']);
		$this->load->view('our-videos',$data);
	}

	public function volunteer(){
		$data['app_name']=APP_NAME;
		$data['link']='volunteer';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['volunteer']=$this->app->getResultById('volunteer',['delete_status'=>'0','is_approved'=>'1']);
		$this->load->view('volunteer',$data);
	}

	public function team(){
		$data['app_name']=APP_NAME;
		$data['link']='team';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['team']=$this->db->where(['delete_status'=>'0','status'=>'1'])->order_by('priority','ASC')->get('team')->result_array();
		$this->load->view('team',$data);
	}

	public function contactus(){
		$data['app_name']=APP_NAME;
		$data['link']='contactus';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$this->load->view('contact-us',$data);
	}


	/*volunter add */
	public function add(){
		$data = $this->input->post();
		$recaptchaResponse = $data['g-recaptcha-response'];
 		$userIp= $this->input->ip_address();
     	$secret = '6LduWfEUAAAAAOoQuvcfqTjXMNR_HSrN94E9cw5_';
   		$url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
         
        $status= json_decode($output, true);
 
        if ($status['success']) {
        	unset($data['g-recaptcha-response']);

        	$files = fileUpload();
	        $filename = $files[0];
	        $data['image']=$filename;
	        $data['add_on']=date('Y-m-d H:i:s');
	        $data['status']='1';
	        //   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
	           
	           
	        $q = $this->app->insert('volunteer',$data);
	        $body = getAdminTemplate($data);
	        sendEmail('azadstudycenter@gmail.com', 'New volunteer', $body);
	        $body2 = getWelcomeTemplate($data['first_name'].' '.$data['last_name']);
	        sendEmail($data['email_id'], 'Welcome NGO', $body2);


	        if ($q==true) {
	        	$this->session->set_flashdata('class', 'success');
			    $this->session->set_flashdata('message', 'Your form submitted successful.');
			    redirect('home'); 
	        } else {
	        	$this->session->set_flashdata('class', 'danger');
	     		$this->session->set_flashdata('message', 'Your form submitted failed.');
	     		redirect('home'); 
	        }
        	exit;
        }else{
        	 $this->session->set_flashdata('class', 'danger');
	     	 $this->session->set_flashdata('message', 'Sorry Google Recaptcha Unsuccessful!!');
	     	 redirect('home'); 
        }
        
	}


	// contact save
	public function contact_save(){
		//ini_set('allow_url_fopen',1);
		$data = $this->input->post();
		$recaptchaResponse = $data['g-recaptcha-response'];
 		$userIp= $this->input->ip_address();
     	$secret = '6LduWfEUAAAAAOoQuvcfqTjXMNR_HSrN94E9cw5_';
   		$url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
         
        $status= json_decode($output, true);
 
        if ($status['success']) {
        	unset($data['g-recaptcha-response']);
        	$q = $this->app->insert('contact_us',$data);
	        if ($q==true) {
	        	$this->session->set_flashdata('class', 'success');
			    $this->session->set_flashdata('message', 'Your form submitted successful.');
			    redirect('contactus'); 
	        } else {
	        	$this->session->set_flashdata('class', 'danger');
	     		$this->session->set_flashdata('message', 'Your form submitted failed.');
	     		redirect('contactus'); 
	        }
        	exit;
        }else{
        	 $this->session->set_flashdata('class', 'danger');
	     	 $this->session->set_flashdata('message', 'Sorry Google Recaptcha Unsuccessful!!');
	     	 redirect('contactus'); 
        }
    }




    public function post(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['post'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->order_by('id','desc')->get('post')->result_array();
		$this->load->view('post',$data);
	}

	public function post_detail(){
		$id = $this->uri->segment(2);
		$data['index'] = $this->uri->segment(3);
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['posts'] = $this->db->select('*')->where(['delete_status'=>'0'])->order_by('id','desc')->get('post')->result_array();
		$data['post'] = $this->db->select('*')->where(['delete_status'=>'0','id'=>$id])->get('post')->row_array();
		$this->load->view('post-detail',$data);
	}

	

	

	public function notification(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'notic';
	    $ids= $this->uri->segment(3);
        $data['notic']= $this->db->select('*')->where(['id'=>$ids])->get('notic')->row_array();
	    $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$this->load->view('notic',$data);
	}

	public function become_volunteer(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'become_volunteer';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$this->load->view('become_volunteer',$data);
	}

	public function newadd(){
		$data = $this->input->post();
		/*$recaptchaResponse = $data['g-recaptcha-response'];
 		$userIp= $this->input->ip_address();
     	$secret = '6LduWfEUAAAAAOoQuvcfqTjXMNR_HSrN94E9cw5_';
   		$url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
         
        $status= json_decode($output, true);*/
 		$status['success'] = true;
        if ($status['success']) {
        	unset($data['g-recaptcha-response']);

        	$files = fileUpload();
	        $filename = $files[0];
	        $data['image']=$filename;
	        $data['add_on']=date('Y-m-d H:i:s');
	        $data['status']='1';
	           $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
	        $q = $this->app->insert('volunteer',$data);
	        $body = getAdminTemplate($data);
	        sendEmail('azadstudycenter@gmail.com', 'New volunteer', $body);
	        $body2 = getWelcomeTemplate($data['first_name'].' '.$data['last_name']);
	        sendEmail($data['email_id'], 'Welcome NGO', $body2);


	        if ($q==true) {
	        	$this->session->set_flashdata('class', 'success');
			    $this->session->set_flashdata('message', 'Your form submitted successful.');
			    redirect('become-volunteer'); 
	        } else {
	        	$this->session->set_flashdata('class', 'danger');
	     		$this->session->set_flashdata('message', 'Your form submitted failed.');
	     		redirect('become-volunteer'); 
	        }
        	exit;
        }else{
        	 $this->session->set_flashdata('class', 'danger');
	     	 $this->session->set_flashdata('message', 'Sorry Google Recaptcha Unsuccessful!!');
	     	 redirect('become-volunteer'); 
        }
        
	}



	public function gallary(){
		$data['app_name']=APP_NAME;
		$data['link']='gallary';
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		//$data['post'] = $this->db->select('*')->where(['delete_status'=>'0'])->order_by('id','desc')->get('gallary')->result_array();
		$data_post = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->order_by('id','desc')->get('post')->result_array();
		$arr=[];
		foreach ($data_post as $row) {
			$arrr = explode(',', $row['images']);
			foreach ($arrr as $img) {
				$a['images']=$img;
				$a['category']=preg_replace('/_/', ' ', $row['category']);;
				$arr[]=$a;
			}
		}
		$data['post']=$arr;
		$this->load->view('gallary',$data);
	}

	public function structure(){
		$data['app_name']=APP_NAME;
		$data['link']='structure';
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$this->load->view('structure',$data);
	}

	 public function tree_plantation(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['post'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1','category'=>'tree_plantation'])->order_by('id','desc')->get('post')->result_array();
		$this->load->view('post',$data);
	}

	 public function animal_walfare(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['post'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1','category'=>'animal_walfare'])->order_by('id','desc')->get('post')->result_array();
		$this->load->view('post',$data);
	}

	 public function envoirment_protection(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['post'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1','category'=>'envoirment_protection'])->order_by('id','desc')->get('post')->result_array();
		$this->load->view('post',$data);
	}

	 public function blood_donation(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['post'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1','category'=>'blood_donation'])->order_by('id','desc')->get('post')->result_array();
		$this->load->view('post',$data);
	}

	 public function social_work(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		   $data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['post'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1','category'=>'social_work'])->order_by('id','desc')->get('post')->result_array();
		$this->load->view('post',$data);
	}

	public function education(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['post'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1','category'=>'education'])->order_by('id','desc')->get('post')->result_array();
		$this->load->view('post',$data);
	}

	public function upcoming($id){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['upcoming'] = $this->db->select('*')->where(['delete_status'=>'0','id'=>$id])->order_by('id','desc')->get('upcoming')->row_array();
		$this->load->view('upcoming',$data);
	}


	public function upcoming_list(){
		$data['app_name'] = APP_NAME;
		$data['link'] = 'post';
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$data['post'] = $this->db->select('*')->where(['delete_status'=>'0'])->order_by('id','desc')->get('upcoming')->result_array();
		$this->load->view('upcoming-details',$data);
	}

	public function support_detail(){
		$id = $this->uri->segment(2);
		$data['app_name'] = APP_NAME;
		$data['link'] = 'Support';
		
		$data['post'] = $this->db->select('*')->where(['id'=>$id])->get('support')->row_array();
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$this->load->view('support_me',$data);
	}


	function mailSend(){
		sendEmail('ajit@yopmail.com', 'Welcome hello', 'hello world');
	}
	
	public function our_partner(){
		$id = $this->uri->segment(2);
		$data['app_name'] = APP_NAME;
		$data['link'] = 'our partner';
		$data['postdata'] = $this->db->select('*')->where(['delete_status'=>'0','approved'=>'1'])->limit(3)->order_by('id','desc')->get('post')->result_array();
		$this->load->view('our-partner',$data);

	}


 




}



?>