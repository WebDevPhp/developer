<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CompanyProfileUser extends MY_Controller {

	public $datetime;
	private $ceoid;
	private $business;
	public function __construct()
	{
		parent::__construct();
		$this->datetime = date("Y-m-d H:i:s");
		$this->checkSession();
	}

	public function index()
	{
		$this->ceoid 	= base64_decode($_GET['ci']);
		$this->business = base64_decode($_GET['bs']);
		$details['a'] = array(	'ceoid' 	=>	$this->ceoid, 'businessid' => $this->business	);
		$this->load->model('Company/Company_profile_user_model');
		$data['info'] = $this->Company_profile_user_model->getOtherUserInfo($details['a']);
		$data['getNotifications'] = $this->getNotifications(); 
		$data['getfriendrequest'] = $this->getFriendRequestsNotifications();
		$data['checkrequest'] = $this->Company_profile_user_model->getFriendRequestsModel($details['a']);
		$this->load->view('templates/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('company_profile_user',$data);
		$this->load->view('templates/footer');
		$this->load->view('templates/feed_footer_script');
	}
	
}
