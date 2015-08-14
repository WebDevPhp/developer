<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdvanceSearch extends MY_Controller {

	public $datetime;
	
	public function __construct()
	{
		parent::__construct();
		$this->datetime = date("Y-m-d H:i:s");
		$this->checkSession();
	}

	public function index()
	{
		//$this->load->model('Company/company_profile_model');
		$data = "";
		$data['getNotifications'] = $this->getNotifications(); 
		$userdata = $this->session->userdata('UserData');
		$userdatas = json_decode($userdata);
		$ceo_id = $userdatas[0]->id;
		
		$this->load->view('templates/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('advance_search');
		$this->load->view('templates/footer');
		$this->load->view('templates/feed_footer_script');
		
	}
	
	public function AdvanceSearch(){
		$array 	= 	array(	
							'search' => $this->input->post('radioval'),
							'ceo_id' => $this->input->post('current_ceo')
						);
		$this->load->model('AdvanceSearch/Advance_search_model');
		$this->Advance_search_model->AdvanceSearchModel($array);
	}
	
	
}
