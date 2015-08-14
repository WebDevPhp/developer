<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class company_profile_model extends CI_Model{
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->datetime = date("Y-m-d H:i:s");
			
        }
		
		public function getIndustriesCeo(){
			
			// bi for tbl_businesses_industries
			// ind for tbl_industries
			$data['userdata'] = json_decode($this->session->userdata('UserData'),true);
			$business_id = $data['userdata'][0]['ceo_business_id'];
			$this->db->select('bi.*,ind.name');
			$this->db->from('tbl_businesses_industries bi');
			$this->db->join('tbl_industries ind', 'bi.industry_id = ind.id');
			$this->db->where('bi.business_id', $business_id);
			$this->db->where('bi.is_active', true);
			$query = $this->db->get();
			return $query->result();
			
		}
		
		public function getProposalCeo(){
			$data['userdata'] = json_decode($this->session->userdata('UserData'),true);
			$ceo_id = $data['userdata'][0]['id'];
			$query = $this->db->get_where('tbl_proposals',array('ceo_id' => $ceo_id, 'is_active' => true));
			return $query->result();
		}
		
	}

?>