<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lunch_experience_model extends CI_Model {
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->datetime = date("Y-m-d H:i:s"); 	
        }
		
		public function getLunchInfoModel($data) {
			
			$this->db->select('tbl_lunches.*, tbl_ceos.id as requester_ceo_id, c.id as acepter_ceo_id, c.nickname as acepter_nickname, tbl_ceos.nickname as requester_nickname, tbl_ceos.ceo_profile_pic as requester_pic, c.ceo_profile_pic as acepter_pic, tbl_ceos.nickname as requester_nickname,tbl_businesses.business_name,tbl_businesses.business_name as requester_business_name, b.business_name as acepter_business_name');
			$this->db->from('tbl_lunches');
			$this->db->join('tbl_ceos','tbl_ceos.id = tbl_lunches.ceo1_id');
			$this->db->join('tbl_ceo_business_details','tbl_ceo_business_details.ceo_id = tbl_lunches.ceo1_id');
			$this->db->join('tbl_businesses','tbl_businesses.id = tbl_ceo_business_details.business_id');
			$this->db->join('tbl_ceos c','c.id = tbl_lunches.ceo2_id');
			$this->db->join('tbl_ceo_business_details bd','bd.ceo_id = tbl_lunches.ceo2_id');
			$this->db->join('tbl_businesses b','b.id = bd.business_id');
			$this->db->where('tbl_lunches.id',$data['lunchinfo']['lunchid']);
			$reusu = $this->db->get();
			if($reusu->num_rows() > 0)
			{
				return $reusu->result();
			}
			
		}
		
		public function lunchRatingUpdate($data){
			
			$rating1 = "";
			$rating2 = "";
			$rating_text1 = "";
			$rating_text2 = "";
			
			if($data['requester'] == $data['performed_by'] && $data['accepter'] == $data['performed_to'])
			{
				$rating1 = $data['rating'];
				$rating_text1 = $data['rating_text'];
			} 
			else if($data['requester'] == $data['performed_to'] && $data['accepter'] == $data['performed_by']) 
			{
				$rating2 = $data['rating'];
				$rating_text2 = $data['rating_text'];
			}
			$this->db->update('tbl_logs', array('is_active'=>false,'is_viewed'=>false,'is_notified'=>false)
										, array('log_id'=>$data['log_id']));
			
			if(!empty($rating1) && empty($rating2))
			{
				$this->db->update('tbl_lunches', array('rate_1'=>$rating1, 'feedback_desc_1'=>$rating_text1, 'lunch_request_status'=>2,'updated_on'=>$this->datetime)
										, array('id'=>$data['lunchid']));
			}
			else if(!empty($rating2) && empty($rating1)){
				$this->db->update('tbl_lunches', array('rate_2'=>$rating2, 'feedback_desc_2'=>$rating_text2,'updated_on'=>$this->datetime)
										, array('id'=>$data['lunchid']));
			}
			$this->db->insert('tbl_logs', array(
												'log_parent_id'=>14,
												'performed_by_ceo'=>$data['performed_by'],
												'performed_to_ceo'=>$data['performed_to'],
												'task_id'=>$data['lunchid'],
												'created_on'=>$this->datetime,
												'is_viewed'=>true,
												'is_notified'=>true,
												'is_active'=>true
											));
			
			return true;
		}
		
	}
?>