<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->datetime = date("Y-m-d H:i:s"); 
		$this->load->model('Proposal/Proposal_model');
	}
	public function index()
	{
		if($this->session->userdata('logout_msg') != ""){
			$data['logout_msg'] = $this->session->userdata('logout_msg');	
		}
		else if($this->session->userdata('msg') != ""){
			$set_data = $this->session->userdata('msg');
			$data = array ( 'message' => $set_data, 'message1' => "You can now login by your login details" );
		}
		else if($this->session->userdata('succ_msg') != ""){
			$data['succ_msg'] = $this->session->userdata('succ_msg');	
		}
		if(!empty($data)){
			$this->load->view('templates/header');
			$this->load->view('Login/login_view',$data);
			$this->load->view('templates/footer');
			$this->load->view('templates/login_footer_script');
		}
		else{
			$this->load->view('templates/header');
			$this->load->view('Login/login_view');
			$this->load->view('templates/footer');
			$this->load->view('templates/login_footer_script');
		}
		$this->session->unset_userdata('msg');
		$this->session->unset_userdata('logout_msg');
		$this->session->unset_userdata('succ_msg');
	}
		
	public function register()
	{
		if($this->session->userdata('UserData') == "")
		{
			$data['group'] = $this->GetGroupNames();
			$data['industries'] = $this->getIndustriesList();
			$this->load->view('templates/header');
			$this->load->view('templates/menu_second');
			$this->load->view('Login/registration',$data);
			$this->load->view('templates/footer');
			$this->load->view('templates/registration_footer_script');
		} else {
			redirect('/Feed/');
		}
	}
	
	public function checkLogin(){
			
		$data = array(
					'login_username' => $this->input->post('login_username'),
					'login_password' => $this->input->post('login_password')
				);
		$this->load->model('Login/User_login_model');
		
		$res = $this->User_login_model->check_user( $data );
		
		if( !empty( $res ) ) { 
			$result = json_encode($res); 
			$data['UserData'] = $result;
			$this->session->set_userdata('UserData',$data['UserData']);
			$this->session->userdata('UserData');
			$status = 1;
		}
		else {
			$status = "";
		}
		echo $status; 
	}
	
	public function GetRegister()
	{
		
		$this->load->model('Login/User_login_model');
		
			if($this->input->post('linkedin_url2') != "") {
			  $linkedin_url = $this->input->post('linkedin_url2');
			} else {
			  $linkedin_url = "";
			}
		$textToStore = nl2br(htmlentities($this->input->post('description'), ENT_QUOTES, 'UTF-8'));
		// Setting Values For Tabel Columns
		$data['registration'] = array( 
			
				array(
					  'vistage_id' 	=> 	$this->input->post('vistage_group_id'),
					  'first_name' 	=> 	$this->input->post('name'),
					  'last_name' 	=> 	$this->input->post('surname'),
					  'nickname' 	=> 	$this->input->post('nickname'),
					  'email' 		=> 	$this->input->post('email'),
					  'password' 	=> 	md5($this->input->post('password')),
					  'linkedin_url'=> 	$linkedin_url,
					  'last_login' 	=> 	"",
					  'created_on' 	=> 	$this->datetime,
					  'updated_on' 	=> 	"",
					  'deleted_on' 	=> 	"",
					  'is_active' 	=> 	true
					),
				
				array(
					  'business_name'		=> 	$this->input->post('business_name'),
					  'CUIT'				=> 	$this->input->post('CUIT'),
					  'logo_url'			=> 	"",
					  'background_img_url' 	=> 	"",
					  'website_url' 		=> 	$this->input->post('website_url'),
					  'description' 		=>	$textToStore,
					  'created_on' 			=> 	$this->datetime,
					  'updated_on' 			=> 	"",
					  'deleted_on' 			=> 	"",
					  'is_active' 			=> 	true
					),
				
				array(
					  'tags_value'		=> $this->input->post('tag_value')
					),
				array(
					'upload_file'		=>	$_FILES
				)
		
		);	
		$query = $this->User_login_model->RegisterUser( $data );
			
		if( $query == TRUE )
			{
				$data = array( 'message' => 'Registered Successfully!' );
				$this->session->set_userdata('msg',$data['message']);
			} 
		else 
			{
				$data = array( 'message' => 'Query Error!');
				$this->session->set_userdata('msg',$data['message']);
			}
			redirect(); 
	}
	
	public function ForgetPassword()
	{
		if( $this->session->userdata('login_mess') != "" ){
			$set_data = $this->session->userdata('login_mess');
			$data = array ( 'login_mess' => $this->session->userdata('login_mess') );
			$this->load->view('templates/header');
			$this->load->view('Login/forget_pwd', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/login_footer_script');
 		}
		else if( $this->session->userdata('updatemsg') != "" ){
			$data = array ( 'updatemsg' => $this->session->userdata('updatemsg') );
			$this->load->view('templates/header');
			$this->load->view('Login/forget_pwd', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/login_footer_script');
 		}
		else{
			$this->load->view('templates/header');
			$this->load->view('Login/forget_pwd');
			$this->load->view('templates/footer');
			$this->load->view('templates/login_footer_script');
		}
		$this->session->unset_userdata('login_mess');
		$this->session->unset_userdata('updatemsg');
	}
	
	public function GetPassword()
	{
		$this->load->model('Login/User_login_model');
		
		$this->form_validation->set_rules('for_username', 'Username', 'trim|required');
		
		if ($this->form_validation->run() == FALSE){
			$data = array( 'login_mess' => 'Username Required!!');
			$this->session->set_userdata('login_mess',$data['login_mess']);
		}
		else{	
		$data = array(
			'for_username' => $this->input->post('for_username'),
		);
		
		$query = $this->User_login_model->check_forget_user( $data );
		
		if( $query['status'] == TRUE )
			{
				$config['protocol'] = 'mail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'iso-8859-1';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				
				$this->email->initialize($config);
				$this->email->from('pardeep@ingeniousonline.co.in', 'Pardeep Kumar');
				$this->email->to($this->input->post('for_username'));
				$this->email->subject('Email Test');
				$mailmessage = "Click below for recover your password <br>";
				$mailmessage .= "<a href='".base_url()."/index.php/login/ForgetPassword?e=".base64_encode($data['for_username'])."&es=".$query['string']."'>".base_url()."index.php/login/ForgetPassword?e=".base64_encode($data['for_username'])."&es=".$query['string']."</a>";
				$this->email->message($mailmessage);
				if ( $this->email->send())
				{
					$data = array( 'login_mess' => 'Check Your Mails!' );
					$this->session->set_userdata('login_mess',$data['login_mess']);
				}
				else {
					// Generate error
					$data = array( 'login_mess' => 'Mail not sent! Please try again later!' );
					$this->session->set_userdata('login_mess',$data['login_mess']);
					$this->email->print_debugger();
				}
				
			} 
		else 
			{
				$data = array( 'login_mess' => 'Username / Email does not recognised!!');
				$this->session->set_userdata('login_mess',$data['login_mess']);
			}
		}
		redirect('/login/ForgetPassword');
	}
	
	
	public function GetGroupNames(){
		$this->load->model('Login/User_login_model');
		$query = $this->User_login_model->GetGroupNamesModel( );
		return $query;
	}
	
	
	public function UpdatePassword(){
		
		$this->load->model('Login/User_login_model');
		
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
		
			if ($this->form_validation->run() == FALSE)
			{
				$data = array( 'updatemsg' => 'Please fill the password');
				$this->session->set_userdata('updatemsg',$data['updatemsg']);
				redirect($this->input->post('c_url'));
			}
			else
			{
				$new_password = $this->input->post('new_password');
				$uppercase = preg_match('@[A-Z]@', $new_password);
				$lowercase = preg_match('@[a-z]@', $new_password);
				$number    = preg_match('@[0-9]@', $new_password);
				if(!$uppercase || !$lowercase || !$number || strlen($new_password) < 8) {
					$data = array( 'updatemsg' => '<span style="color:red">Password contains 8 alphanumeric with atleast 1 Capital letter!</span>');
					$this->session->set_userdata('updatemsg',$data['updatemsg']);
					redirect($this->input->post('c_url'));
				}
				else {
					$data = array(
									'password' => $this->input->post('new_password'),
									'email' => $this->input->post('email_id'),
									'email_str' => $this->input->post('email_str')
								);
					$report = $this->User_login_model->UpdatePass( $data );
					 
					 if ($report['status'] == TRUE) {
						// update successful
						//$data = array( 'updatemsg' => 'Update Successfully!!');
						$this->session->set_userdata('updatemsg',$report['message']);
					} else {
						// update failed
						//$data = array( 'updatemsg' => 'No Changes Made!!');
						$this->session->set_userdata('updatemsg',$report['message']);
					}
				}
			} 
		
		redirect('/login/ForgetPassword');
		
	}
	
	public function getIndustriesList() {
		$this->load->model('Login/User_login_model');
		$query = $this->User_login_model->getIndustriesListModel( );
		return $query;
	}
	
	
	public function EditProfile() {
		$this->checkSession();
		$this->load->model('Login/User_login_model');
		$this->load->model('Proposal/Proposal_model');
		$sessiondata = $this->session->userdata('UserData');
		$data['selected_industries'] = $this->User_login_model->getSelectedIndustries( $sessiondata );
		$data['industries'] = $this->getIndustriesList();
		$data['getGroups'] = $this->User_login_model->GetGroupNamesModel( );
		$data['EditProfileMsg'] = $this->session->userdata('EditProfileMsg');
		$data['result'] = $this->Proposal_model->GetCEOInfo();
		$data['proposal'] = $this->Proposal_model->GetCEOProposals($data['result'][0]['id']);
		$data['business_industry'] = $this->Proposal_model->GetCEOBusinessIndustry($data['result'][0]['id']);
		$data['getNotifications'] = $this->getNotifications();
		$data['getfriendrequest'] = $this->getFriendRequestsNotifications();
		$this->load->view('templates/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('Login/edit_profile',$data);
		$this->load->view('templates/footer');
		$this->load->view('templates/registration_footer_script');
		$this->session->unset_userdata('EditProfileMsg');
	}
	public function UpdateProfile() {
		$this->load->model('Login/User_login_model');
		$beforeemail = $this->input->post('useremail');
		$data = array( 
			array(
				'editprofile' => $_POST
			), 
			array(
				'uploadfiles'=> $_FILES
				)
			);
		$response = $this->User_login_model->UpdateProfileModel($data);
		
		if(isset($response['success']) && !empty($response['success']))
		{
			$results = json_encode($response['success']); 
			$test = json_decode($results,true);
			if($test[0]['email'] != $beforeemail){
				$this->session->unset_userdata('UserData');
				$data['succ_msg'] = "<label class='logout_email_changed'>Profile Successfully Updated!! Login again!</label>";
				$this->session->set_userdata('succ_msg',$data['succ_msg']);
				redirect();
			}
			else{
				$data['UserData'] = $results;
				$this->session->set_userdata('UserData',$data['UserData']);
				$this->session->set_userdata('EditProfileMsg',"Successfully Updated!");
				redirect('login/EditProfile');
			}
		}
		else{
			$this->session->set_userdata('EditProfileMsg',"Not Updated!");
			redirect('login/EditProfile');
		}
	}
	
	public function logout(){
		$this->session->unset_userdata('UserData');
		$data['logout_msg'] = "You are successfully logged out!";
		$this->session->set_userdata('logout_msg',$data['logout_msg']);
		redirect('/Login/');
	}
	
	public function check_if_Exist(){
		$inputval = $this->input->post('inputval');
		$action = $this->input->post('action');
		if(!empty($inputval) && !empty($action) ){
			$this->load->model('Login/User_login_model');
			$res = $this->User_login_model->checkValExist($inputval, $action);
			if( $res == TRUE ) { 
				$message = 1; 
			}
			else { 
				$message = 2; 
 			}
			echo $message;
		}
		
	}
	
	public function check_if_Exist_Edit_Profile() {
		$inputval = $this->input->post('inputval');
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		if(!empty($inputval) && !empty($action) && !empty($id) )
		{
			$this->load->model('Login/User_login_model');
			$res = $this->User_login_model->checkValExistForProfile($inputval, $action, $id);
			if( $res == TRUE ) { 
				$message = 1; 
			}
			else { 
				$message = 2; 
 			}
			echo $message;
		}
	}
	
	public function CheckIndustryExist(){
		$inputval = $this->input->post('inputval');
		$action = $this->input->post('action');
		if(!empty($inputval) && !empty($action))
		{
			$this->load->model('Login/User_login_model');
			$res = $this->User_login_model->checkIndustryExistModel($inputval, $action);
			if( $res == TRUE ) { 
				$message = 1; 
			}
			else { 
				$message = 2; 
 			}
			echo $message;
		}
	}
	
	
	public function DeleteProfilePic(){
		
		$this->load->model('Login/User_login_model');
		$data['deletepic'] = array(
									'ceo_id' => $this->input->post('ceo_id'), 
									'picname' => $this->input->post('pic'),	
									'action' => $this->input->post('status')
								);
		$response = $this->User_login_model->DeleteProfilePicModel($data);
		
		if(isset($response['success']) && !empty($response['success']))
		{
			$nn = json_decode($this->session->userdata('UserData'));
			$nn[0]->ceo_profile_pic = "";
			$tt = json_encode($nn);
			$this->session->set_userdata('UserData', $tt);
		}
		
	}
	
	public function changeStatusNotification(){
		$this->load->model('Notifications/Notifications_model');
		$logid = $this->input->post('logid');
		$this->Notifications_model->changeStatusNotificationModel($logid);
	}
	
	
	
	public function getNotificationJquery(){
		$userdata = json_decode($this->session->userdata('UserData'),true);
		$ceo_id = $userdata[0]['id'];
		$this->load->model('Notifications/Notifications_model');
		$query = $this->Notifications_model->getNotificationJqueryModel($ceo_id);
		echo json_encode($query);
	}
	
	
	public function getFriendRequestsByJqueryNotifications(){
			$this->load->model('Notifications/Notifications_model');
			$userdata = json_decode($this->session->userdata('UserData'),true);
			$result = $this->Notifications_model->getFriendRequestsNotificationsModel($userdata[0]['id']);
			echo json_encode($result);
		}
	
	
}
