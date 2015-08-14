<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications_model extends CI_Model {
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->datetime = date("Y-m-d H:i:s"); 	
        }
		
		
//***** FOR GETTING NOTIFICATION *****//

		public function getNotificationModel($id){
			
			$getnotification = array();
			$getlogs = array();
			$getn = array();
			$dd = array();
			
			/*******************Industry related proposal*********************/
			
			$this->db->select('tbl_businesses_industries.industry_id');
			$this->db->from('tbl_ceos');
			$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
			$this->db->join('tbl_businesses_industries', 'tbl_businesses_industries.business_id  = tbl_ceo_business_details.business_id');
			$this->db->where('tbl_ceos.id',$id);
			$this->db->where('tbl_businesses_industries.is_active',true);
			$ww = $this->db->get();
			if($ww->num_rows() > 0){
				$i=0;
				foreach($ww->result_array() as $re){
					if($i==0){
						$this->db->distinct('proposal_id');
						$this->db->select('proposal_id');
						$this->db->from('tbl_proposals_industries');
						$this->db->where(array(
												'industry_id'=>$re['industry_id'],
												'is_active'=>true
											));
						$cv = $this->db->get();
						
						if($cv->num_rows() > 0)
						{
							$dd[] = $cv->result_array();
						}
					}
					$i++;
				}
				if(!empty($dd))
				{
					foreach($dd as $d) {
						
						foreach($d as $c){
							
							$this->db->select('tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.is_notified, tbl_logs.is_viewed, tbl_logs.created_on as logtime, tbl_proposals.title, tbl_proposals.background_img_url as proposal_background_img, tbl_proposals.description, tbl_proposals.ceo_id as proposal_ceo, tbl_proposals.id as proposal_id, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.logo_url');
							$this->db->from('tbl_logs');
							$this->db->join('tbl_proposals','tbl_proposals.id = tbl_logs.task_id');
							$this->db->join('tbl_ceos', 'tbl_ceos.id = tbl_proposals.ceo_id');
							$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
							$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id');
							$this->db->where('tbl_logs.task_id',$c['proposal_id']);
							$this->db->where('tbl_logs.log_parent_id',5);
							$ds = $this->db->get();
							if($ds->num_rows() > 0){
								$c = $ds->result_array();
								$restproposals[] = $c[0];
							}
							if(!empty($restproposals)) {
								$countlunch = 0;
								$countfollows = 0;
								foreach($restproposals as $key => $r) {
									$this->db->select('id');
									$this->db->from('tbl_lunches');
									$this->db->where('proposal_id',$r['proposal_id']);
									$this->db->where('is_active',true);
									$ccs = $this->db->get();
									$countlunch = $ccs->num_rows();
									$restproposals[$key]['totallunches'] = $countlunch;
								}
								
								foreach($restproposals as $key => $r) {
									$this->db->select('id');
									$this->db->from('tbl_follows');
									$this->db->where('proposal_id',$r['proposal_id']);
									$this->db->where('is_active',true);
									$ccs = $this->db->get();
									$countfollows = $ccs->num_rows();
									$restproposals[$key]['totalfollows'] = $countfollows;
								}
							
							}
						
						}
					}
				}
				
			}
			
			
			/*********************************************************/
			
			
			
			
			/***************Connection Updates*********************/
			
			$this->db->where("(ceo1_id = $id OR ceo2_id = $id)", NULL, FALSE);
			$this->db->where('accepted',true);
			$this->db->where('is_active',true);
			$g = $this->db->get('tbl_connections');
			
			if($g->num_rows() > 0 ){
				foreach($g->result() as $reas) {
					if($reas->ceo1_id == $id)
					{
						$get[] = array(
										'connection'=>$reas->ceo2_id, 
										'connection_date'=>$reas->created_on
									);
					}
					else if($reas->ceo2_id == $id)
					{
						$get[] = array(
										'connection'=>$reas->ceo1_id, 
										'connection_date' =>$reas->created_on
									);
					}
				}
			}
			
			if(!empty($get))
			{
				
				for($c=0;$c<count($get);$c++)
				{
					$this->db->select('*');
					$this->db->from('tbl_logs');
					$this->db->where("(performed_by_ceo='".$get[$c]['connection']."' AND log_parent_id = 12 AND is_active=true)");
					$this->db->or_where("(performed_to_ceo='".$get[$c]['connection']."' AND log_parent_id = 14 AND is_active=true)");
					$this->db->or_where("(performed_by_ceo='".$get[$c]['connection']."' AND log_parent_id = 20 AND is_active=true)");
					$this->db->or_where("(performed_to_ceo='".$get[$c]['connection']."' AND log_parent_id = 15 AND is_active=true)");
					$this->db->or_where("(performed_to_ceo='".$get[$c]['connection']."' AND log_parent_id = 2 AND is_active=true)");
					$this->db->or_where("(performed_by_ceo='".$get[$c]['connection']."' AND log_parent_id = 2 AND is_active=true)");
					$this->db->or_where("(performed_by_ceo='".$get[$c]['connection']."' AND log_parent_id = 5 AND is_active=true)");
					$this->db->or_where("(performed_to_ceo='".$get[$c]['connection']."' AND log_parent_id = 8 AND is_active=true)");
					$f = $this->db->get();
					if($f->num_rows() > 0){
						foreach($f->result_array() as $res) {
							
							$task_id = $res['task_id'];
							$log_id = $res['log_id'];
							$logtime = $get[$c]['connection_date'];
							$currentuserid = $id;
							$log_parent_id = $res['log_parent_id'];
							$performed_by_ceo = $res['performed_by_ceo'];
							$performed_to_ceo = $res['performed_to_ceo'];
							
							//lunch request accepted query
							if($log_parent_id == 12) {
								
								$this->db->select(
												'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime, tbl_ceos.first_name as proposal_ceo_fname, tbl_ceos.last_name as proposal_ceo_lname, tbl_ceos.nickname as proposal_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as proposal_ceo_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name, c.first_name as requester_fn, c.last_name as requester_ln, c.nickname as requester_nick, c.ceo_profile_pic as requester_pic');
								$this->db->from('tbl_logs');
								$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
								$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
								$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
								$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
								$this->db->join('tbl_ceos c','c.id = tbl_logs.performed_to_ceo');
								$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_to_ceo');
								$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
								$this->db->where('tbl_logs.log_id',$log_id);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$this->db->where('tbl_logs.is_active',true);
								$query = $this->db->get();
								
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
							}
							
							//Connection Request Accepted
							if($log_parent_id == 2) {
						
								$this->db->select('tbl_ceos.id, c.first_name as current_ceo_fname, 
													c.last_name as current_ceo_lname, c.ceo_profile_pic as current_ceo_pic, 
													c.nickname as current_ceo_nickname, bd.business_id as current_user_bussiness_id, b.business_name as current_user_bussiness_name, tbl_ceos.first_name,
													tbl_parent_logs.parent_name,  tbl_ceos.last_name, tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_logs.*, tbl_logs.created_on as logtime, 
													tbl_businesses.id as business_id, tbl_businesses.business_name, 
													tbl_businesses.logo_url'
												);
								$this->db->from('tbl_ceos');
								$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id');
								$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
								$this->db->join('tbl_logs', 'tbl_logs.performed_by_ceo = tbl_ceos.id');
								$this->db->join('tbl_ceos c', 'c.id = tbl_logs.performed_to_ceo');
								$this->db->join('tbl_ceo_business_details bd', 'bd.ceo_id = c.id');
								$this->db->join('tbl_businesses b', 'b.id = bd.business_id');
								$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
								$this->db->where('tbl_ceos.id',$performed_by_ceo);
								$this->db->where('tbl_logs.performed_to_ceo',$id);
								$this->db->where('tbl_logs.log_id',$log_id);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$query = $this->db->get();
								
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								}
								
							}
							
								
							//Add Proposal Connection
							if($log_parent_id == 5) {
								
								$this->db->select('tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.is_notified, tbl_logs.is_viewed, tbl_logs.created_on as logtime, tbl_proposals.title, tbl_proposals.background_img_url as proposal_background_img, tbl_proposals.description, tbl_proposals.ceo_id as proposal_ceo, tbl_proposals.id as proposal_id, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.logo_url');
								$this->db->from('tbl_logs');
								$this->db->join('tbl_proposals','tbl_proposals.id = tbl_logs.task_id');
								$this->db->join('tbl_ceos', 'tbl_ceos.id = tbl_proposals.ceo_id');
								$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
								$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id');
								$this->db->where('tbl_logs.log_id',$log_id);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$query = $this->db->get();
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
								 
								
							} 
							
							
							//proposal comment
							if($log_parent_id == 8) {
								
								$this->db->select("tbl_parent_logs.parent_name, tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_comments.proposal_id, tbl_comments.message, tbl_ceos.first_name as commenter_fname, tbl_ceos.nickname as commenter_nickname, tbl_ceos.last_name as commenter_lname, tbl_ceos.ceo_profile_pic, tbl_proposals.title, c.nickname as receiver_nickname");
								$this->db->from("tbl_logs");
								$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
								$this->db->join("tbl_comments","tbl_comments.id = tbl_logs.task_id");
								$this->db->join("tbl_proposals","tbl_proposals.id = tbl_comments.proposal_id");
								$this->db->join("tbl_ceos","tbl_ceos.id = tbl_comments.ceo_id");
								$this->db->join("tbl_ceos c","c.id = tbl_logs.performed_to_ceo");
								$this->db->where("tbl_logs.log_id",$log_id);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$query = $this->db->get(); 
								
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
							}
							
							
							//Lunch Request Accepted
							if($log_parent_id == 14) {
						
								$this->db->select(
												'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime,tbl_lunches.rate_1 as requester_rating, tbl_lunches.feedback_desc_1 as requester_feedback, tbl_lunches.rate_2 as acepter_rating, tbl_lunches.feedback_desc_2 as acepter_feedback, tbl_ceos.first_name as proposal_ceo_fname, tbl_ceos.last_name as proposal_ceo_lname, tbl_ceos.nickname as proposal_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as proposal_ceo_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name, tbl_ceos.first_name as rater_fn, tbl_ceos.last_name as rater_ln, tbl_ceos.nickname as rater_nick, tbl_ceos.ceo_profile_pic as rater_pic, c.nickname as req_nick');
								$this->db->from('tbl_logs');
								$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
								$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
								$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
								$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
								$this->db->join('tbl_ceos c','c.id = tbl_logs.performed_to_ceo');
								$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_by_ceo');
								$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
								$this->db->where('tbl_logs.log_id',$log_id);
								$this->db->where('tbl_logs.is_active',true);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$this->db->where('tbl_lunches.lunch_request_status',2);
								$query = $this->db->get();
								
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
							}
							
							//Connection profile update
							if($log_parent_id == 20) {
							
								$this->db->select('tbl_logs.log_id, tbl_parent_logs.parent_name, tbl_logs.log_parent_id, tbl_logs.created_on as logtime, tbl_ceos.id as updater_ceo_id, tbl_businesses.id as updater_business_id,tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name');
								
								$this->db->from('tbl_logs');
								$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
								$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
								$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id' );
								$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id' );
								$this->db->where('tbl_ceos.id',$performed_by_ceo);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$this->db->where('tbl_logs.log_id',$log_id);
								$query = $this->db->get();
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
							}
						
						}
					
					}
					
				}
			
			}
			
			/*****************************************************/
			$where = array(
							'tbl_logs.performed_to_ceo'=>$id,
							'tbl_logs.performed_by_ceo !='=>$id,
							'tbl_logs.log_parent_id !='=>3,
							'tbl_logs.is_active'=>true
						);
			
			$this->db->select('tbl_parent_logs.parent_name,
								tbl_parent_logs.parent_table,
								tbl_logs.log_id, 
								tbl_logs.log_parent_id, 
								tbl_logs.performed_by_ceo, 
								tbl_logs.performed_to_ceo, 
								tbl_logs.task_id, 
								tbl_logs.created_on, 
								tbl_logs.is_viewed'
							);
			$this->db->from('tbl_parent_logs');
			$this->db->join('tbl_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
			$this->db->where($where);
			//$this->db->where('tbl_logs.log_parent_id !=',5);
			$this->db->order_by('tbl_logs.log_id','desc');
			//$this->db->limit(10);
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				$getlogs[] = $result->result_array();
			}
			
			if(!empty($getlogs))
			{
				foreach( $getlogs[0] as $log ) :
				
					$task_id = $log['task_id'];
					$log_id = $log['log_id'];
					$currentuserid = $id;
					$log_parent_id = $log['log_parent_id'];
					$performed_by_ceo = $log['performed_by_ceo'];
					$performed_to_ceo = $log['performed_to_ceo'];
				 
					if($log_parent_id == 1) {
						$this->db->select('tbl_ceos.id, tbl_ceos.first_name,tbl_parent_logs.parent_name,  tbl_ceos.last_name, tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_logs.*, tbl_logs.created_on as logtime, tbl_businesses.id as business_id, tbl_businesses.business_name, tbl_businesses.logo_url');
						$this->db->from('tbl_ceos');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->join('tbl_logs', 'tbl_logs.performed_by_ceo = tbl_ceos.id');
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->where('tbl_ceos.id',$performed_by_ceo);
						$this->db->where('tbl_logs.performed_to_ceo',$id);
						$this->db->where('tbl_logs.log_id',$log_id);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						}
					}
					
					if($log_parent_id == 2) {
						
						$this->db->select('tbl_ceos.id, c.first_name as current_ceo_fname, 
											c.last_name as current_ceo_lname, c.ceo_profile_pic as current_ceo_pic, 
											c.nickname as current_ceo_nickname, bd.business_id as current_user_bussiness_id, b.business_name as current_user_bussiness_name, tbl_ceos.first_name,
											tbl_parent_logs.parent_name,  tbl_ceos.last_name, tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_logs.*, tbl_logs.created_on as logtime, 
											tbl_businesses.id as business_id, tbl_businesses.business_name, 
											tbl_businesses.logo_url'
										);
						$this->db->from('tbl_ceos');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->join('tbl_logs', 'tbl_logs.performed_by_ceo = tbl_ceos.id');
						$this->db->join('tbl_ceos c', 'c.id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_ceo_business_details bd', 'bd.ceo_id = c.id');
						$this->db->join('tbl_businesses b', 'b.id = bd.business_id');
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->where('tbl_ceos.id',$performed_by_ceo);
						$this->db->where('tbl_logs.performed_to_ceo',$id);
						$this->db->where('tbl_logs.log_id',$log_id);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						}
					}
					
				 
					if($log_parent_id == 8) {
						
						$this->db->select("tbl_parent_logs.parent_name, tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_comments.proposal_id, tbl_comments.message, tbl_ceos.first_name as commenter_fname, tbl_ceos.nickname as commenter_nickname, tbl_ceos.last_name as commenter_lname, tbl_ceos.ceo_profile_pic, tbl_proposals.title, c.nickname as receiver_nickname");
						$this->db->from("tbl_logs");
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->join("tbl_comments","tbl_comments.id = tbl_logs.task_id");
						$this->db->join("tbl_proposals","tbl_proposals.id = tbl_comments.proposal_id");
						$this->db->join("tbl_ceos","tbl_ceos.id = tbl_comments.ceo_id");
						$this->db->join("tbl_ceos c","c.id = tbl_logs.performed_to_ceo");
						$this->db->where("tbl_logs.log_id",$log_id);
						$query = $this->db->get(); 
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					
					//lunch request query
					if($log_parent_id == 11) {
						
						$this->db->select(
										'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on, 
										tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime, tbl_ceos.first_name as requester_ceo_fname, tbl_ceos.last_name as requester_ceo_lname, tbl_ceos.nickname as requester_ceo_nickname, tbl_ceos.ceo_profile_pic as requester_ceo_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as responder_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name'	);
						$this->db->from('tbl_logs');
						$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
						$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->where('tbl_logs.log_id',$log_id);
						$this->db->where('tbl_logs.is_active',true);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					//lunch request accepted query
					if($log_parent_id == 12) {
						
						$this->db->select(
										'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime, tbl_ceos.first_name as proposal_ceo_fname, tbl_ceos.last_name as proposal_ceo_lname, tbl_ceos.nickname as proposal_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as proposal_ceo_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name, c.first_name as requester_fn, c.last_name as requester_ln, c.nickname as requester_nick, c.ceo_profile_pic as requester_pic');
						$this->db->from('tbl_logs');
						$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
						$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_ceos c','c.id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->where('tbl_logs.log_id',$log_id);
						$this->db->where('tbl_logs.is_active',true);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					//lunch request declined query
					if($log_parent_id == 13) {
						
						$this->db->select(
										'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on, 
										tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime, tbl_ceos.first_name as requester_ceo_fname, tbl_ceos.last_name as requester_ceo_lname, tbl_ceos.nickname as requester_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as responder_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name'	);
						$this->db->from('tbl_logs');
						$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
						$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->where('tbl_logs.log_id',$log_id);
						$this->db->where('tbl_logs.is_active',true);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					
					if($log_parent_id == 14) {
						
						$this->db->select(
										'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime,tbl_lunches.rate_1 as requester_rating, tbl_lunches.feedback_desc_1 as requester_feedback, tbl_lunches.rate_2 as acepter_rating, tbl_lunches.feedback_desc_2 as acepter_feedback, tbl_ceos.first_name as proposal_ceo_fname, tbl_ceos.last_name as proposal_ceo_lname, tbl_ceos.nickname as proposal_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as proposal_ceo_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name, tbl_ceos.first_name as rater_fn, tbl_ceos.last_name as rater_ln, tbl_ceos.nickname as rater_nick, tbl_ceos.ceo_profile_pic as rater_pic, c.nickname as req_nick');
						$this->db->from('tbl_logs');
						$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
						$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_ceos c','c.id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->where('tbl_logs.log_id',$log_id);
						$this->db->where('tbl_logs.is_active',true);
						$this->db->where('tbl_lunches.lunch_request_status',2);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					
					if($log_parent_id == 15) {
						
						$this->db->select("tbl_parent_logs.parent_name, tbl_logs.log_id, tbl_follows.proposal_id, tbl_logs.log_parent_id, tbl_proposals.title, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified");
						$this->db->from("tbl_logs");
						$this->db->join("tbl_ceos","tbl_ceos.id = tbl_logs.performed_by_ceo");
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->join("tbl_follows","tbl_follows.id = tbl_logs.task_id");
						$this->db->join("tbl_proposals","tbl_proposals.id = tbl_follows.proposal_id");
						$this->db->where("tbl_logs.log_id",$log_id);
						$query = $this->db->get(); 
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					if($log_parent_id == 17) {
						$this->db->select("tbl_parent_logs.parent_name, tbl_logs.log_id, tbl_logs.log_parent_id, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_logs.performed_by_ceo as message_sender, tbl_logs.performed_to_ceo as message_receiver, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_messages.id as msgid, tbl_messages.message");
						$this->db->from("tbl_logs");
						$this->db->join("tbl_ceos","tbl_ceos.id = tbl_logs.performed_by_ceo");
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->join("tbl_messages","tbl_messages.id = tbl_logs.task_id");
						$this->db->where("tbl_logs.log_id",$log_id);
						$query = $this->db->get(); 
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
			
				endforeach; 
			
			}

			//CONNECTION UPDATES AND NOTIFICATIONS			
			if(!empty($getn) && !empty($getnotification))
			{
				$getnotification = array_merge($getnotification, $getn);
				
				$sortArray = array(); 
				
				foreach($getnotification as $person){
					foreach($person as $key=>$value){
						if(!isset($sortArray[$key])){
							$sortArray[$key] = array();
						}
						$sortArray[$key][] = $value;
					}
				}
					$orderby = "log_id"; //change this to whatever key you want from the array
					array_multisort($sortArray[$orderby],SORT_DESC,$getnotification); 
			}
			
			if(empty($getnotification) && !empty($getn))
			{
				$getnotification = $getn;
				
			}
			if(!empty($getnotification)){
				$getnotification = array_unique($getnotification, SORT_REGULAR);
				$getnotification = array_values($getnotification);
			}
					
			
			//OWN INDUSTRY RELATED PROPOSALS
			if(!empty($restproposals))
			{
				$getnotification = array_merge($getnotification, $restproposals);
				
				$sortArray = array(); 
				
				foreach($getnotification as $person){
					foreach($person as $key=>$value){
						if(!isset($sortArray[$key])){
							$sortArray[$key] = array();
						}
						$sortArray[$key][] = $value;
					}
				}
				$orderby = "log_id"; //change this to whatever key you want from the array
				array_multisort($sortArray[$orderby],SORT_DESC,$getnotification); 
			}
			/* echo "<pre>";
			print_r($getnotification);
			echo "</pre>";
			exit; */
			if(!empty($getnotification)) {
					
				define("SECONDS", 1);
				define("MINUTES", 60 * SECONDS);
				define("HOURS", 60 * MINUTES); 
				define("DAYS", 24 * HOURS);
				define("MONTHS", 30 * DAYS); 
				
				foreach($getnotification as $key => $val){
					$newlog = "";
					$delta = time() - strtotime($val['logtime']);
					//$delta = time() - strtotime($val['created_on']);
					
					if($delta < 1 * MINUTES) { 
						if($delta == 1) {
							$newlog = "one second ago";
						}
						else {
							$newlog = $delta." seconds ago"; 
						} 
					}
					else if($delta < 2 * MINUTES) { 
						$newlog = "a minute ago"; 
					} 
					else if($delta < 45 * MINUTES) { 
						$newlog = floor($delta / MINUTES)." minutes ago"; 
					}
					else if($delta < 90 * MINUTES) { 
						$newlog = "an hour ago"; 
					} 
					else if($delta < 24 * HOURS) { 
						$newlog = floor($delta / HOURS)." hours ago"; 
					}
					else if($delta < 48 * HOURS) { 
						$newlog = "yesterday"; 
					} 
					else if($delta < 30 * DAYS) { 
						$newlog = floor($delta / DAYS)." days ago"; 
					}
					else if($delta < 12 * MONTHS) { 
						$months = floor($delta / DAYS / 30); 
						if($months <= 1) {
							$newlog = "one month ago";
						} else {
							$newlog = $months." months ago"; 
						}
					}
					else { 
						$years = floor($delta / DAYS / 365); 
						if($years <= 1 ) {
							$newlog = "one year ago";
						}
						else {
							$newlog = $years." years ago"; 
						}	
					}
					$getnotification[$key]['newlogtime'] = $newlog;
				}
			}
			
			/* echo "<pre>";
			print_r($getnotification);
			echo "</pre>";
			exit;  */

			return $getnotification;
		}
		
		
//***** JQUERY FUNCTION FOR GETTING NOTIFICATION *****//
		
		public function getNotificationJqueryModel($id){
			
			$getnotification = array();
			$getlogs = array();
			$getn = array();
			$dd = array();
			
			/*******************Industry related proposal*********************/
			
			$this->db->select('tbl_businesses_industries.industry_id');
			$this->db->from('tbl_ceos');
			$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
			$this->db->join('tbl_businesses_industries', 'tbl_businesses_industries.business_id  = tbl_ceo_business_details.business_id');
			$this->db->where('tbl_ceos.id',$id);
			$this->db->where('tbl_businesses_industries.is_active',true);
			$ww = $this->db->get();
			if($ww->num_rows() > 0){
				$i=0;
				foreach($ww->result_array() as $re){
					if($i==0){
						$this->db->distinct('proposal_id');
						$this->db->select('proposal_id');
						$this->db->from('tbl_proposals_industries');
						$this->db->where(array(
												'industry_id'=>$re['industry_id'],
												'is_active'=>true
											));
						$cv = $this->db->get();
						
						if($cv->num_rows() > 0)
						{
							$dd[] = $cv->result_array();
						}
					}
					$i++;
				}
				foreach($dd as $d) {
					
					foreach($d as $c){
						
						$this->db->select('tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.is_notified, tbl_logs.is_viewed, tbl_logs.created_on as logtime, tbl_proposals.title, tbl_proposals.background_img_url as proposal_background_img, tbl_proposals.description, tbl_proposals.ceo_id as proposal_ceo, tbl_proposals.id as proposal_id, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.logo_url');
						$this->db->from('tbl_logs');
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_logs.task_id');
						$this->db->join('tbl_ceos', 'tbl_ceos.id = tbl_proposals.ceo_id');
						$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
						$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->where('tbl_logs.task_id',$c['proposal_id']);
						$this->db->where('tbl_logs.log_parent_id',5);
						$ds = $this->db->get();
						if($ds->num_rows() > 0){
							$r = $ds->result_array();
							$restproposals[] = $r[0];
						}
						
						if(!empty($restproposals)) {
							$countlunch = 0;
							$countfollows = 0;
							foreach($restproposals as $key => $r) {
								$this->db->select('id');
								$this->db->from('tbl_lunches');
								$this->db->where('proposal_id',$r['proposal_id']);
								$this->db->where('is_active',true);
								$ccs = $this->db->get();
								$countlunch = $ccs->num_rows();
								$restproposals[$key]['totallunches'] = $countlunch;
							}
							
							foreach($restproposals as $key => $r) {
								$this->db->select('id');
								$this->db->from('tbl_follows');
								$this->db->where('proposal_id',$r['proposal_id']);
								$this->db->where('is_active',true);
								$ccs = $this->db->get();
								$countfollows = $ccs->num_rows();
								$restproposals[$key]['totalfollows'] = $countfollows;
							}
						
						}
					
					}
				}
				/* echo "<pre>";
				print_r($restproposals);
				echo "</pre>";
				exit; */
			}
			
			
			/*********************************************************/
			
			
			
			
			/***************Connection Updates*********************/
			
			$this->db->where("(ceo1_id = $id OR ceo2_id = $id)", NULL, FALSE);
			$this->db->where('accepted',true);
			$this->db->where('is_active',true);
			$g = $this->db->get('tbl_connections');
			
			if($g->num_rows() > 0 ){
				foreach($g->result() as $reas) {
					if($reas->ceo1_id == $id)
					{
						$get[] = array(
										'connection'=>$reas->ceo2_id, 
										'connection_date'=>$reas->created_on
									);
					}
					else if($reas->ceo2_id == $id)
					{
						$get[] = array(
										'connection'=>$reas->ceo1_id, 
										'connection_date' =>$reas->created_on
									);
					}
				}
			}
			
			if(!empty($get))
			{
				
				for($c=0;$c<count($get);$c++)
				{
					$this->db->select('*');
					$this->db->from('tbl_logs');
					$this->db->where("(performed_by_ceo='".$get[$c]['connection']."' AND log_parent_id = 12 AND is_active=true)");
					$this->db->or_where("(performed_to_ceo='".$get[$c]['connection']."' AND log_parent_id = 14 AND is_active=true)");
					$this->db->or_where("(performed_by_ceo='".$get[$c]['connection']."' AND log_parent_id = 20 AND is_active=true)");
					$this->db->or_where("(performed_to_ceo='".$get[$c]['connection']."' AND log_parent_id = 15 AND is_active=true)");
					$this->db->or_where("(performed_to_ceo='".$get[$c]['connection']."' AND log_parent_id = 2 AND is_active=true)");
					$this->db->or_where("(performed_by_ceo='".$get[$c]['connection']."' AND log_parent_id = 2 AND is_active=true)");
					$this->db->or_where("(performed_by_ceo='".$get[$c]['connection']."' AND log_parent_id = 5 AND is_active=true)");
					$this->db->or_where("(performed_to_ceo='".$get[$c]['connection']."' AND log_parent_id = 8 AND is_active=true)");
					$f = $this->db->get();
					if($f->num_rows() > 0){
						foreach($f->result_array() as $res) {
							
							$task_id = $res['task_id'];
							$log_id = $res['log_id'];
							$logtime = $get[$c]['connection_date'];
							$currentuserid = $id;
							$log_parent_id = $res['log_parent_id'];
							$performed_by_ceo = $res['performed_by_ceo'];
							$performed_to_ceo = $res['performed_to_ceo'];
							
							//lunch request accepted query
							if($log_parent_id == 12) {
								
								$this->db->select(
												'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime, tbl_ceos.first_name as proposal_ceo_fname, tbl_ceos.last_name as proposal_ceo_lname, tbl_ceos.nickname as proposal_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as proposal_ceo_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name, c.first_name as requester_fn, c.last_name as requester_ln, c.nickname as requester_nick, c.ceo_profile_pic as requester_pic');
								$this->db->from('tbl_logs');
								$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
								$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
								$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
								$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
								$this->db->join('tbl_ceos c','c.id = tbl_logs.performed_to_ceo');
								$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_to_ceo');
								$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
								$this->db->where('tbl_logs.log_id',$log_id);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$this->db->where('tbl_logs.is_active',true);
								$query = $this->db->get();
								
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
							}
							
							//Connection Request Accepted
							if($log_parent_id == 2) {
						
								$this->db->select('tbl_ceos.id, c.first_name as current_ceo_fname, 
													c.last_name as current_ceo_lname, c.ceo_profile_pic as current_ceo_pic, 
													c.nickname as current_ceo_nickname, bd.business_id as current_user_bussiness_id, b.business_name as current_user_bussiness_name, tbl_ceos.first_name,
													tbl_parent_logs.parent_name,  tbl_ceos.last_name, tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_logs.*, tbl_logs.created_on as logtime, 
													tbl_businesses.id as business_id, tbl_businesses.business_name, 
													tbl_businesses.logo_url'
												);
								$this->db->from('tbl_ceos');
								$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id');
								$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
								$this->db->join('tbl_logs', 'tbl_logs.performed_by_ceo = tbl_ceos.id');
								$this->db->join('tbl_ceos c', 'c.id = tbl_logs.performed_to_ceo');
								$this->db->join('tbl_ceo_business_details bd', 'bd.ceo_id = c.id');
								$this->db->join('tbl_businesses b', 'b.id = bd.business_id');
								$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
								$this->db->where('tbl_ceos.id',$performed_by_ceo);
								$this->db->where('tbl_logs.performed_to_ceo',$id);
								$this->db->where('tbl_logs.log_id',$log_id);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$query = $this->db->get();
								
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								}
								
							}
							
								
							//Add Proposal Connection
							if($log_parent_id == 5) {
							
								$this->db->select('tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.is_notified, tbl_logs.is_viewed, tbl_logs.created_on as logtime, tbl_proposals.title, tbl_proposals.background_img_url as proposal_background_img, tbl_proposals.description, tbl_proposals.ceo_id as proposal_ceo, tbl_proposals.id as proposal_id, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.logo_url');
								$this->db->from('tbl_logs');
								$this->db->join('tbl_proposals','tbl_proposals.id = tbl_logs.task_id');
								$this->db->join('tbl_ceos', 'tbl_ceos.id = tbl_proposals.ceo_id');
								$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
								$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id');
								$this->db->where('tbl_logs.log_id',$log_id);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$query = $this->db->get();
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
							} 
							
							
							//proposal comment
							if($log_parent_id == 8) {
								
								$this->db->select("tbl_parent_logs.parent_name, tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_comments.proposal_id, tbl_comments.message, tbl_ceos.first_name as commenter_fname, tbl_ceos.nickname as commenter_nickname, tbl_ceos.last_name as commenter_lname, tbl_ceos.ceo_profile_pic, tbl_proposals.title, c.nickname as receiver_nickname");
								$this->db->from("tbl_logs");
								$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
								$this->db->join("tbl_comments","tbl_comments.id = tbl_logs.task_id");
								$this->db->join("tbl_proposals","tbl_proposals.id = tbl_comments.proposal_id");
								$this->db->join("tbl_ceos","tbl_ceos.id = tbl_comments.ceo_id");
								$this->db->join("tbl_ceos c","c.id = tbl_logs.performed_to_ceo");
								$this->db->where("tbl_logs.log_id",$log_id);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$query = $this->db->get(); 
								
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
							}
							
							
							//Lunch Request Accepted
							if($log_parent_id == 14) {
						
								$this->db->select(
												'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime,tbl_lunches.rate_1 as requester_rating, tbl_lunches.feedback_desc_1 as requester_feedback, tbl_lunches.rate_2 as acepter_rating, tbl_lunches.feedback_desc_2 as acepter_feedback, tbl_ceos.first_name as proposal_ceo_fname, tbl_ceos.last_name as proposal_ceo_lname, tbl_ceos.nickname as proposal_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as proposal_ceo_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name, tbl_ceos.first_name as rater_fn, tbl_ceos.last_name as rater_ln, tbl_ceos.nickname as rater_nick, tbl_ceos.ceo_profile_pic as rater_pic, c.nickname as req_nick');
								$this->db->from('tbl_logs');
								$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
								$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
								$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
								$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
								$this->db->join('tbl_ceos c','c.id = tbl_logs.performed_to_ceo');
								$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_by_ceo');
								$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
								$this->db->where('tbl_logs.log_id',$log_id);
								$this->db->where('tbl_logs.is_active',true);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$this->db->where('tbl_lunches.lunch_request_status',2);
								$query = $this->db->get();
								
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
							}
							
							//Connection profile update
							if($log_parent_id == 20) {
							
								$this->db->select('tbl_logs.log_id, tbl_parent_logs.parent_name, tbl_logs.log_parent_id, tbl_logs.created_on as logtime, tbl_ceos.id as updater_ceo_id, tbl_businesses.id as updater_business_id,tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name');
								
								$this->db->from('tbl_logs');
								$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
								$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
								$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id' );
								$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id' );
								$this->db->where('tbl_ceos.id',$performed_by_ceo);
								$this->db->where('tbl_logs.created_on >',$logtime);
								$this->db->where('tbl_logs.log_id',$log_id);
								$query = $this->db->get();
								if($query->num_rows() > 0)
								{
									$result = $query->result_array();
									$getn[] = $result[0];
								} 
							}
						
						}
					
					}
					
				}
			
			}
			
			/*****************************************************/
			$where = array(
							'tbl_logs.performed_to_ceo'=>$id,
							'tbl_logs.performed_by_ceo !='=>$id,
							'tbl_logs.log_parent_id !='=>3,
							'tbl_logs.is_active'=>true
						);
			
			$this->db->select('tbl_parent_logs.parent_name,
								tbl_parent_logs.parent_table,
								tbl_logs.log_id, 
								tbl_logs.log_parent_id, 
								tbl_logs.performed_by_ceo, 
								tbl_logs.performed_to_ceo, 
								tbl_logs.task_id, 
								tbl_logs.created_on, 
								tbl_logs.is_viewed'
							);
			$this->db->from('tbl_parent_logs');
			$this->db->join('tbl_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
			$this->db->where($where);
			//$this->db->where('tbl_logs.log_parent_id !=',5);
			$this->db->order_by('tbl_logs.log_id','desc');
			//$this->db->limit(10);
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				$getlogs[] = $result->result_array();
			}
			
			if(!empty($getlogs))
			{
				foreach( $getlogs[0] as $log ) :
				
					$task_id = $log['task_id'];
					$log_id = $log['log_id'];
					$currentuserid = $id;
					$log_parent_id = $log['log_parent_id'];
					$performed_by_ceo = $log['performed_by_ceo'];
					$performed_to_ceo = $log['performed_to_ceo'];
				 
					if($log_parent_id == 1) {
						$this->db->select('tbl_ceos.id, tbl_ceos.first_name,tbl_parent_logs.parent_name,  tbl_ceos.last_name, tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_logs.*, tbl_logs.created_on as logtime, tbl_businesses.id as business_id, tbl_businesses.business_name, tbl_businesses.logo_url');
						$this->db->from('tbl_ceos');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->join('tbl_logs', 'tbl_logs.performed_by_ceo = tbl_ceos.id');
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->where('tbl_ceos.id',$performed_by_ceo);
						$this->db->where('tbl_logs.performed_to_ceo',$id);
						$this->db->where('tbl_logs.log_id',$log_id);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						}
					}
					
					if($log_parent_id == 2) {
						
						$this->db->select('tbl_ceos.id, c.first_name as current_ceo_fname, 
											c.last_name as current_ceo_lname, c.ceo_profile_pic as current_ceo_pic, 
											c.nickname as current_ceo_nickname, bd.business_id as current_user_bussiness_id, b.business_name as current_user_bussiness_name, tbl_ceos.first_name,
											tbl_parent_logs.parent_name,  tbl_ceos.last_name, tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_logs.*, tbl_logs.created_on as logtime, 
											tbl_businesses.id as business_id, tbl_businesses.business_name, 
											tbl_businesses.logo_url'
										);
						$this->db->from('tbl_ceos');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->join('tbl_logs', 'tbl_logs.performed_by_ceo = tbl_ceos.id');
						$this->db->join('tbl_ceos c', 'c.id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_ceo_business_details bd', 'bd.ceo_id = c.id');
						$this->db->join('tbl_businesses b', 'b.id = bd.business_id');
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->where('tbl_ceos.id',$performed_by_ceo);
						$this->db->where('tbl_logs.performed_to_ceo',$id);
						$this->db->where('tbl_logs.log_id',$log_id);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						}
					}
					
				 
					if($log_parent_id == 8) {
						
						$this->db->select("tbl_parent_logs.parent_name, tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_comments.proposal_id, tbl_comments.message, tbl_ceos.first_name as commenter_fname, tbl_ceos.nickname as commenter_nickname, tbl_ceos.last_name as commenter_lname, tbl_ceos.ceo_profile_pic, tbl_proposals.title, c.nickname as receiver_nickname");
						$this->db->from("tbl_logs");
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->join("tbl_comments","tbl_comments.id = tbl_logs.task_id");
						$this->db->join("tbl_proposals","tbl_proposals.id = tbl_comments.proposal_id");
						$this->db->join("tbl_ceos","tbl_ceos.id = tbl_comments.ceo_id");
						$this->db->join("tbl_ceos c","c.id = tbl_logs.performed_to_ceo");
						$this->db->where("tbl_logs.log_id",$log_id);
						$query = $this->db->get(); 
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					
					//lunch request query
					if($log_parent_id == 11) {
						
						$this->db->select(
										'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on, 
										tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime, tbl_ceos.first_name as requester_ceo_fname, tbl_ceos.last_name as requester_ceo_lname, tbl_ceos.nickname as requester_ceo_nickname, tbl_ceos.ceo_profile_pic as requester_ceo_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as responder_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name'	);
						$this->db->from('tbl_logs');
						$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
						$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->where('tbl_logs.log_id',$log_id);
						$this->db->where('tbl_logs.is_active',true);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					//lunch request accepted query
					if($log_parent_id == 12) {
						
						$this->db->select(
										'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime, tbl_ceos.first_name as proposal_ceo_fname, tbl_ceos.last_name as proposal_ceo_lname, tbl_ceos.nickname as proposal_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as proposal_ceo_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name, c.first_name as requester_fn, c.last_name as requester_ln, c.nickname as requester_nick, c.ceo_profile_pic as requester_pic');
						$this->db->from('tbl_logs');
						$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
						$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_ceos c','c.id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->where('tbl_logs.log_id',$log_id);
						$this->db->where('tbl_logs.is_active',true);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					//lunch request declined query
					if($log_parent_id == 13) {
						
						$this->db->select(
										'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on, 
										tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime, tbl_ceos.first_name as requester_ceo_fname, tbl_ceos.last_name as requester_ceo_lname, tbl_ceos.nickname as requester_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as responder_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name'	);
						$this->db->from('tbl_logs');
						$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
						$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->where('tbl_logs.log_id',$log_id);
						$this->db->where('tbl_logs.is_active',true);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					
					if($log_parent_id == 14) {
						
						$this->db->select(
										'tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.performed_by_ceo, tbl_parent_logs.parent_name, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id,tbl_lunches.ceo1_id as requester_ceo_id, tbl_lunches.ceo2_id as responder_ceo_id, tbl_lunches.lunch_request_status, tbl_lunches.created_on as logtime,tbl_lunches.rate_1 as requester_rating, tbl_lunches.feedback_desc_1 as requester_feedback, tbl_lunches.rate_2 as acepter_rating, tbl_lunches.feedback_desc_2 as acepter_feedback, tbl_ceos.first_name as proposal_ceo_fname, tbl_ceos.last_name as proposal_ceo_lname, tbl_ceos.nickname as proposal_ceo_nickname, tbl_ceos.ceo_profile_pic, tbl_proposals.background_img_url as proposal_background, tbl_proposals.title as proposal_title, tbl_businesses.logo_url as proposal_ceo_business_logo,tbl_businesses.id as business_id, tbl_businesses.business_name, tbl_ceos.first_name as rater_fn, tbl_ceos.last_name as rater_ln, tbl_ceos.nickname as rater_nick, tbl_ceos.ceo_profile_pic as rater_pic, c.nickname as req_nick');
						$this->db->from('tbl_logs');
						$this->db->join('tbl_parent_logs','tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id');
						$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_lunches.proposal_id');
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_ceos c','c.id = tbl_logs.performed_to_ceo');
						$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_logs.performed_by_ceo');
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
						$this->db->where('tbl_logs.log_id',$log_id);
						$this->db->where('tbl_logs.is_active',true);
						$this->db->where('tbl_lunches.lunch_request_status',2);
						$query = $this->db->get();
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					
					
					if($log_parent_id == 15) {
						
						$this->db->select("tbl_parent_logs.parent_name, tbl_logs.log_id, tbl_follows.proposal_id, tbl_logs.log_parent_id, tbl_proposals.title, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified");
						$this->db->from("tbl_logs");
						$this->db->join("tbl_ceos","tbl_ceos.id = tbl_logs.performed_by_ceo");
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->join("tbl_follows","tbl_follows.id = tbl_logs.task_id");
						$this->db->join("tbl_proposals","tbl_proposals.id = tbl_follows.proposal_id");
						$this->db->where("tbl_logs.log_id",$log_id);
						$query = $this->db->get(); 
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
					if($log_parent_id == 17) {
						$this->db->select("tbl_parent_logs.parent_name, tbl_logs.log_id, tbl_logs.log_parent_id, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_logs.performed_by_ceo as message_sender, tbl_logs.performed_to_ceo as message_receiver, tbl_logs.task_id, tbl_logs.created_on as logtime, tbl_logs.is_viewed, tbl_logs.is_notified, tbl_messages.id as msgid, tbl_messages.message");
						$this->db->from("tbl_logs");
						$this->db->join("tbl_ceos","tbl_ceos.id = tbl_logs.performed_by_ceo");
						$this->db->join("tbl_parent_logs","tbl_parent_logs.parent_log_id = tbl_logs.log_parent_id");
						$this->db->join("tbl_messages","tbl_messages.id = tbl_logs.task_id");
						$this->db->where("tbl_logs.log_id",$log_id);
						$query = $this->db->get(); 
						
						if($query->num_rows() > 0)
						{
							$result = $query->result_array();
							$getnotification[] = $result[0];
						} 
					}
			
				endforeach; 
			
			}

			//CONNECTION UPDATES AND NOTIFICATIONS			
			if(!empty($getn) && !empty($getnotification))
			{
				$getnotification = array_merge($getnotification, $getn);
				
				$sortArray = array(); 
				
				foreach($getnotification as $person){
					foreach($person as $key=>$value){
						if(!isset($sortArray[$key])){
							$sortArray[$key] = array();
						}
						$sortArray[$key][] = $value;
					}
				}
					$orderby = "log_id"; //change this to whatever key you want from the array
					array_multisort($sortArray[$orderby],SORT_DESC,$getnotification); 
			}
			
			if(empty($getnotification) && !empty($getn))
			{
				$getnotification = $getn;
				
			}
			if(!empty($getnotification)){
				$getnotification = array_unique($getnotification, SORT_REGULAR);
				$getnotification = array_values($getnotification);
			}
					
			
			//OWN INDUSTRY RELATED PROPOSALS
			if(!empty($restproposals))
			{
				$getnotification = array_merge($getnotification, $restproposals);
				
				$sortArray = array(); 
				
				foreach($getnotification as $person){
					foreach($person as $key=>$value){
						if(!isset($sortArray[$key])){
							$sortArray[$key] = array();
						}
						$sortArray[$key][] = $value;
					}
				}
				$orderby = "log_id"; //change this to whatever key you want from the array
				array_multisort($sortArray[$orderby],SORT_DESC,$getnotification); 
			}
			/* echo "<pre>";
			print_r($getnotification);
			echo "</pre>";
			exit; */
			if(!empty($getnotification)){
				
				define("SECONDSS", 1);
				define("MINUTESS", 60 * SECONDSS);
				define("HOURSS", 60 * MINUTESS); 
				define("DAYSS", 24 * HOURSS);
				define("MONTHSS", 30 * DAYSS); 
				
				foreach($getnotification as $key => $val){
					
					$newlog = "";
					
					$delta = time() - strtotime($val['logtime']);
					
					if($delta < 1 * MINUTESS) { 
						if($delta == 1) {
							$newlog = "one second ago";
						}
						else {
							$newlog = $delta." seconds ago"; 
						} 
					}
					else if($delta < 2 * MINUTESS) { 
						$newlog = "a minute ago"; 
					} 
					else if($delta < 45 * MINUTESS) { 
						$newlog = floor($delta / MINUTESS)." minutes ago"; 
					}
					else if($delta < 90 * MINUTESS) { 
						$newlog = "an hour ago"; 
					} 
					else if($delta < 24 * HOURSS) { 
						$newlog = floor($delta / HOURSS)." hours ago"; 
					}
					else if($delta < 48 * HOURSS) { 
						$newlog = "yesterday"; 
					} 
					else if($delta < 30 * DAYSS) { 
						$newlog = floor($delta / DAYSS)." days ago"; 
					}
					else if($delta < 12 * MONTHSS) { 
						$months = floor($delta / DAYSS / 30); 
						if($months <= 1) {
							$newlog = "one month ago";
						} else {
							$newlog = $months." months ago"; 
						}
					}
					else { 
						$years = floor($delta / DAYSS / 365); 
						if($years <= 1 ) {
							$newlog = "one year ago";
						}
						else {
							$newlog = $years." years ago"; 
						}	
					}
					$getnotification[$key]['newlogtime'] = $newlog;
				}
			}
			
			echo json_encode($getnotification);
			/* echo "<pre>";
			print_r($getnotification);
			echo "</pre>";
			exit;
			return $getnotification; */
		}


//****************CHANGE NOTIFICATION STATUS************************//		

		public function changeStatusNotificationModel($logid){
			$this->db->where('log_id',$logid);
			$this->db->update('tbl_logs',array('is_viewed'=>FALSE, 'is_notified'=>FALSE, 'updated_on'=>$this->datetime));
		}

		
//****************CHANGE NOTIFICATION STATUS************************//			
		public function getFriendRequestsNotificationsModel($id) {
			$rewulst = "";
			/* $query = $this->db->order_by('id', 'DESC')->get_where('tbl_connections',array( 'ceo2_id' => $id, 'accepted' => 2, 'is_active' => true ));
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $q){
					//return $query->result();
					
					$this->db->select('tbl_connections.*,tbl_ceos.nickname as requester_nickname, tbl_ceos.first_name as requester_fname, tbl_ceos.last_name as requester_lname, tbl_ceos.ceo_profile_pic as requester_pic');
					$this->db->from('tbl_connections');
					$this->db->join('tbl_ceos','tbl_ceos.id = tbl_connections.ceo1_id');
					$this->db->where('tbl_connections.ceo2_id',$id);
					$queryss = $this->db->get(); 
					if($queryss->num_rows() > 0){
						$rewulst[] = $queryss->result()[0];
					}
				}
			} */
			return $rewulst;
		}
		
}
?>