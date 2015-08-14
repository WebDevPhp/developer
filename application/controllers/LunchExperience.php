<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LunchExperience extends MY_Controller {

	public $datetime;
	
	public function __construct()
	{
		parent::__construct();
		$this->datetime = date("Y-m-d H:i:s");
		// $this->checkSession();
	}

	public function index()
	{
		$this->load->model('Lunch/Lunch_experience_model');
		$a = "";
		$b="";
		$a['lunchinfo'] = array(
								'log_id' 	=> base64_decode($this->input->get('log_id')),
								'requester' => base64_decode($this->input->get('requester')),
								'accepter' 	=> base64_decode($this->input->get('accepter')),
								'propid' 	=> base64_decode($this->input->get('propid')),
								'lunchid' 	=> base64_decode($this->input->get('lunchid')),
								'rateby' 	=> $this->input->get('rateby')
							);
		$a['getLunchInfo'] = $this->Lunch_experience_model->getLunchInfoModel($a);
		if($this->input->get()){
			$this->load->view('templates/header');
			$this->load->view('experience_form',$a);
			$this->load->view('templates/footer');
			$this->load->view('templates/proposal_footer_script');
		}
		else {
			$b['ratingmsg'] = $this->session->userdata('ratingmsg');
			$this->load->view('templates/header');
			$this->load->view('experience_form',$b);
			$this->load->view('templates/footer');
			$this->load->view('templates/proposal_footer_script');
		}
		$this->session->unset_userdata('ratingmsg');
	}
	
	public function AddRatings(){
		$this->load->model('Lunch/Lunch_experience_model');
		$post = $this->input->post();
		$query = $this->Lunch_experience_model->lunchRatingUpdate($post);
		if($query == true){
			$this->session->set_userdata('ratingmsg','<h1>Thanks for rating!</h1>');
			redirect('/LunchExperience');
		}
	}
	
}
