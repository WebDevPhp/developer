<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal_model extends CI_Model {
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->load->database();
			$this->datetime = date("Y-m-d H:i:s"); 
        }
		
		public function GetCEOInfo()
		{
			$set_data = $this->session->all_userdata();
			$ceo_array = json_decode($set_data['UserData'], true);
			$ceo_id = $ceo_array[0]['id'];
		
			/*$ceoquery = $this->db->query("Select tbl_ceos.*,tbl_businesses.*,tbl_ceo_business_details.* from tbl_ceos inner join tbl_businesses on tbl_ceos.id = tbl_businesses.id inner join tbl_ceo_business_details on tbl_businesses.id = tbl_ceo_business_details.ceo_id where tbl_ceos.id =".$ceo_id);*/
			
			$this->db->select('tbl_ceos.*,tbl_businesses.*,tbl_ceo_business_details.*');
			$this->db->from('tbl_ceos');
			$this->db->join('tbl_businesses', 'tbl_ceos.id = tbl_businesses.id', 'inner');
			$this->db->join('tbl_ceo_business_details', 'tbl_businesses.id = tbl_ceo_business_details.ceo_id', 'inner');
			$this->db->where('tbl_ceos.id', $ceo_id);
			$this->db->where('tbl_ceos.is_active', true);
			$this->db->where('tbl_businesses.is_active', true);
			$this->db->where('tbl_ceo_business_details.is_active', true);
			$ceoquery = $this->db->get();
			if ($ceoquery->num_rows() == 1) { 
				$row = $ceoquery->result_array() ;
				return $row;
			} 
			else { 
				return ''; 
			}
		}
		
		public function SaveProposal($data)
		{	
			$new_name = time().$data['upload_file']['proposal_bg']['name'];
			$config = array(
				'file_name' => $new_name,
				'upload_path' => "./uploads/proposal/",
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				'max_height' => "",
				'max_width' => ""
			);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			if($this->upload->do_upload('proposal_bg'))
			{
				$this->load->library('image_lib');
				$image = $this->upload->data();
				$proposal_bg = $image['file_name'];  
				$data['proposal_detail']['background_img_url'] = $proposal_bg;
				$configSize1['image_library'] = 'gd2';
				$configSize1['source_image'] = $image['full_path'];
				$configSize1['create_thumb'] = FALSE;
				$configSize1['maintain_ratio'] = TRUE;
				$configSize1['width'] = 1920;
				$configSize1['height'] = "";
				$configSize1['new_image']  = './uploads/proposal/';
				$this->image_lib->initialize($configSize1);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}
			
			// Inserting in Values in Multiple Table of Database(Rondas)
  			$this->db->trans_begin();
			$this->db->insert( 'tbl_proposals', $data['proposal_detail'] );
			$proposal_id = $this->db->insert_id();
			//$data['proposal_industry']['proposal_id'] = $proposal_id;
			if(!empty($data['proposal_industry']['industry_id']))
			{
				for($i=0;$i<count($data['proposal_industry']['industry_id']);$i++)
				{
					
					$proposal_industry = array(
						'proposal_id'   => $proposal_id,
						'industry_id'   => $data['proposal_industry']['industry_id'][$i],
						'created_on' 	=> 	$this->datetime,
						'updated_on' 		=> 	"",
						'deleted_on' 		=>	"",
						'is_active' 		=> 	true
					);
					$this->db->insert( 'tbl_proposals_industries', $proposal_industry );
				}
			}
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$result['res'] = "";
			}
			else
			{
				$this->db->trans_commit();
				$this->db->insert('tbl_logs',array(
												'log_parent_id'=>5,
												'performed_by_ceo'=>$data['proposal_detail']['ceo_id'],
												'task_id'=>$proposal_id,
												'created_on' => $this->datetime,
												'is_viewed' =>true,
												'is_notified' =>true,
												'is_active' =>true
											));
				$result['res'] = $proposal_id;
			}
			return $result;
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
		public function GetCEOBusinessIndustry($business_id)
		{
			//SELECT tbl_businesses_industries.`industry_id`,tbl_industries.name FROM `tbl_businesses_industries` inner join tbl_industries on tbl_businesses_industries.`industry_id` = tbl_industries.id WHERE tbl_businesses_industries.`business_id` =1 
			$this->db->select('tbl_businesses_industries.industry_id,tbl_industries.name');
			$this->db->from('tbl_businesses_industries');
			$this->db->join('tbl_industries', 'tbl_businesses_industries.industry_id = tbl_industries.id', 'inner');
			$this->db->where('tbl_businesses_industries.business_id', $business_id );
			$this->db->where('tbl_businesses_industries.is_active', true);
			$ceoquery = $this->db->get();
			if ($ceoquery->num_rows() > 0) { 
				$row = $ceoquery->result_array() ;
				return $row;
			} 
			else { 
				return ''; 
			}
			
		}
		public function GetProposalIndustry($proposal_id)
		{
			$this->db->select('tbl_proposals_industries.industry_id,tbl_proposals_industries.proposal_id,tbl_industries.name'); 
			$this->db->from('tbl_proposals_industries');
			$this->db->join('tbl_industries', 'tbl_proposals_industries.industry_id = tbl_industries.id','inner');
			$this->db->where('tbl_proposals_industries.proposal_id', $proposal_id);
			$this->db->where('tbl_proposals_industries.is_active', true);
			$prop_indus_query = $this->db->get();
			if ($prop_indus_query->num_rows() > 0) { 
				$row = $prop_indus_query->result_array() ;
				return $row;
			} 
			else { 
				return ''; 
			}
		}
		public function EditProposal($proposal_id)
		{
			$countfollow = "";
			$lunchwith = "";
			$this->db->select('id');
			$this->db->from('tbl_follows');
			$this->db->where('proposal_id',$proposal_id);
			$this->db->where('is_active',true);
			$d = $this->db->get();
			$proposal_Data['countfollow'] = $d->num_rows();
			
			
			$this->db->select('p.ceo_id, tbl_lunches.ceo1_id, tbl_lunches.ceo2_id, tbl_ceos.first_name as ceo1_firstname, c.first_name as ceo2_firstname,  tbl_ceos.last_name as ceo1_lastname, c.last_name as ceo2_lastname, tbl_businesses.business_name as ceo1_businessname, b.business_name as ceo2_businessname ');
			$this->db->from('tbl_proposals p');
			$this->db->join('tbl_lunches','tbl_lunches.ceo1_id = p.ceo_id OR tbl_lunches.ceo2_id = p.ceo_id');
			$this->db->join('tbl_ceos','tbl_ceos.id = tbl_lunches.ceo1_id');
			$this->db->join('tbl_ceos c','c.id = tbl_lunches.ceo2_id');
			$this->db->join('tbl_businesses','tbl_businesses.id = tbl_lunches.ceo1_id');
			$this->db->join('tbl_businesses b','b.id = tbl_lunches.ceo2_id');
			$this->db->where('p.id',$proposal_id);
			$this->db->where('tbl_lunches.lunch_request_status',1);
			$this->db->or_where('tbl_lunches.lunch_request_status',2);
			$ct = $this->db->get();
			$tss = $ct->result_array();
			if(!empty($tss)){
				$ceoinfor = "";
				foreach($tss as $t){
					$ceo_prop = $t['ceo_id'];
					if($t['ceo1_id'] != $ceo_prop){
						$ceoinfor['name'][] = $t['ceo1_firstname'] .' '. $t['ceo1_lastname'];
						$ceoinfor['business'][] = $t['ceo1_businessname'];
					}
					else if($t['ceo2_id'] != $ceo_prop)
					{
						$ceoinfor['name'][] = $t['ceo2_firstname'] .' '. $t['ceo2_lastname'];
						$ceoinfor['business'][] = $t['ceo2_businessname'];
					}
				}
				$proposal_Data['lunchwith'] = $ceoinfor;
			}
			//$proposal_Data['lunchwith'] = $ct->result_array();
			
			$get_results = $this->db->get_where('tbl_proposals', array('id'=>$proposal_id, 'is_active'=>true));
			
			foreach($get_results->result_array() as $row)
					{
						$set_data = $this->session->all_userdata();
						$ceo_array = json_decode($set_data['UserData'], true);
						$currentceo = $ceo_array[0]['id'];
						$proposal_Data['proposal_id'] = $row['id'];
						$proposal_Data['ceo_id'] = $row['ceo_id'];
						$proposal_Data['title'] = $row['title'];
						$proposal_Data['description'] = $row['description'];
						$proposal_Data['looking_for_desc'] = $row['looking_for_desc'];
						$proposal_Data['background_img_url'] = $row['background_img_url'];
						$get_indus = $this->db->get_where('tbl_proposals_industries', array('proposal_id'=>$proposal_Data['proposal_id'], 'is_active'=>true));
						foreach($get_indus->result_array() as $ind):
							$proposal_Data['industries'][] = $ind['industry_id'];
						endforeach;
						
						$proposalstatus = $this->db->get_where('tbl_lunches',array(
																'proposal_id'=>$proposal_Data['proposal_id'], 
																'ceo1_id'=>$currentceo, 
																'ceo2_id'=>$proposal_Data['ceo_id'],
																'is_active'=>true
																)
											);
						if($proposalstatus->num_rows() > 0) {
							
							$proposal_Data['proposalstatus'] = $proposalstatus->result_array();
							
						}
					}
					
				$this->db->select('tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.linkedin_url, tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.logo_url, tbl_businesses.description as busdesc,');
				$this->db->from('tbl_ceo_business_details');
				$this->db->join('tbl_ceos', 'tbl_ceos.id = tbl_ceo_business_details.ceo_id','inner');
				$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id','inner');
				$this->db->where('tbl_ceos.id', $proposal_Data['ceo_id']);
				$this->db->where('tbl_ceos.is_active', true);
				$get1 = $this->db->get();
				//$get1 = $this->db->get_where('tbl_ceos', array('id'=>$proposal_Data['ceo_id'], 'is_active'=>true));
				if($get1->num_rows() > 0)
				{
					$getceo = $get1->result_array();
					
					$countlunch = 0;
					$countfollows = 0;
					
					//Lunch count
					$this->db->select('id');
					$this->db->from('tbl_lunches');
					$this->db->where('proposal_id',$proposal_id);
					$this->db->where('is_active',true);
					$this->db->where('lunch_request_status',1);
					$this->db->or_where('lunch_request_status',2);
					$ccs = $this->db->get();
					$countlunch = $ccs->num_rows();
					$getceo[0]['totallunches'] = $countlunch;

					//Follows count
					$this->db->select('id');
					$this->db->from('tbl_follows');
					$this->db->where('proposal_id',$proposal_id);
					$this->db->where('is_active',true);
					$ccs = $this->db->get();
					$countfollows = $ccs->num_rows();
					$getceo[0]['totalfollows'] = $countfollows;
										
					$proposal_Data['first_name'] 		= 	$getceo[0]['first_name'];
					$proposal_Data['last_name'] 		= 	$getceo[0]['last_name'];
					$proposal_Data['nickname'] 			= 	$getceo[0]['nickname'];
					$proposal_Data['ceo_profile_pic'] 	= 	$getceo[0]['ceo_profile_pic'];
					$proposal_Data['business_name'] 	= 	$getceo[0]['business_name'];
					$proposal_Data['logo_url'] 			=	$getceo[0]['logo_url'];
					$proposal_Data['busdesc'] 			= 	$getceo[0]['busdesc'];
					$proposal_Data['linkedin_url'] 		= 	$getceo[0]['linkedin_url'];
					$proposal_Data['totallunches'] 		= 	$getceo[0]['totallunches'];
					$proposal_Data['totalfollows'] 		= 	$getceo[0]['totalfollows'];
					
				}
				
				$this->db->select('tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.nickname, tbl_ceos.id as commenter_id, tbl_ceo_business_details.business_id, tbl_ceos.ceo_profile_pic, tbl_comments.message, tbl_comments.created_on');
				$this->db->from('tbl_comments');
				$this->db->join('tbl_ceos','tbl_ceos.id = tbl_comments.ceo_id');
				$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id');
				$this->db->where('tbl_comments.is_active',true);
				$this->db->where('tbl_comments.proposal_id',$proposal_id);
				$this->db->order_by("tbl_comments.id", "asc"); 
				$comments = $this->db->get();
				if($comments->num_rows() > 0 )
				{
					$proposal_Data['comments'] = $comments->result_array();
				}
				
				$this->db->select('tbl_logs.*, tbl_follows.*');
				$this->db->from('tbl_follows');
				$this->db->join('tbl_logs','tbl_logs.task_id = tbl_follows.id');
				$this->db->where(array(
										'tbl_logs.log_parent_id'=>15,
										'tbl_follows.ceo_id'=>$currentceo, 
										'tbl_follows.proposal_id'=>$proposal_id, 
										'tbl_follows.is_active'=>true, 
										'tbl_logs.is_active'=>true 
									));
				$checkLogprop = $this->db->get();
				if($checkLogprop->num_rows() > 0){
					$proposal_Data['checkLogprop'] = $checkLogprop->result_array();
				}
				return  $proposal_Data;
		}
		
		
		
		public function UpdateProposal($data)
		{
			$proposal_id = $data['proposal_industry']['proposal_id'];
			
			if(!empty($data['upload_file']['proposal_bg']['name'])){
			$new_name = time().$data['upload_file']['proposal_bg']['name'];
			
			$config = array(
				'file_name' => $new_name,
				'upload_path' => "./uploads/proposal/",
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				'overwrite' => TRUE,
				'max_size' => "2048000", 
				'max_height' => "",
				'max_width' => ""
			);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			if($this->upload->do_upload('proposal_bg'))
			{
				$this->load->library('image_lib');
				$image = $this->upload->data();
				$proposal_bg = $image['file_name'];  
				$data['proposal_detail']['background_img_url'] = $proposal_bg;
				$configSize1['image_library'] = 'gd2';
				$configSize1['source_image'] = $image['full_path'];
				$configSize1['create_thumb'] = FALSE;
				$configSize1['maintain_ratio'] = TRUE;
				$configSize1['width'] = 1920;
				$configSize1['height'] = "";
				$configSize1['new_image']  = './uploads/proposal/';
				$this->image_lib->initialize($configSize1);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}
			
			//$data['proposal_detail']['background_img_url'] = $proposal_bg;
			$proposaldata = array(
							'title' => $data["proposal_detail"]["title"],
							'description' => htmlentities($data["proposal_detail"]["description"], ENT_QUOTES),
							'looking_for_desc' => htmlentities($data["proposal_detail"]["looking_for_desc"], ENT_QUOTES),
							'background_img_url' => $proposal_bg,
							'updated_on' => $data["proposal_detail"]["updated_on"],
							'is_active' => $data["proposal_detail"]["is_active"]
						);
			}
			else
			{
				$proposaldata = array(
							'title' => $data["proposal_detail"]["title"],
							'description' => htmlentities($data["proposal_detail"]["description"], ENT_QUOTES),
							'looking_for_desc' => htmlentities($data["proposal_detail"]["looking_for_desc"], ENT_QUOTES),
							'updated_on' => $data["proposal_detail"]["updated_on"],
							'is_active' => $data["proposal_detail"]["is_active"]
						);
			}
			
			
			// Inserting in Values in Multiple Table of Database(Rondas)
  			$this->db->trans_begin();
			
			$this->db->update( 'tbl_proposals', $proposaldata, array('tbl_proposals.id' => $proposal_id) );
			
			$this->db->select("id");
			$this->db->from('tbl_proposals_industries');
			$this->db->where('proposal_id', $proposal_id );
			$proposalidquery = $this->db->get();
			$i=0;
			foreach($proposalidquery->result_array() as $row)
			{
				$this->db->update( 'tbl_proposals_industries', array('is_active' => FALSE, 'deleted_on' => $this->datetime), array('id' => $row['id']) );
				$i++;
			}
			for($i=0;$i<count($data['proposal_industry']['industry_id']);$i++)
			{
				$proposal_industry = array(
					'proposal_id'   => $proposal_id,
					'industry_id'   => $data['proposal_industry']['industry_id'][$i],
					'created_on' 		=> $this->datetime,
					'updated_on' 		=> 	"",
					'deleted_on' 		=>	"",
					'is_active' 		=> true
				);
				$this->db->insert( 'tbl_proposals_industries', $proposal_industry );
			}
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				return '';
			}
			else
			{
				$this->db->trans_commit();
				$this->db->insert('tbl_logs',array(
								'log_parent_id'=>6,
								'performed_by_ceo'=>$data['proposal_detail']['ceo_id'],
								'task_id'=>$proposal_id,
								'created_on' => $this->datetime,
								'is_viewed' =>true,
								'is_notified' =>true,
								'is_active' =>true
							));

				return $proposal_id;
			}
			
		}
		public function getIndustries()
		{
			$get_indus = $this->db->get_where('tbl_industries', array('is_active'=>true));
			return $get_indus->result_array();
		}
		
		
		public function addCommentModel($commentdata){
			
			$data['comment'] = array(
						'ceo_id' => $commentdata['comment_writer_id'], 
						'proposal_id' => $commentdata['comment_proposal_id'], 
						'message' => $commentdata['comment_msg'], 
						'created_on' => $this->datetime, 
						'is_active' => true 
						);
			$this->db->insert('tbl_comments',$data['comment']);
			$last_comment_id = $this->db->insert_id();
			
			if($this->db->affected_rows()) {
				
				$data['logs'] = array(
									'log_parent_id'=> 8,
									'performed_by_ceo'=>$commentdata['comment_writer_id'], 
									'performed_to_ceo'=>$commentdata['comment_receiver_id'], 
									'task_id'=>$last_comment_id, 
									'created_on'=> $this->datetime, 
									'is_viewed'=> true, 
									'is_notified'=> true, 
									'is_active' => true 
								);
				$this->db->insert('tbl_logs',$data['logs']);
			
				$this->db->select('tbl_ceos.first_name, tbl_ceos.id as commenter_id, tbl_ceo_business_details.business_id, tbl_ceos.last_name, tbl_ceos.nickname, tbl_ceos.ceo_profile_pic, tbl_comments.message, tbl_comments.created_on');
				$this->db->from('tbl_comments');
				$this->db->join('tbl_ceos','tbl_ceos.id = tbl_comments.ceo_id');
				$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id');
				$this->db->where('tbl_comments.is_active',true);
				$this->db->where('tbl_comments.id',$last_comment_id);
				$comments = $this->db->get();
				if($comments->num_rows() > 0 )
				{
					$lastcomment['comments'] = $comments->result_array();
				}
			}
			
			return $lastcomment['comments'];
			
		}
		
		public function lunchRequestModel($data){
			$reulst['count'] = "";
			$reulst['message'] = "";
			$proposal_id = $data['proposal_id'];
			$proposal_ceo_id = $data['proposal_ceo_id'];
			$current_ceo_id = $data['current_ceo_id'];
			
			//Check the lunch request already sent
			$this->db->select('id');
			$this->db->from('tbl_lunches');
			$this->db->where('is_active',true);
			$this->db->where('proposal_id',$proposal_id);
			$this->db->where('lunch_request_status',0);
			$this->db->where("( ceo1_id = $current_ceo_id AND ceo2_id = $proposal_ceo_id )");
			$res = $this->db->get();
			if($res->num_rows() > 0)
			{
				$reulst['count'] = 1;
				$reulst['message'] = "You have already sent lunch request!";
			}
			
			//Check the lunch request already sent
			$this->db->select('id');
			$this->db->from('tbl_lunches');
			$this->db->where('is_active',true);
			$this->db->where('proposal_id',$proposal_id);
			$this->db->where('lunch_request_status',1);
			$this->db->where("( ceo1_id = $current_ceo_id AND ceo2_id = $proposal_ceo_id )");
			$res = $this->db->get();
			if($res->num_rows() > 0)
			{
				$reulst['count'] = 1;
				$reulst['message'] = "You got already approved lunch on this proposal!";
			}
			
			
			
			//Check the lunch request already sent
			$this->db->select('id');
			$this->db->from('tbl_lunches');
			$this->db->where('is_active',true);
			$this->db->where('proposal_id',$proposal_id);
			$this->db->where('lunch_request_status',2);
			$this->db->where("( ceo1_id = $current_ceo_id AND ceo2_id = $proposal_ceo_id )");
			$res = $this->db->get();
			if($res->num_rows() > 0)
			{
				$reulst['count'] = 1;
				$reulst['message'] = "You got already lunched on this proposal!";
			}
			
			if($reulst['count'] == "")
			{
				$propdata = array(
								'proposal_id'=>$proposal_id,
								'ceo1_id'=>$current_ceo_id,
								'ceo2_id'=>$proposal_ceo_id,
								'lunch_request_status'=>0,
								'created_on'=>$this->datetime,
								'is_active'=>true,
							);
				
				$this->db->insert('tbl_lunches',$propdata);
				
				if($this->db->affected_rows() > 0){
					
					$lastid = $this->db->insert_id();
					
					$logrecord = array(
									'log_parent_id'=>11,
									'performed_by_ceo'=>$current_ceo_id,
									'performed_to_ceo'=>$proposal_ceo_id,
									'task_id'=>$lastid,
									'created_on'=>$this->datetime,
									'is_viewed'=>true,
									'is_notified'=>true,
									'is_active'=>true,
								);
					$this->db->insert('tbl_logs',$logrecord);
					
					$reulst['message'] = "Lunch Request Have Sent!";
					
				}
			}
			echo $reulst['message'];
			
		}
	
		public function followProposalModel($data){
			
			$proposal_id = $data['proposal_id'];
			$proposal_ceo_id = $data['proposal_ceo_id'];
			$current_ceo_id = $data['current_ceo_id'];
			
			$propdata = array(
							'ceo_id'=>$current_ceo_id,
							'proposal_id'=>$proposal_id,
							'date_started_follow'=>$this->datetime,
							'created_on'=>$this->datetime,
							'is_active'=>true,
						);
			
			$this->db->insert('tbl_follows',$propdata);
			
			if($this->db->affected_rows() > 0){
				
				$lastid = $this->db->insert_id();
				
				$logrecord = array(
								'log_parent_id'=>15,
								'performed_by_ceo'=>$current_ceo_id,
								'performed_to_ceo'=>$proposal_ceo_id,
								'task_id'=>$lastid,
								'created_on'=>$this->datetime,
								'is_viewed'=>true,
								'is_notified'=>true,
								'is_active'=>true,
							);
				$this->db->insert('tbl_logs',$logrecord);
				
			}
		
		}
		
		public function unfollowProposalModel($data){
			
			$proposal_id = $data['proposal_id'];
			$proposal_ceo_id = $data['proposal_ceo_id'];
			$current_ceo_id = $data['current_ceo_id'];
			$follow_id = $data['follow_id'];
			$log_id = $data['log_id'];
			
			$logrecord = array(
								'log_parent_id'=>16,
								'performed_by_ceo'=>$current_ceo_id,
								'performed_to_ceo'=>$proposal_ceo_id,
								'task_id'=>$follow_id,
								'created_on'=>$this->datetime,
								'is_viewed'=>true,
								'is_notified'=>true,
								'is_active'=>true,
							);
			
			$this->db->update('tbl_logs',array(
												'is_viewed'=>false, 
												'is_notified'=>false, 
												'is_active'=>false, 
												'deleted_on'=>$this->datetime
											),
										array(
												'log_id'=>$log_id, 
												'performed_by_ceo'=>$current_ceo_id,
												'performed_to_ceo'=>$proposal_ceo_id, 
												'task_id'=>$follow_id 
											)); 
			
			$this->db->update('tbl_follows',array(
													'is_active'=>false, 
													'deleted_on'=>$this->datetime
												),
												array(
													'id'=>$follow_id, 
													'ceo_id'=>$current_ceo_id,
													'proposal_id'=>$proposal_id 
												));
			$this->db->insert('tbl_logs',array($logrecord));
			
		}
		
		public function getLunchesonProposal($propid){
			$this->db->select('tbl_lunches.ceo1_id as raterid, tbl_lunches.rate_1 as rating, tbl_lunches.feedback_desc_1 as feedback, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_businesses.business_name, tbl_ceos.ceo_profile_pic');
			$this->db->from('tbl_lunches');
			$this->db->join('tbl_ceos','tbl_ceos.id = tbl_lunches.ceo1_id');
			$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_ceos.id');
			$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
			$this->db->where('tbl_lunches.proposal_id',$propid);
			$this->db->where('tbl_lunches.lunch_request_status',2);
			$this->db->where('tbl_lunches.is_active',true);
			$res = $this->db->get();
			return $res->result();
		}
		
		public function getPopupLunchInfoModel($proid){
			$this->db->select('c.first_name, c.last_name');
			$this->db->from('tbl_proposals p');
			$this->db->join('tbl_lunches lc', 'lc.proposal_id = p.id');
			$this->db->join('tbl_ceos c', 'c.id = lc.ceo1_id');
			$this->db->where('p.id',$proid);
			$this->db->where('lc.lunch_request_status',1);
			$this->db->or_where('lc.lunch_request_status',2);
			$p = $this->db->get();
			echo json_encode($p->result());
		}
	
		public function getPopupFollowInfoModel($proid){
			$this->db->select('c.first_name, c.last_name');
			$this->db->from('tbl_follows f');
			$this->db->join('tbl_ceos c', 'c.id = f.ceo_id');
			$this->db->where('f.proposal_id',$proid);
			$this->db->where('f.is_active',true);
			$p = $this->db->get();
			echo json_encode($p->result());
		}
	
	}
	
?>