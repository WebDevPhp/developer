<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class common_model extends CI_Model{
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->datetime = date("Y-m-d H:i:s");
		}
		
		public function friendrequestModel($ids){
			$requester = $ids['ceo1_id'];
			$responder = $ids['ceo2_id'];
			$this->db->insert('tbl_connections',$ids);
			$lastID = $this->db->insert_id();
			$this->db->insert('tbl_logs',array(
											'log_parent_id'=>1,
											'performed_by_ceo'=>$requester,
											'performed_to_ceo'=>$responder,
											'task_id'=>$lastID,
											'created_on'=>$this->datetime,
											'is_viewed'=>true,
											'is_notified'=>true,
											'is_active'=>true
											));
		}
		
			
		public function responseLunchRequestModel($data) {
			
			
			$this->db->update('tbl_logs', array(
										'is_active'=>false, 
										'is_viewed'=>false, 
										'is_notified'=>false, 
										'deleted_on'=>$this->datetime
										), 
										array('log_id'=>$data['log_id'])
									);
										
			if($data['state'] == 0)	{
				
				$this->db->update('tbl_lunches',array(
														'lunch_request_status '=>3, 
														'updated_on'=>$this->datetime,
														'is_active'=>false
													), 
													array('id'=>$data['task_id'])
												);
												
				
											
				$this->db->insert('tbl_logs',array(
												'log_parent_id'=>13,
												'performed_by_ceo'=>$data['current_user'],
												'performed_to_ceo'=>$data['requester_id'],
												'task_id'=>$data['task_id'],
												'created_on'=>$this->datetime,
												'is_viewed'=>true,
												'is_notified'=>true,
												'is_active'=>true
											));
											
			}
			
			else if($data['state'] == 1) {
				
				$this->db->update('tbl_lunches',array(
														'lunch_request_status'=>1, 
														'updated_on'=>$this->datetime,
													), 
													array('id'=>$data['task_id'])
												);
												
				$this->db->insert('tbl_logs',array(
												'log_parent_id'=>12,
												'performed_by_ceo'=>$data['current_user'],
												'performed_to_ceo'=>$data['requester_id'],
												'task_id'=>$data['task_id'],
												'created_on'=>$this->datetime,
												'is_viewed'=>true,
												'is_notified'=>true,
												'is_active'=>true
											));
											
			}
			
			
		}
		
		
		
		public function updateFriendRequestModel($data) {
			
			
			$this->db->update('tbl_logs', array(
										'is_active'=>false, 
										'is_viewed'=>false, 
										'is_notified'=>false, 
										'deleted_on'=>$this->datetime
										), 
										array('log_id'=>$data['log_id'])
									);
										
			if($data['state'] == 0)	{
				
				$this->db->update('tbl_connections',array(
														'accepted'=>0, 
														'updated_on'=>$this->datetime,
														'is_viewed'=>false,
														'is_active'=>false
													), 
													array('id'=>$data['task_id'])
												);
												
				
											
				$this->db->insert('tbl_logs',array(
												'log_parent_id'=>3,
												'performed_by_ceo'=>$data['current_user'],
												'performed_to_ceo'=>$data['requester_id'],
												'task_id'=>$data['task_id'],
												'created_on'=>$this->datetime,
												'is_viewed'=>true,
												'is_notified'=>true,
												'is_active'=>true
											));
											
			}
			else if($data['state'] == 1) {
				
				$this->db->update('tbl_connections',array(
														'accepted'=>1, 
														'updated_on'=>$this->datetime,
													), 
													array('id'=>$data['task_id'])
												);
												
				$this->db->insert('tbl_logs',array(
												'log_parent_id'=>2,
												'performed_by_ceo'=>$data['current_user'],
												'performed_to_ceo'=>$data['requester_id'],
												'task_id'=>$data['task_id'],
												'created_on'=>$this->datetime,
												'is_viewed'=>true,
												'is_notified'=>true,
												'is_active'=>true
											));
											
			}
			
		}
		
			
		public function changeFriendNotificationStatusModel($data){
			$this->db->where('ceo2_id',$data['notification_id']);
			$this->db->update('tbl_connections',array('is_viewed'=>FALSE));
			$this->db->update('tbl_logs',array(
												'is_notified'=>false
											),
											array(
													'log_parent_id'=>1, 
													'performed_to_ceo'=>$data['notification_id']
												));
		}
		
			
		public function changeRequestsNotificationStatusModel($data){
			$this->db->where('performed_to_ceo',$data['notification_id']);
			$this->db->where('(log_parent_id=1 OR log_parent_id = 11)');
			$this->db->update('tbl_logs',array('is_notified'=>false));
		}
			
		public function changeMessageNotificationStatusModel($data){

			$this->db->where('performed_to_ceo',$data['notification_id']);
			$this->db->where('log_parent_id', 17);
			$this->db->update('tbl_logs',array('is_notified'=>false));
		}
		
		
		
		public function changeGeneralNotificationStatusModel($data){
			$this->db->where("log_parent_id !=", 1);
			$this->db->where("log_parent_id !=", 11);
			$this->db->where("log_parent_id !=", 17);
			$this->db->where('performed_to_ceo',$data['notification_id']);
			$this->db->update('tbl_logs',array('is_notified'=>FALSE, 'updated_on'=>$this->datetime));
		}
		
		public function changeNotificationReadUnreadModel($log_id){
			
			$this->db->where('log_id',$log_id);
			$this->db->update('tbl_logs',array('is_viewed'=>FALSE));
		}
		
		public function searchTopHeaderModel($keyword){
			
			$result = "";
			
			/** CASE 1 : SEARCH CEO **/
			$this->db->select('tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.id as ceo_id, tbl_ceos.ceo_profile_pic, tbl_ceo_business_details.business_id, tbl_businesses.business_name');
			$this->db->from('tbl_ceos');
			$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
			$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id');
			$this->db->where('tbl_ceos.is_active',true);
			$this->db->like('tbl_ceos.first_name',$keyword, 'after');
			$c = $this->db->get();
			$result['ceos'] = $c->result();
			
			
			/** CASE 2 : SEARCH BUSINESSES **/
			$this->db->select('tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.id as ceo_id, tbl_businesses.logo_url, tbl_ceo_business_details.business_id, tbl_businesses.business_name');
			$this->db->from('tbl_ceos');
			$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
			$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id');
			$this->db->where('tbl_businesses.is_active',true);
			$this->db->like('tbl_businesses.business_name',$keyword, 'after');
			$c = $this->db->get();
			$result['business'] = $c->result();
			
			
			/** CASE 2 : SEARCH INDUSTRIES **/
			$this->db->select('name');
			$this->db->from('tbl_industries');
			$this->db->like('tbl_industries.name',$keyword, 'after');
			$this->db->where('tbl_industries.is_active',true);
			$c = $this->db->get();
			$result['industry'] = $c->result();
			
			
			/** CASE 2 : SEARCH INDUSTRIES **/
			$this->db->select('title');
			$this->db->from('tbl_proposals');
			$this->db->like('tbl_proposals.title',$keyword, 'after');
			$this->db->where('tbl_proposals.is_active',true);
			$c = $this->db->get();
			$result['proposal'] = $c->result();
			
			echo json_encode($result);
		}
		
		
	}

?>