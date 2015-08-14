<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CompanyProfile extends MY_Controller {

	public $datetime;
	
	public function __construct()
	{
		parent::__construct();
		$this->datetime = date("Y-m-d H:i:s");
		$this->checkSession();
	}

	public function index()
	{
		$this->load->model('Company/Company_profile_model');
		$data['getIndustriesCeo'] = $this->Company_profile_model->getIndustriesCeo();
		$data['getProposalCeo'] = $this->Company_profile_model->getProposalCeo();
		$data['getNotifications'] = $this->getNotifications(); 
		$data['getfriendrequest'] = $this->getFriendRequestsNotifications();
		$userdata = $this->session->userdata('UserData');
		$userdatas = json_decode($userdata);
		$ceo_id = $userdatas[0]->id;
		$data['proposal'] = $this->GetCEOProposals($ceo_id);
		
		if(!empty($data))
		{
			$this->load->view('templates/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('company_profile',$data);
			$this->load->view('templates/footer');
			$this->load->view('templates/feed_footer_script');
		}
		else {
			$this->load->view('templates/header');
			$this->load->view('templates/menu');
			$this->load->view('company_profile');
			$this->load->view('templates/footer');
			$this->load->view('templates/feed_footer_script');
		}
		
	}
	
}
