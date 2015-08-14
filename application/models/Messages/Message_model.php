<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class message_model extends CI_Model {
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->datetime = date("Y-m-d H:i:s"); 	
        }

		public function getConnectionsModel($id){
			
			$connid = "";
			$connection = "";
			$inc = "";
			
			$this->db->select('tbl_messages.id as messageid, tbl_messages.created_on as message_logtime, tbl_messages.message, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.id as msg_ceos_id, tbl_ceos.ceo_profile_pic, tbl_businesses.id as business_id, tbl_businesses.business_name');
			$this->db->from('tbl_messages');
			$this->db->join('tbl_ceos', 'tbl_ceos.id = tbl_messages.ceo2_id AND tbl_messages.ceo2_id != "'.$id.'" OR tbl_ceos.id = tbl_messages.ceo1_id AND tbl_messages.ceo1_id != "'.$id.'" ', 'left');
			$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id', 'left');
			$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id', 'left');
			$this->db->where("(tbl_messages.ceo1_id = '".$id."' OR tbl_messages.ceo2_id = '".$id."' )");
			$this->db->order_by('tbl_messages.id','asc');
			$resultss = $this->db->get();
			if($resultss->num_rows() > 0)
			{
				foreach($resultss->result() as $key => $val){
					
					$connection[$val->msg_ceos_id] = $val;
				} 
				
				$sortArray = array(); 
				
				foreach($connection as $person){
					foreach($person as $key=>$value){
						if(!isset($sortArray[$key])){
							$sortArray[$key] = array();
						}
						$sortArray[$key][] = $value;
					}
				}
				$orderby = "messageid"; //change this to whatever key you want from the array
				array_multisort($sortArray[$orderby],SORT_DESC,$connection); 
				
			}
			
			return $connection; 
		
		}
		
		public function getmessageslistModel($data){
			
			$this->db->select('tbl_messages.id as msgid, tbl_messages.message, tbl_messages.ceo1_id as writer,tbl_messages.ceo2_id as receiver, tbl_messages.created_on as msglogtime, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.ceo_profile_pic ');
			$this->db->from('tbl_messages');
			$this->db->join('tbl_ceos','tbl_ceos.id = tbl_messages.ceo1_id');
			$this->db->where("(tbl_messages.ceo1_id = '".$data['sender_ceo']."' AND tbl_messages.ceo2_id='".$data['currrent_ceo']."')");
			$this->db->or_where("(tbl_messages.ceo1_id = '".$data['currrent_ceo']."' AND tbl_messages.ceo2_id='".$data['sender_ceo']."')");
			$c = $this->db->get();
			return $c->result();
		}
		
		
		
		public function MessageSaveModel($data){
			
			$current_ceo_id 	= 	$data['current_ceo_id'];
			$receiver_ceo_id 	= 	$data['receiver_ceo_id'];
			$add_msg 			= 	$data['add_msg'];
			$msgs = "";
			
			$this->db->insert('tbl_messages', array(
													'ceo1_id' => $current_ceo_id,
													'ceo2_id' => $receiver_ceo_id,
													'message' => $add_msg,
													'created_on' => $this->datetime,
													'is_active' => true
												));
			$lastmsgid = $this->db->insert_id();
			
			$this->db->insert('tbl_logs', array(
												'log_parent_id' 	=> 	17,
												'performed_by_ceo' 	=> 	$current_ceo_id,
												'performed_to_ceo'	=> 	$receiver_ceo_id,
												'task_id' 			=> 	$lastmsgid,
												'created_on' 		=> 	$this->datetime,
												'is_viewed' 		=> 	true,
												'is_notified' 		=> 	true,
												'is_active' 		=> 	true
											));
											
			$this->db->select(
							'tbl_messages.id as message_id,
							tbl_messages.ceo1_id as writer_ceo_id,
							tbl_messages.ceo2_id as receiver_ceo_id,
							tbl_messages.message as message, 
							tbl_messages.created_on as message_logtime,
							tbl_ceos.first_name as writer_ceo_fname,
							tbl_ceos.last_name as writer_ceo_lname,
							tbl_ceos.ceo_profile_pic as writer_ceo_pic'
						);
			$this->db->from('tbl_messages');
			$this->db->join('tbl_ceos','tbl_ceos.id = tbl_messages.ceo1_id' );
			$this->db->where('tbl_messages.id',$lastmsgid);
			$msg = $this->db->get();
			if($msg->num_rows() >0){
				$msgs['message'] =  $msg->result();
			}
			
			$msgs['ceos_info'] = $this->getConnectionsModel($current_ceo_id);
			
			return $msgs;
		
		}
		
		
		public function AutoCompleteNameModel($data){
			
			$resultss = "";
			
			$this->db->select('tbl_connections.*, tbl_ceos.first_name, tbl_ceos.last_name, tbl_ceos.id as ceo_id, tbl_ceos.ceo_profile_pic, tbl_ceo_business_details.business_id, tbl_businesses.business_name');
			$this->db->from('tbl_connections');
			$this->db->join('tbl_ceos', 'tbl_ceos.id = tbl_connections.ceo2_id AND tbl_connections.ceo2_id != "'.$data['cid'].'" OR tbl_ceos.id = tbl_connections.ceo1_id AND tbl_connections.ceo1_id != "'.$data['cid'].'" ', 'left');
			$this->db->join('tbl_ceo_business_details', 'tbl_ceo_business_details.ceo_id = tbl_ceos.id', 'left');
			$this->db->join('tbl_businesses', 'tbl_businesses.id = tbl_ceo_business_details.business_id', 'left');
			$this->db->where("(tbl_connections.ceo1_id = '".$data['cid']."' OR tbl_connections.ceo2_id = '".$data['cid']."')");
			$this->db->where('tbl_connections.accepted', 1);
			$this->db->where('tbl_connections.is_active', true);
			$this->db->like('tbl_ceos.first_name',$data['keyword']);
			//$this->db->or_like('tbl_ceos.last_name',$data['keyword']);
			$result = $this->db->get();
			if($result->num_rows() > 0)
			{
				$resultss = $result->result_array();
			}
			return $resultss;
			
		}
		
		
}
?>