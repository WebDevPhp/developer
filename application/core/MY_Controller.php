<?php

	class MY_Controller extends CI_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('Proposal/Proposal_model');
			$this->load->model('Notifications/Notifications_model');
		}
		
		public function GetCEOProposals($ceo_id)
		{
			 $this->db->select('tbl_proposals.id,tbl_proposals.ceo_id,tbl_proposals.title,tbl_proposals.description,
			 tbl_proposals.looking_for_desc,tbl_proposals.background_img_url');
			 $this->db->from('tbl_proposals');
			 $this->db->where('tbl_proposals.ceo_id', $ceo_id );
			 $this->db->where('tbl_proposals.is_active', true );
			 $query = $this->db->get();
   
		     if ($query->num_rows() > 0) { 
				return $query->result_array();
		     } 
		   	 else { 
				return false; 
		   	}
		} 
		
		public function getNotifications(){
			$userdata = json_decode($this->session->userdata('UserData'),true);
			$result = $this->Notifications_model->getNotificationModel($userdata[0]['id']);
			return $result;
		}
		
		
		public function getFriendRequestsNotifications(){
			$userdata = json_decode($this->session->userdata('UserData'),true);
			$result = $this->Notifications_model->getFriendRequestsNotificationsModel($userdata[0]['id']);
			return $result;
		}
		
		public function checkSession() {
		
			if ($this->session->userdata('UserData') == false) {
					redirect('/Login/');
			}
		}
		
	}