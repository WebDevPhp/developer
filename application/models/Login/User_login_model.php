<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_login_model extends CI_Model {
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->datetime = date("Y-m-d H:i:s"); 	
        }

		public function check_user($data)
		{
			//Check if user exist	
			$this->db->select('c.*,b.*,b.id as ceo_business_id');
			$this->db->from('tbl_ceos c');
			$this->db->join('tbl_ceo_business_details cbd', 'c.id = cbd.ceo_id');
			$this->db->join('tbl_businesses b', 'b.id = cbd.business_id');
			$this->db->where('c.email', $data['login_username']);
			$this->db->where('c.password', md5($data['login_password']));
			$query = $this->db->get();
			if ($query->num_rows() > 0) { 
				$this->db->where('email',$data['login_username']);
				$this->db->where('password',md5($data['login_password']));
				$this->db->update('tbl_ceos',array('last_login'=>$this->datetime));
				return $query->result();
			} 
			else 
			{ 
				 return false; 
			}
		}
		
		
		public function RegisterUser($data) {
			
			if(!empty($data['registration'][3]['upload_file']['business_logo']['name']))
			{					
				$new_name = time().$data['registration'][3]['upload_file']['business_logo']['name'];
					$config = array(
						'file_name' => $new_name,
						'upload_path' => "./uploads/business/logo/",
						'allowed_types' => "gif|jpg|png|jpeg",
						'overwrite' => TRUE,
						'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
						'max_height' => "",
						'max_width' => ""
					);
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				if ( $this->upload->do_upload('business_logo') )
				{
					$this->load->library('image_lib');
					$data['upload_data'] = $this->upload->data();
					$fname	=	$data['upload_data']['file_name'];
					/* First size */
					 $configSize1['image_library']   = 'gd2';
					 $configSize1['source_image']    = $data['upload_data']['full_path'];
					 $configSize1['maintain_ratio']  = TRUE;
					 $configSize1['width']           = 150;
					 $configSize1['height']          = 150;
					 $configSize1['new_image']   	 = './uploads/business/logo/150/';
					 $this->image_lib->initialize($configSize1);
					 $this->image_lib->resize();
					 $this->image_lib->clear();
					 
					 
					 /* Second size */
					 $configSize2['image_library']   = 'gd2';
					 $configSize2['source_image']    = $data['upload_data']['full_path'];
					 $configSize2['maintain_ratio']  = TRUE;
					 $configSize2['width']           = 300;
					 $configSize2['height']          = 300;
					 $configSize2['new_image']   	 = './uploads/business/logo/';
					 $this->image_lib->initialize($configSize2);
					 $this->image_lib->resize();
					 $this->image_lib->clear();
				}
				
			}
			else{
				$fname	=	"";
			}
				
			// Inserting in Table(students) of Database(college)
			
			$this->db->trans_begin();
			$this->db->insert( 'tbl_ceos', $data['registration'][0] );
			$ceo_id = $this->db->insert_id();
			$data['registration'][1]['logo_url'] = $fname;
			$this->db->insert( 'tbl_businesses', $data['registration'][1] );
			$business_id = $this->db->insert_id();
			
			$data['compos'] = array(
					  'ceo_id'			=> 	$ceo_id,
					  'business_id'		=> 	$business_id,
					  'created_on' 		=> 	$this->datetime,
					  'updated_on' 		=> 	"",
					  'deleted_on' 		=>	"",
					  'is_active' 		=> 	true
					);
					
			$this->db->insert( 'tbl_ceo_business_details', $data['compos'] );
			
			$exp_tags = $data['registration'][2]['tags_value'];
			
			if(!empty($data['registration'][2]['tags_value']))
			{
				for($i=0; $i<count($exp_tags); $i++)
				{
					$tagid = $this->db->get_where('tbl_industries', array('name' => $exp_tags[$i]));
					$hashtagVal = $tagid->result();
					$data['tag'] = array(
						  'business_id'			=> 	$business_id, 
						  'industry_id'			=> 	$hashtagVal[0]->id, 
						  'created_on'			=> 	$this->datetime, 
						  'updated_on'			=> 	"", 
						  'deleted_on'			=> 	"", 
						  'is_active'			=> 	true, 
						);
					$this->db->insert( 'tbl_businesses_industries', $data['tag'] );
				}
			}
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				return FALSE;
			}
			else
			{
				$this->db->trans_commit();
				return TRUE;
			}
		
		}
		
		public function check_forget_user($data)
		{
			//Check if user exist	
 			$query = $this->db->get_where('tbl_ceos', array('email' => $data['for_username'])); 
			if ($query->num_rows() == 1) { 
				$randstr = md5(uniqid($data['for_username'], true));
				$val = array('email'=> $data['for_username'], 'resetstr'=> $randstr, 'created_on'=> $this->datetime, 'is_used'=> true );
				$query = $this->db->insert( 'tbl_reset_pass', $val );
				if($query) // will return true if succefull else it will return false
				{
					$response['status'] = TRUE;
					$response['string'] = $randstr;
				}
			} 
			else { 
				$response['status'] = FALSE;
			}
			return $response;
		}
		
		public function GetGroupNamesModel()
		{
			//Check if user exist	
 			$query = $this->db->get_where('tbl_vistage', array('is_active' => true)); 
			return $query->result();
		}
		
		public function getIndustriesListModel()
		{
			$c="";
			//Check if user exist	
 			$query = $this->db->get_where('tbl_industries', array('is_active' => true)); 
			//return $query->result();
			foreach( $query->result() as $key => $q ){
				$c[] = $q->name;
			}
			return 	$c;
		}
		
		
		public function UpdatePass($data){
			
			$regemail = $data['email'];
			$string = $data['email_str'];
			$regex = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^"; 
			if ( preg_match( $regex, $regemail ) ) 
			{ 
				$query = $this->db->get_where('tbl_reset_pass', array('email' => $regemail, 'resetstr' => $string, 'is_used' => true));	

				if ($query->num_rows() == 1) { 
					$data['password'] = md5($data['password']);
					$newpass = array('password'=>$data['password']);
					$this->db->where('email', $data['email']);
					$this->db->update('tbl_ceos', $newpass);
					if($this->db->affected_rows() > 0) // will return true if successfull else it will return false
					{
						$is_used = array('updated_on'=>$this->datetime, 'is_used' => FALSE);
						$array = array('email' => $data['email'], 'resetstr' => $data['email_str']);
						$this->db->where($array);
						$this->db->update('tbl_reset_pass', $is_used);
						$response['message'] = "updated Successfully!";
						$response['status'] = TRUE;
					}
					else{
						$response['message'] = "<span style='color:red'>No Changes Made!!</span>";
						$response['status'] = FALSE;
					}
				}
				else { 
					$response['message'] = "<span style='color:red'>Not valid Link!</span>";
					$response['status'] = FALSE;
				}
			} 
			else { 
				$response['message'] = "<span style='color:red'>Not valid Email!</span>";
				$response['status'] = FALSE;
			} 
			return $response;
		}
		
		
		public function getSelectedIndustries($sessiondata){
			$sessiondata = json_decode($sessiondata,true);
			$business_id = $sessiondata[0]['ceo_business_id'];
			$this->db->select("bi.industry_id, ind.name");
			$this->db->from("tbl_businesses_industries bi");
			$this->db->join("tbl_industries ind", "bi.industry_id = ind.id" );
			$this->db->where('bi.business_id', $business_id);
			$this->db->where('bi.is_active', true);
			$query = $this->db->get();
			if ($query->num_rows() > 0) { 
				foreach($query->result() as $key => $res) :
					$resss[$res->industry_id] = $res->name;
				endforeach;
				return $resss;
			} 
		}
		
		public function UpdateProfileModel( $data ){
			
			$profileimg = "";
			$bg_business = "";
			$logo_business = "";
			
			if (!empty($data[1]['uploadfiles']['profile_pic']['name'])) {
				$profileimg = time().rand().$data[1]['uploadfiles']['profile_pic']['name'];
			}
			if (!empty($data[1]['uploadfiles']['bg_business']['name'])) {
				$bg_business = time().rand().$data[1]['uploadfiles']['bg_business']['name'];
			}
			if (!empty($data[1]['uploadfiles']['edit_business_logo']['name'])) {
				$logo_business = time().rand().$data[1]['uploadfiles']['edit_business_logo']['name'];
			}
			
			$imgs = array('profile_pic','bg_business','edit_business_logo');
			
					$config1 = 	array(
								'file_name' => $profileimg,
								'upload_path' => "./uploads/profile/original/",
								'allowed_types' => "gif|jpg|png|jpeg|pdf",
								'overwrite' => TRUE,
								'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
								'max_height' => "",
								'max_width' => "" 
							);
					
					$config2 = 	array(
								'file_name' => $bg_business,
								'upload_path' => "./uploads/business/background/original/",
								'allowed_types' => "gif|jpg|png|jpeg",
								'overwrite' => TRUE,
								'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
								'max_height' => "",
								'max_width' => "" 
							);
							
					$config3 = 	array(
									'file_name' => $logo_business,
									'upload_path' => "./uploads/business/logo/",
									'allowed_types' => "gif|jpg|png|jpeg|pdf",
									'overwrite' => TRUE,
									'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
									'max_height' => "",
									'max_width' => "" 
								);
								
					$this->load->library('upload', $config1);
					$this->upload->initialize($config1);
					 if ( $this->upload->do_upload($imgs[0]))
					 {
							$this->load->library('image_lib');
							$data['upload_data'] = $this->upload->data();
							$fname[$imgs[0]]	=	$data['upload_data']['file_name'];
							/* First size */
							 $configSize1['image_library']   = 'gd2';
							 $configSize1['source_image']    = $data['upload_data']['full_path'];
							 $configSize1['maintain_ratio']  = TRUE;
							 $configSize1['width']           = 32;
							 $configSize1['height']          = 32;
							 $configSize1['new_image']   	 = './uploads/profile/32/';

							 $this->image_lib->initialize($configSize1);
							 $this->image_lib->resize();
							 $this->image_lib->clear();

							 /* Second size */    
							 $configSize2['image_library']   = 'gd2';
							 $configSize2['source_image']    = $data['upload_data']['full_path'];
							 $configSize2['maintain_ratio']  = TRUE;
							 $configSize2['width']           = 64;
							 $configSize2['height']          = 64;
							 $configSize2['new_image']   = './uploads/profile/64/';

							 $this->image_lib->initialize($configSize2);
							 $this->image_lib->resize();
							 $this->image_lib->clear();

							 /* Second size */    
							 $configSize3['image_library']   = 'gd2';
							 $configSize3['source_image']    = $data['upload_data']['full_path'];
							 $configSize3['maintain_ratio']  = TRUE;
							 $configSize3['width']           = 150;
							 $configSize3['height']          = 150;
							 $configSize3['new_image']   = './uploads/profile/150/';

							 $this->image_lib->initialize($configSize3);
							 $this->image_lib->resize();
							 $this->image_lib->clear();
						}
					
					$this->load->library('upload', $config2);
					$this->upload->initialize($config2);
					
					if ( $this->upload->do_upload($imgs[1])) {
						
							$this->load->library('image_lib');
							$data['upload_data'] = $this->upload->data();
							$fname[$imgs[1]]	=	$data['upload_data']['file_name'];
							/* First size */
							 $configSize1['image_library']   = 'gd2';
							 $configSize1['source_image']    = $data['upload_data']['full_path'];
							 $configSize1['maintain_ratio']  = TRUE;
							 $configSize1['width']           = 1000;
							 $configSize1['height']          = "";
							 $configSize1['new_image']   	 = './uploads/business/background/1000/';
							 $this->image_lib->initialize($configSize1);
							 $this->image_lib->resize();
							 $this->image_lib->clear();
							
							$this->load->library('image_lib');
							$data['upload_data'] = $this->upload->data();
							$fname[$imgs[1]]	=	$data['upload_data']['file_name'];
							/* First size */
							 $configSize1['image_library']   = 'gd2';
							 $configSize1['source_image']    = $data['upload_data']['full_path'];
							 $configSize1['maintain_ratio']  = TRUE;
							 $configSize1['width']           = 1900;
							 $configSize1['height']          = "";
							 $configSize1['new_image']   	 = './uploads/business/background/original/';
							 $this->image_lib->initialize($configSize1);
							 $this->image_lib->resize();
							 $this->image_lib->clear();
						}
						
					$this->load->library('upload', $config3);
					$this->upload->initialize($config3);
					
					if ( $this->upload->do_upload($imgs[2])) {
							$this->load->library('image_lib');
							$data['upload_data'] = $this->upload->data();
							$fname[$imgs[2]]	=	$data['upload_data']['file_name'];
							/* First size */
							 $configSize1['image_library']   = 'gd2';
							 $configSize1['source_image']    = $data['upload_data']['full_path'];
							 $configSize1['maintain_ratio']  = TRUE;
							 $configSize1['width']           = 150;
							 $configSize1['height']          = 150;
							 $configSize1['new_image']   	 = './uploads/business/logo/150/';
							 $this->image_lib->initialize($configSize1);
							 $this->image_lib->resize();
							 $this->image_lib->clear();
					}
					
				
             	if(empty($fname['profile_pic'])){
					$fname['profile_pic'] = $data[0]['editprofile']['hidden_profile_pic'];
				}
				if(empty($fname['bg_business'])){
					$fname['bg_business'] = $data[0]['editprofile']['hidden_bg_business'];
				}
				if(empty($fname['edit_business_logo'])){
					$fname['edit_business_logo'] = $data[0]['editprofile']['hidden_business_logo'];
				}
				
				if(empty($data[0]['editprofile']['edit_password']))
				{
					$password = $data[0]['editprofile']['hidden_password'];
				}
				else{
					$password = md5($data[0]['editprofile']['edit_password']);
				}
				
				if ($data[0]['editprofile']['edit_linkedin2'] != "") {
					$editlinkedin_url = $data[0]['editprofile']['edit_linkedin2'];
				}else{
					$editlinkedin_url = "";
				}
				$textToStore = nl2br(htmlentities($data[0]['editprofile']['edit_business_description'], ENT_QUOTES, 'UTF-8'));
				
				$ceo_data = array(
							'vistage_id'			=> 	$data[0]['editprofile']['edit_vistage_group_id'],
							'first_name'			=> 	$data[0]['editprofile']['edit_first_name'],
							'last_name'				=> 	$data[0]['editprofile']['edit_last_name'],
							'nickname'				=> 	$data[0]['editprofile']['edit_nickname'],
							'email'					=> 	$data[0]['editprofile']['edit_useremail'],
							'password'				=> 	$password,
							'ceo_profile_pic'		=> 	$fname['profile_pic'],
							'linkedin_url'			=> 	$editlinkedin_url,
							'updated_on'			=> 	$this->datetime,
						);
				$business_data = array(
						'CUIT'=> $data[0]['editprofile']['edit_cuit'],
						'business_name'=> $data[0]['editprofile']['edit_business_name'],
						'logo_url'=> $fname['edit_business_logo'],
						'background_img_url'=> $fname['bg_business'],
						'website_url'=> $data[0]['editprofile']['edit_website_url'],
						'description'=> $textToStore,
						'updated_on'=> $this->datetime,
					);  
			 
			// Inserting in Table(students) of Database(college)
			
			$IND_ID = $this->getIndusID($data[0]['editprofile']['edit_tag_value']);
			
			$this->db->trans_begin();
			$ceoid 	=	$data[0]['editprofile']['ceo_id'];
			$busid 	=	$data[0]['editprofile']['business_id'];
			$this->db->update('tbl_ceos', $ceo_data, array('id' => $ceoid));
			$this->db->update('tbl_businesses', $business_data, array('id' => $busid));
			$this->db->update('tbl_businesses_industries', array('is_active' => FALSE), array('business_id' => $busid));
			for($i=0; $i<count($IND_ID); $i++)
			{
				$this->db->insert( 'tbl_businesses_industries', array('business_id'=>$busid,'industry_id'=>$IND_ID[$i], 'created_on'=>$this->datetime,'is_active'=> TRUE) );
			}
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$result['error']  = $this->db->_error_message();
			}
			else
			{
				$this->db->trans_commit();
				$this->db->insert('tbl_logs',array(
													'log_parent_id'=>20,
													'performed_by_ceo'=>$ceoid,
													'created_on' => $this->datetime,
													'is_viewed' =>true,
													'is_notified' =>true,
													'is_active' =>true
												));
				$this->db->select('c.*,b.*,b.id as ceo_business_id');
				$this->db->from('tbl_ceos c');
				$this->db->join('tbl_ceo_business_details cbd', 'c.id = cbd.ceo_id');
				$this->db->join('tbl_businesses b', 'b.id = cbd.business_id');
				$this->db->where('c.id', $ceoid);
				$this->db->where('c.is_active', TRUE);
				$query = $this->db->get();
				$result['success'] = $query->result();
			}
			return $result;
			
		}
		
		public function getIndusID($IndName=""){
			
			if(!empty($IndName))	
			{
				for($i=0; $i<count($IndName); $i++)
				{
					$this->db->select('id');
					$query = $this->db->get_where('tbl_industries', array('name' => $IndName[$i]));
					$a[] = $query->result_array();
				}
				foreach($a as $b){
					$n[] = $b[0]['id'];
				}
				return $n;
			}
		
		}
		
		public function checkValExist($inputval, $action){
			
			//for checking value exist in database or not
			switch($action) :
				case 'checkingemail':
					$query = $this->db->get_where('tbl_ceos', array('email' => $inputval));	
					break;
			
				case 'checkingcuit':
					$query = $this->db->get_where('tbl_businesses', array('CUIT' => $inputval));	
					break;
					
			endswitch;
				
			if($query->num_rows() == 0)
			{
				return FALSE;
			}
			else{
				return TRUE;
			}
		}
		
		public function checkValExistForProfile($inputval, $action, $id){
			
			//for checking value exist in database or not
			switch($action) :
				case 'checkingemail':
					$query = $this->db->get_where('tbl_ceos', array('email' => $inputval, 'id !=' => $id));	
					break;
			
				case 'checkingcuit':
					$query = $this->db->get_where('tbl_businesses', array('CUIT' => $inputval, 'id !=' => $id));	
					break;
					
			endswitch;
				
			if($query->num_rows() == 0)
			{
				return FALSE;
			}
			else{
				return TRUE;
			}
		}
		
		
		public function checkIndustryExistModel($inputval, $action){
			
			//for checking value exist in database or not
			$query = $this->db->get_where('tbl_industries', array('name' => $inputval));	
				
			if($query->num_rows() == 0)
			{
				return FALSE;
			}
			else{
				return TRUE;
			}
		}
		
		
		public function DeleteProfilePicModel($data){
			$query = $this->db->update('tbl_ceos', array('ceo_profile_pic' => "", 'updated_on' => $this->datetime ), array('id' => $data['deletepic']['ceo_id']));
			unlink(FCPATH.'uploads/profile/original/'.$data['deletepic']['picname']);
			unlink(FCPATH.'uploads/profile/150/'.$data['deletepic']['picname']);
			unlink(FCPATH.'uploads/profile/64/'.$data['deletepic']['picname']);
			unlink(FCPATH.'uploads/profile/32/'.$data['deletepic']['picname']);
			if($query)
			{
				$this->db->select('c.*,b.*,b.id as ceo_business_id');
				$this->db->from('tbl_ceos c');
				$this->db->join('tbl_ceo_business_details cbd', 'c.id = cbd.ceo_id');
				$this->db->join('tbl_businesses b', 'b.id = cbd.business_id');
				$this->db->where('c.id', $data['deletepic']['ceo_id']);
				$this->db->where('c.is_active', TRUE);
				$query = $this->db->get();
				$result['success'] = $query->result();
			}
			return $result;
			
		}
		
		
		
}
?>