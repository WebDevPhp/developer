<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class advance_search_model extends CI_Model {
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->load->database();
			$this->datetime = date("Y-m-d H:i:s"); 
        }
		
		
		public function AdvanceSearchModel($data){
			$ceo 	= 	$data['ceo_id'];
			$search = 	$data['search'];
			$results = array(
								"all"=>"",
								"ceos"=>"",
								"proposals"=>"",
								"businesses"=>"",
								"industries"=>"",
							);
			switch($search){
				
				case 'ceos' :
					$this->db->select('tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.logo_url,tbl_ceos.id as ceoid, tbl_businesses.business_name, tbl_businesses.id as businessid, tbl_businesses.description');
					$this->db->from('tbl_ceos');
					$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
					$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id');
					$this->db->where('tbl_ceos.is_active',true);
					$c = $this->db->get();
					$results['ceos'] = $c->result();
					break;
				
				case 'proposals' :
					$this->db->select('tbl_proposals.id as proposal_id, tbl_proposals.title, tbl_proposals.description, tbl_proposals.background_img_url, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.logo_url');
					$this->db->from('tbl_proposals');
					$this->db->join('tbl_ceos','tbl_ceos.id = tbl_proposals.ceo_id');
					$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id');
					$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id');
					$this->db->where('tbl_proposals.is_active',true);
					$c = $this->db->get();
					$results['proposals'] = $c->result();
					break;
				
				case 'businesses' :
					$this->db->select('tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.description, tbl_businesses.logo_url');
					$this->db->from('tbl_businesses');
					$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.business_id = tbl_businesses.id');
					$this->db->join('tbl_ceos','tbl_ceos.id = tbl_ceo_business_details.ceo_id');
					$this->db->where('tbl_businesses.is_active',true);
					$c = $this->db->get();
					$results['businesses'] = $c->result();
					break;
				
				
				case 'industries' :
					$this->db->select('name');
					$this->db->from('tbl_industries');
					$this->db->where('tbl_industries.is_active',true);
					$c = $this->db->get();
					$results['industries'] = $c->result();
					break;
				
			}
			
			echo json_encode($results);
			
		}
		
	
	}
	
?>