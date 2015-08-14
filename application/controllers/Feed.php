<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends MY_Controller {

	public $datetime;
	
	public function __construct()
	{
		parent::__construct();
		$this->datetime = date("Y-m-d H:i:s");
		$this->checkSession();
	}
	
	public function index()
	{
		$this->load->model('Feed/Feed_model');
		$userdata = $this->session->userdata('UserData');
		$userdatas = json_decode($userdata);
		$ceo_id = $userdatas[0]->id;
		$data['slides'] = $this->Feed_model->GetProposalForSlider($ceo_id);
		$data['getNotifications'] = $this->getNotifications(); 
		$data['proposal'] = $this->GetCEOProposals($ceo_id);
		//$data['feedprop'] = $this->feed_model->GetAllFeedProposals($ceo_id);
		//$data['getFeedLogs'] = $this->feed_model->getFeedLogsModel($ceo_id);
		
		if(!empty($data))
		{
			$this->load->view('templates/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('feed');
			$this->load->view('templates/footer');
			$this->load->view('templates/feed_footer_script');
		}else{
			$this->load->view('templates/header');
			$this->load->view('templates/menu');
			$this->load->view('feed');
			$this->load->view('templates/footer');
			$this->load->view('templates/feed_footer_script');
		}
	}
	
	public function feedsliderfollow(){
		$this->load->model('Feed/Feed_model');
		$followinfo = $this->input->post();
		$this->Feed_model->feedsliderfollowModel($followinfo);
	}
	
}
