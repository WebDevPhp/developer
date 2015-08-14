<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cover extends MY_Controller {

	public $datetime;
	
	public function __construct()
	{
		parent::__construct();
		$this->datetime = date("Y-m-d H:i:s");
	}

	public function index(){

		$this->load->view('templates/header');
		$this->load->view('Login/cover_view');
		$this->load->view('templates/footer');
		$this->load->view('templates/login_footer_script');
	
	}
	
}
