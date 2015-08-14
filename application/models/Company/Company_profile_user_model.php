<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class company_profile_user_model extends CI_Model{
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->datetime = date("Y-m-d H:i:s");
		}
		
		public function getOtherUserInfo($cc){
			// bi for tbl_businesses_industries
			// ind for tbl_industries
			$data = "";
			$this->db->select('tbl_ceos.*,tbl_businesses.*,tbl_ceos.id as ceoid, tbl_businesses.id as businessid');
			$this->db->from('tbl_ceos');
			$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
			$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id');
			$this->db->where('tbl_ceos.id', $cc['ceoid']);
			$qu = $this->db->get();
			if($qu->num_rows() > 0)
			{
				$data['personal'] = $qu->result_array();
			}
			$query = $this->db->get_where('tbl_proposals',array('ceo_id' => $cc['ceoid'], 'is_active' => true));
			if($query->num_rows() > 0)
			{
				$data['propdetails'] = $query->result_array();
			}
			$this->db->select('bi.*,ind.name');
			$this->db->from('tbl_businesses_industries bi');
			$this->db->join('tbl_industries ind', 'bi.industry_id = ind.id');
			$this->db->where('bi.business_id', $cc['businessid']);
			$this->db->where('bi.is_active', true);
			$querys = $this->db->get();
			if($querys->num_rows() > 0)
			{
				$data['businessdetails'] = $querys->result_array();
			}
			return $data;
		}
		
		public function getFriendRequestsModel($que){
			$userdata = json_decode($this->session->userdata('UserData'),true);
			$requesterid = $userdata[0]['id'];
			$receiverid = $que['ceoid'];
			$result = "";
			$q = $this->db->get_where('tbl_connections',array('ceo1_id'=>$requesterid,'ceo2_id'=>$receiverid, 'is_active'=>true  ));
			if($q->num_rows() > 0 ){
				$result = $q->result();
			}
			else{
				$q = $this->db->get_where('tbl_connections',array('ceo1_id'=>$receiverid, 'ceo2_id'=>$requesterid, 'is_active'=>true ));
				$result = $q->result();
			}
			return $result;
		}
		
	}

?>