<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->checkSession();
	}
	
	public function TermsOfUse()
	{
		$this->load->view('templates/header');
		$this->load->view('Terms/termsofuse_view');
		$this->load->view('templates/footer');
	}
	public function PrivacyPolicy()
	{
		$this->load->view('templates/header');
		$this->load->view('Terms/privacypolicy_view');
		$this->load->view('templates/footer');
	}
	
	public function Copyright()
	{
		$this->load->view('templates/header');
		$this->load->view('Terms/copyright_view');
		$this->load->view('templates/footer');
	}
}
