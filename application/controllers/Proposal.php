<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->checkSession();
		$this->datetime = date("Y-m-d H:i:s"); 
		$this->load->model('Proposal/Proposal_model');
	}
	
	public function index()
	{
		$data['result'] = $this->Proposal_model->GetCEOInfo();
		$data['proposal'] = $this->Proposal_model->GetCEOProposals($data['result']['0']['id']);
		$data['message'] = $this->session->userdata('propmesg');
		$data['getNotifications'] = $this->getNotifications(); 
		$data['business_industry'] = $this->Proposal_model->getIndustries();
		$data['getfriendrequest'] = $this->getFriendRequestsNotifications();
		$this->load->view('templates/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('proposal_view',$data);
		$this->load->view('templates/footer');
		$this->load->view('templates/proposal_footer_script');
		$this->session->unset_userdata('propmesg');
	}
	public function AddProposal()
	{
		$industry_array = "";
		$industry_ids = $this->input->post('ind_id');
		if(!empty($industry_ids))
		{
			$industry_array = explode(',', $industry_ids);
		}
		
		$data['proposal_detail'] = array(
					'ceo_id'			=>	$this->input->post('ceo_id'),
					'title' 			=> 	trim($this->input->post('proposal_title')),
					'description' 		=> 	trim($this->input->post('proposal_desc')),
					'looking_for_desc' 	=> 	trim($this->input->post('proposal_benefits')),
					'background_img_url' => "",
					'created_on' 		=> 	$this->datetime,
					'updated_on' 		=> 	"",
					'deleted_on' 		=>	"",
					'is_active' 		=> 	true
				);
		$data['proposal_industry'] = array(
					'proposal_id'   => "",
					'industry_id'   => $industry_array,
					'created_on' 	=> 	$this->datetime,
					'updated_on' 		=> 	"",
					'deleted_on' 		=>	"",
					'is_active' 		=> 	true
		);
		$data['upload_file'] = $_FILES; 
		$query = $this->Proposal_model->SaveProposal( $data );
		if( $query != "" )
		{
			$pid = $query['res']; 
			$msg = array( 'message' => '<h2 style="color:#058a05;">Proposal Added!!</h2>');
			$this->session->set_userdata('detailspagemsg',$msg['message']);
			redirect('/Proposal/ProposalDetail/'.$pid);
		} 
		else 
		{
			$msg = array( 'message' => 'Query Error!');
			$this->session->set_userdata('propmesg',$msg['message']);
			redirect('/Proposal');
		}
	
	}
	public function UpdateProposal()
	{
		$industry_ids = $this->input->post('ind_id');
		if(!empty($industry_ids))
		{
		    $industry_array = explode(',', $industry_ids);
		}
		$prop_id = $this->input->post('prop_id');
		if($prop_id != '')
		{
			$data['proposal_detail'] = array(
					'ceo_id'		=>	$this->input->post('ceo_id'),
					'title' => $this->input->post('proposal_title'),
					'description' => $this->input->post('proposal_desc'),
					'looking_for_desc' => $this->input->post('proposal_benefits'),
					'background_img_url' => "",
					'updated_on' 		=> 	$this->datetime,
					'is_active' 		=> 	true
				);
			$data['proposal_industry'] = array(
					'proposal_id'   => $prop_id,
					'industry_id'   => $industry_array,
					'updated_on' 		=> 	$this->datetime,
					'is_active' 		=> 	true
			);
			$data['upload_file'] = $_FILES; 
			$prop_id = $this->Proposal_model->UpdateProposal( $data );
			if( !empty($prop_id) )
			{
				$msg = array( 'message' => '<h2 style="color:#058a05;">Proposal Updated!!</h2>');
				$pid = $this->input->post('hidden_id');
				$this->session->set_userdata('detailspagemsg',$msg['message']);
				redirect('/Proposal/ProposalDetail/'.$pid);
			} 
			else 
			{
				$data = array( 'proposal_msg' => 'Query Error!');
				$this->session->set_userdata('proposal_msg',$data['proposal_msg']);
				$path = $this->input->post('hidden_url');
				redirect($path);
			}
			
		}
		
	}
	public function ProposalEdit($proposal_id)
	{
		if($this->session->userdata('proposal_msg') != "")
		{
			$data['proposal_msg'] = $this->session->userdata('proposal_msg');
			$data['proposal_info'] = $this->Proposal_model->EditProposal($proposal_id);
			$data['result'] = $this->Proposal_model->GetCEOInfo();
			$data['proposal'] = $this->Proposal_model->GetCEOProposals($data['result']['0']['id']);
			$data['business_industry'] = $this->Proposal_model->getIndustries();
			$data['getNotifications'] = $this->getNotifications(); 
			$data['getfriendrequest'] = $this->getFriendRequestsNotifications();
			$this->load->view('templates/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('proposal_view',$data);
			$this->load->view('templates/footer');
			$this->load->view('templates/proposal_footer_script');
		}
		else{
			$data['proposal_info'] = $this->Proposal_model->EditProposal($proposal_id);
			$data['result'] = $this->Proposal_model->GetCEOInfo();
			$data['proposal'] = $this->Proposal_model->GetCEOProposals($data['result']['0']['id']);
			$data['business_industry'] = $this->Proposal_model->getIndustries();
			$data['getNotifications'] = $this->getNotifications(); 
			$data['getfriendrequest'] = $this->getFriendRequestsNotifications();
			$this->load->view('templates/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('proposal_view',$data);
			$this->load->view('templates/footer');
			$this->load->view('templates/proposal_footer_script');
		}
		$this->session->unset_userdata('proposal_msg');
	}
	
	public function ProposalDetail($proposal_id)
	{
		$data['proposal_info'] = $this->Proposal_model->EditProposal($proposal_id);
		$data['succmsg'] = $this->session->userdata('detailspagemsg');	
		$data['result'] = $this->Proposal_model->GetCEOInfo();
		$data['proposal'] = $this->Proposal_model->GetCEOProposals($data['result']['0']['id']);
		$data['getfriendrequest'] = $this->getFriendRequestsNotifications();
		$data['proposal_industry'] = $this->Proposal_model->getIndustries();
		$data['getNotifications'] = $this->getNotifications(); 
		$data['total_lunches'] = $this->Proposal_model->getLunchesonProposal($proposal_id);
		$this->load->view('templates/header');
		$this->load->view('templates/menu', $data);
		$this->load->view('proposal_detail_view', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/proposal_detail_footer_script');
		$this->session->unset_userdata('detailspagemsg');
	}
	
	public function addComments(){
		$effect = $this->Proposal_model->addCommentModel($_POST);
		if($effect != ""){
			//redirect('/Proposal/ProposalDetail/'.$effect);
			echo json_encode($effect);
		}
	}
	
	
	public function lunchRequest(){
		$this->Proposal_model->lunchRequestModel($this->input->post());
	}
	
	
	public function followProposal(){
		$this->Proposal_model->followProposalModel($this->input->post());
	}
	
	public function unfollowProposal(){
		$this->Proposal_model->unfollowProposalModel($this->input->post());
	}
	
	public function getPopupLunchInfo(){
		$proid = $this->input->post('propid');
		$this->Proposal_model->getPopupLunchInfoModel($proid);
	}
	
	public function getPopupFollowInfo(){
		$proid = $this->input->post('propid');
		$this->Proposal_model->getPopupFollowInfoModel($proid);
	}
	
}
