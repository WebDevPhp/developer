<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends MY_Controller {

	public $datetime;
	
	public function __construct()
	{
		parent::__construct();
		$this->datetime = date("Y-m-d H:i:s");
		$this->checkSession();
		$this->load->model('Messages/Message_model');
	}

	public function index()
	{
		$data['getNotifications'] = $this->getNotifications(); 
		$userdata = $this->session->userdata('UserData');
		$userdatas = json_decode($userdata);
		$ceo_id = $userdatas[0]->id;
		$data['proposal'] = $this->GetCEOProposals($ceo_id);
		$data['connections'] = $this->Message_model->getConnectionsModel($ceo_id);
		if(!empty($data))
		{
			$this->load->view('templates/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('messages_fullview',$data);
			$this->load->view('templates/footer');
			$this->load->view('templates/feed_footer_script');
		}
		else {
			$this->load->view('templates/header');
			$this->load->view('templates/menu');
			$this->load->view('messages_fullview');
			$this->load->view('templates/footer');
			$this->load->view('templates/feed_footer_script');
		}
	
	}
	
	public function MessageSave(){
		$msginfo = $this->input->post();
		$msgs = $this->Message_model->MessageSaveModel($msginfo);
		echo json_encode($msgs);
	}
	
	public function getmessageslist(){
		$userdata = $this->session->userdata('UserData');
		$userdatas = json_decode($userdata);
		$ceo_id = $userdatas[0]->id;
		$data = array(
					'sender_ceo' => $this->input->post('ceo_id'),
					'currrent_ceo' => $ceo_id,
					);
		$results = $this->Message_model->getmessageslistModel($data);
		echo json_encode($results);
	}
	
	
	public function AutoCompleteName(){
		$results = $this->Message_model->AutoCompleteNameModel($this->input->get());
		echo json_encode($results);
	}
	
}
