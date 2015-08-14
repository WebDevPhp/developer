<?php 

	class Feed_model extends CI_Model {
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->load->database();
			$this->datetime = date("Y-m-d H:i:s"); 
        }	

	
		public function GetAllFeedProposals($ceo_id)
		{
			$ids = "";
			$re = "";
			$finalpropids = "";
			$results = "";
			$resu = "";
			$newidarr = "";
			$finalpropid = "";
			$finalpropids = "";
			$a = "";
			$this->db->select('cbd.business_id, ind.industry_id');
			$this->db->from('tbl_ceo_business_details cbd');
			$this->db->join('tbl_businesses_industries ind', 'ind.business_id = cbd.business_id' );
			$this->db->where('cbd.ceo_id', $ceo_id);
			$this->db->where('ind.is_active', true);
			$query = $this->db->get();
						
			if ($query->num_rows() > 0) 
			{ 
				$ids = $query->result();
				
				if(!empty($ids)) {
					foreach($ids as $id) {
						$re[] = $id->industry_id;
					}
				}
			
				//for getting proposals id which is related to our industry
				for($y=0; $y<count($re); $y++ )
				{
					$this->db->select('tbl_proposals_industries.proposal_id,tbl_proposals_industries.created_on,tbl_proposals_industries.industry_id');
					$this->db->from('tbl_proposals_industries');
					$this->db->where('tbl_proposals_industries.industry_id', $re[$y]);
					$this->db->where('tbl_proposals_industries.is_active', true);
					$querys = $this->db->get();
					if($querys->num_rows() > 0)
					{
						$resu[]= $querys->result();
					}
				}
				
				if(!empty($resu)){
					foreach($resu as $f){
						for($v=0; $v<count($f); $v++)
						{
							$newidarr[] = $f[$v]->proposal_id.'<br>';
						}
					}
					$finalpropid = array_unique($newidarr);
					$finalpropids = array_values($finalpropid);
				}
				if(!empty($finalpropids))
				{
					//for getting proposal details of related proposals
					for($z=0; $z<count($finalpropids); $z++)
					{
						$this->db->select('tbl_lunches.ceo1_id as lunch_requester,tbl_lunches.ceo2_id as lunch_responder, tbl_lunches.lunch_request_status, proposals.id as prop_id,proposals.created_on as prop_date, proposals.ceo_id as ceo_id, proposals.title,proposals.description as prop_desc,
						proposals.looking_for_desc,proposals.background_img_url as prop_bg_img, tbl_ceos.first_name,tbl_ceos.last_name,tbl_ceos.nickname,tbl_ceos.ceo_profile_pic,b.logo_url,b.description,b.business_name,bd.business_id');
						$this->db->from('tbl_proposals proposals');
						$this->db->join('tbl_ceos', 'tbl_ceos.id = proposals.ceo_id' );
						$this->db->join('tbl_ceo_business_details bd', 'bd.ceo_id = tbl_ceos.id' );
						$this->db->join('tbl_businesses b', 'b.id = bd.business_id' );
						$this->db->join('tbl_lunches', 'tbl_lunches.proposal_id = proposals.id','left' );
						$this->db->where('proposals.id', $finalpropids[$z]);
						$this->db->where('proposals.is_active', true);
						
						$queryss = $this->db->get();
						if($queryss->num_rows() > 0)
						{
							$a = $queryss->result();
							$results[] = $a[0];
						}
					}
				}
			}
			else { 
				$results = "";
		   	}
			return $results; 
		}
		
		
		public function getFeedLogsModel($ceo_id){
			$this->db->select('log_id,log_parent_id,performed_by_ceo,performed_to_ceo,task_id');
			$this->db->from('tbl_logs');
			$this->db->where(array('performed_to_ceo'=>$ceo_id, 'is_active'=>true));
			$this->db->order_by('log_id','desc');
			$getlogs = $this->db->get();
			if($getlogs->num_rows() > 0){
				//return $getlogs->result();
				foreach($getlogs->result() as $logs){
					
					if($logs->log_parent_id == 1)
					{
						$this->db->select('tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.task_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.created_on as logtime, tbl_comments.id as comment_id, tbl_comments.ceo_id as commentsender, tbl_comments.proposal_id as commentonproposal, message, tbl_ceos.nickname as commenter_nickname, tbl_ceos.first_name as commenter_first_name, tbl_ceos.last_name as commenter_last_name, tbl_ceos.ceo_profile_pic as commenter_pic, tbl_proposals.title, c2.nickname as receiver_nickname');	
						$this->db->from('tbl_logs');
						$this->db->join('tbl_comments','tbl_comments.id = tbl_logs.task_id' );
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo' );
						$this->db->join('tbl_ceos c2','c2.id = tbl_logs.performed_to_ceo' );
						$this->db->join('tbl_proposals','tbl_proposals.id = tbl_comments.proposal_id' );
						$this->db->where(array('tbl_comments.id'=>$logs->task_id,'tbl_logs.log_id'=>$logs->log_id));
						$query = $this->db->get();
						$r = $query->result();
						$results[] = $r[0];
					}
					 if($logs->log_parent_id == 3)
					{
						$this->db->select('tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.task_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.created_on as logtime, tbl_lunches.id as lunch_id, tbl_lunches.proposal_id as lunch_proposal_id, tbl_lunches.ceo1_id as lunch_requester,tbl_lunches.ceo2_id as lunch_responder, tbl_lunches.lunch_request_status,  tbl_ceos.nickname as requester_nickname, tbl_ceos.first_name as requester_fname, tbl_ceos.last_name as requester_lname, tbl_ceos.ceo_profile_pic as requester_pic, tbl_businesses.business_name');
						$this->db->from('tbl_logs');
						$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id' );
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo' );
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_logs.performed_by_ceo' );
						$this->db->where(array('tbl_lunches.id'=>$logs->task_id, 'tbl_lunches.is_active'=>true, 'tbl_lunches.lunch_request_status !='=>3, 'tbl_logs.log_id'=>$logs->log_id)); 
						$query = $this->db->get();
						$r = $query->result();
						$results[] = $r[0];
					}
					if($logs->log_parent_id == 5)
					{
						$this->db->select('tbl_logs.log_id, tbl_logs.log_parent_id, tbl_logs.task_id, tbl_logs.performed_by_ceo, tbl_logs.performed_to_ceo, tbl_logs.created_on as logtime, tbl_connections.id as connection_id, tbl_connections.ceo1_id as friend_requester, tbl_connections.ceo2_id as friend_responder, tbl_connections.accepted as connection_response, tbl_ceos.nickname as requester_nickname, tbl_ceos.first_name as requester_fname, tbl_ceos.last_name as requester_lname, tbl_ceos.ceo_profile_pic as requester_pic, tbl_businesses.business_name, tbl_businesses.logo_url');	
						$this->db->from('tbl_logs');
						$this->db->join('tbl_connections','tbl_connections.id = tbl_logs.task_id' );
						$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo' );
						$this->db->join('tbl_businesses','tbl_businesses.id = tbl_logs.performed_by_ceo' );
						$this->db->where(array('tbl_connections.id'=>$logs->task_id, 'tbl_connections.is_active'=>true, 'tbl_logs.log_id'=>$logs->log_id));
						$query = $this->db->get();
						$q = $query->result();
						$results[] = $q[0];
					} 
									
				}
				return $results;
			}
		}	
		
		
		public function GetProposalForSlider($ceo_id)
		{
			//DATE_GREATERTHAN; 
			$industry_proposals = "";
			$connection_proposals = "";
			$newlyadded = "";
			$follows_proposals = "";
			$restproposals = "";
			$combineall = array();
			$finalslides = "";
			$lunches = "";
			
			//CASE : 1 PROPOSALS RELATED TO INDUSTRY
			$this->db->select('tbl_businesses_industries.industry_id');
			$this->db->from('tbl_ceo_business_details');
			$this->db->join('tbl_businesses_industries', 
							'tbl_businesses_industries.business_id = tbl_ceo_business_details.business_id'
							);
			$this->db->where('tbl_ceo_business_details.ceo_id',$ceo_id);
			$this->db->where('tbl_businesses_industries.is_active',true);
			$res = $this->db->get();
			if($res->num_rows() > 0){
				$slides1 = array();
				foreach($res->result() as $rd) {
					$this->db->select('pi.proposal_id, pi.proposal_id, pi.industry_id ');
					$this->db->from('tbl_proposals_industries pi');
					$this->db->where('industry_id',$rd->industry_id);
					$this->db->where('is_active',true);
					$s = $this->db->get(); 
					if($s->num_rows() > 0){
						$slides = $s->result();
						foreach($slides as $s){
							array_push($slides1,$s);
						}
						
					}
				}
				foreach($slides1 as $k => $v) 
				{
					foreach($slides1 as $key => $value) 
					{
						if($k != $key && $v->proposal_id == $value->proposal_id)
						{
							 unset($slides1[$k]);
						}
					}
				}
				
				foreach($slides1 as $slide) {
					
					$this->db->select('p.id as proposal_id, p.title as proposal_title, p.description as description, p.ceo_id as proposal_ceo_id, p.background_img_url as proposal_bg, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.logo_url as business_logo, p.created_on as proposal_created');
					$this->db->from('tbl_proposals p');
					$this->db->join('tbl_ceos','tbl_ceos.id = p.ceo_id');
					$this->db->join('tbl_ceo_business_details bd','tbl_ceos.id = bd.ceo_id');
					$this->db->join('tbl_businesses','tbl_businesses.id = bd.business_id');
					$this->db->where('p.id',$slide->proposal_id);
					$this->db->where('p.created_on >',DATE_GREATERTHAN);
					$this->db->where('p.is_active',true);
					$c = $this->db->get();
					if($c->num_rows() > 0){
						$is = $c->result();
						$industry_proposals[] = $is[0];
					}
				}
				
			}
			
			
			// CASE : 2 PROPOSALS ADDED BY CONNECTION
			
			$this->db->where("(ceo1_id = $ceo_id OR ceo2_id = $ceo_id)", NULL, FALSE);
			$this->db->where('accepted',true);
			$this->db->where('is_active',true);
			$g = $this->db->get('tbl_connections');
			
			if($g->num_rows() > 0 ) {

				foreach($g->result() as $reas) {
					if($reas->ceo1_id == $ceo_id)
					{
						$gdet[] = array(
										'connection'=>$reas->ceo2_id, 
										'connection_date'=>$reas->created_on
									);
					}
					else if($reas->ceo2_id == $ceo_id)
					{
						$gdet[] = array(
										'connection'=>$reas->ceo1_id, 
										'connection_date' =>$reas->created_on
									);
					}
					
				}
			
				if(!empty($gdet)) {
					$connection_proposals = array();
					foreach( $gdet as $g ) {
						
						$this->db->select('p.id as proposal_id, p.title as proposal_title, p.description as description, p.ceo_id as proposal_ceo_id, p.background_img_url as proposal_bg, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.logo_url as business_logo, p.created_on as proposal_created');
						$this->db->from('tbl_proposals p');
						$this->db->join('tbl_ceos','tbl_ceos.id = p.ceo_id');
						$this->db->join('tbl_ceo_business_details bd','tbl_ceos.id = bd.ceo_id');
						$this->db->join('tbl_businesses','tbl_businesses.id = bd.business_id');
						$this->db->where('p.ceo_id',$g['connection']);
						$this->db->where('p.created_on >',DATE_GREATERTHAN);
						$this->db->where('p.is_active',true);
						$c = $this->db->get();
						if($c->num_rows() > 0){
							$cs = $c->result();
							foreach($cs as $s){
								array_push($connection_proposals,$s);
							}
						}
						
					}
					
				}
			}
			
			
			// CASE : 3 NEWLY ADDED PROPOSALS
			
			$this->db->select('p.id as proposal_id, p.title as proposal_title, p.description as description, p.ceo_id as proposal_ceo_id, p.background_img_url as proposal_bg, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.logo_url as business_logo, p.created_on as proposal_created');
			$this->db->from('tbl_proposals p');
			$this->db->join('tbl_ceos','tbl_ceos.id = p.ceo_id');
			$this->db->join('tbl_ceo_business_details bd','tbl_ceos.id = bd.ceo_id');
			$this->db->join('tbl_businesses','tbl_businesses.id = bd.business_id');
			$this->db->where('p.created_on >',DATE_GREATERTHAN);
			$this->db->where('p.is_active',true);
			$d = $this->db->get();
			if($d->num_rows() > 0){
				$newlyadded = $d->result();
			}
			
			
			// CASE : 4 FOLLOWS PROPOSALS
			
			$this->db->select('*');
			$this->db->from('tbl_follows');
			$this->db->where('tbl_follows.created_on >',DATE_GREATERTHAN);
			$this->db->where('tbl_follows.is_active',true);
			$d = $this->db->get();
			if($d->num_rows() > 0){
				$gss = $d->result();
				foreach( $gss as $g ) {
						
					$this->db->select('p.id as proposal_id, p.title as proposal_title, p.description as description, p.ceo_id as proposal_ceo_id, p.background_img_url as proposal_bg, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.logo_url as business_logo, p.created_on as proposal_created');
					$this->db->from('tbl_proposals p');
					$this->db->join('tbl_ceos','tbl_ceos.id = p.ceo_id');
					$this->db->join('tbl_ceo_business_details bd','tbl_ceos.id = bd.ceo_id');
					$this->db->join('tbl_businesses','tbl_businesses.id = bd.business_id');
					$this->db->where('p.id',$g->proposal_id);
					$this->db->where('p.created_on >',DATE_GREATERTHAN);
					$this->db->where('p.is_active',true);
					$cd = $this->db->get();
					if($cd->num_rows() > 0){
						$f = $cd->result();
						$follows_proposals[] = $f[0];
					}
						
				}
					
			}
			
			// CASE : 5 REST PROPOSALS
			
			$this->db->select('p.id as proposal_id, p.title as proposal_title, p.description as description, p.ceo_id as proposal_ceo_id, p.background_img_url as proposal_bg, tbl_ceos.nickname, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic, tbl_businesses.business_name, tbl_businesses.id as business_id, tbl_businesses.logo_url as business_logo, p.created_on as proposal_created');
			$this->db->from('tbl_proposals p');
			$this->db->join('tbl_ceos','tbl_ceos.id = p.ceo_id');
			$this->db->join('tbl_ceo_business_details bd','tbl_ceos.id = bd.ceo_id');
			$this->db->join('tbl_businesses','tbl_businesses.id = bd.business_id');
			$this->db->where('p.is_active',true);
			$ds = $this->db->get();
			if($ds->num_rows() > 0){
				$restproposals = $ds->result();
			}
			
			if(!empty($industry_proposals)) {
				array_push($combineall,$industry_proposals); 
			}
			if(!empty($connection_proposals)) {
				array_push($combineall,$connection_proposals); 
			}
			if(!empty($newlyadded)) {
				array_push($combineall,$newlyadded); 
			}
			if(!empty($follows_proposals)) {
				array_push($combineall,$follows_proposals); 
			}
			if(!empty($restproposals)) {
				array_push($combineall,$restproposals); 
			}
			if(!empty($combineall)) { 
				foreach($combineall as $subArray){
					foreach($subArray as $val){
						$finalslides[] = $val;
					}
				}
			}
			
			if(!empty($finalslides))
			{
				$arrs = array('count'=>2);
				$cdi = $finalslides;
			
			  foreach($finalslides as $key => $csm)
				 {
					// Follows proposals
					$this->db->select('tbl_follows.proposal_id');
					$this->db->from('tbl_follows');
					$this->db->where('proposal_id',$csm->proposal_id);
					$this->db->where('is_active',true);
					$a = $this->db->get();
					if($a->num_rows() > 0) {
						$gd = $a->result();
						$count = count($gd);
						$finalslides[$key]->follow = $count;
					}
					else {
						$finalslides[$key]->follow = 0;
					}
					
					// Lunch proposals
					$this->db->select('(tbl_lunches.rate_1+tbl_lunches.rate_2) as totalrate');
					$this->db->from('tbl_lunches');
					$this->db->where('proposal_id',$csm->proposal_id);
					$this->db->where('lunch_request_status',1);
					$this->db->or_where('lunch_request_status',2);
					$this->db->where('is_active',true);
					$a = $this->db->get();
					if($a->num_rows() > 0) {
						$lunches[] = $a->result();
					}
					if(!empty($lunches)){
						for($k=0; $k<count($lunches); $k++){
							$sum1 = "";
							$totallunch = count($lunches[$k]);
							for($j=0; $j<count($lunches[$k]); $j++){
								$sum1 += $lunches[$k][$j]->totalrate;
							}
							$finalslides[$key]->totalrating = $sum1;
							$finalslides[$key]->totallunch = $totallunch;
						}
					}
				}
				
			
			}
		
			return $finalslides; 
		}
		
		
		public function feedsliderfollowModel($followinfo){
		
			$response = "";
			$proposal_id = $followinfo['proposal_id'];
			$proposal_ceo_id = $followinfo['proposal_ceo_id'];
			$current_ceo_id = $followinfo['current_ceo_id'];
			
			$this->db->select('id');
			$this->db->from('tbl_follows');
			$this->db->where('ceo_id',$current_ceo_id);
			$this->db->where('proposal_id',$proposal_id);
			$this->db->where('is_active',true);
			$cc = $this->db->get();
			
			if( $cc->num_rows() > 0 ) 
			{
				$response = "This Proposal already followed!";
			}
			else {
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
					$response = "Proposal followed!";	
				}
			}
			echo $response;
		}
	}	