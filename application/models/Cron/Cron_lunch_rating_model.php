<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cron_lunch_rating_model extends CI_Model {
		
		public $datetime;
		
        public function __construct()
        {
            parent::__construct();
			$this->datetime = date("Y-m-d H:i:s"); 	
        }

		public function LunchRatingCronJobModel(){
		
		$this->db->select(
						'tbl_logs.log_id, 
						tbl_logs.log_parent_id, 
						tbl_logs.performed_by_ceo as accepter_ceo, 
						tbl_logs.performed_to_ceo as requester_ceo, 
						tbl_logs.task_id, tbl_logs.created_on, 
						tbl_logs.is_notified, tbl_lunches.id as lunch_id, 
						tbl_lunches.proposal_id, tbl_lunches.lunch_request_status, 
						tbl_ceos.nickname as acepter_nickname, c.ceo_profile_pic as requester_pic, c.nickname as requester_nickname, tbl_ceos.ceo_profile_pic as acepter_pic, 
						tbl_ceos.id as acepter_ceo_id, c.id as requester_ceo_id, c.email as requester_email, tbl_ceos.email as acepter_email');
		$this->db->from('tbl_logs');
		$this->db->join('tbl_lunches','tbl_lunches.id = tbl_logs.task_id');
		$this->db->join('tbl_ceos','tbl_ceos.id = tbl_logs.performed_by_ceo');
		$this->db->join('tbl_ceos c','c.id = tbl_logs.performed_to_ceo');
		$this->db->where('tbl_logs.log_parent_id',12); 
		$this->db->where('tbl_logs.is_active',true); 
		$this->db->where('tbl_logs.created_on <=', date('Y-m-d H:i:s', strtotime('-2 week'))); 
		$this->db->order_by('tbl_logs.log_id', 'desc'); 
		$a = $this->db->get();
		if($a->num_rows() > 0){
		
		foreach($a->result() as $aa)  {
		
			/***Mail To Requester***/		
			$to = $aa->acepter_email;
			$subject = "Rate Your Lunch!";
			$message = '<html xmlns="http://www.w3.org/1999/xhtml"><head><style type="text/css">
					body {
						padding-top: 0 !important;
						padding-bottom: 0 !important;
						padding-top: 0 !important;
						padding-bottom: 0 !important;
						margin:0 !important;
						width: 100% !important;
						-webkit-text-size-adjust: 100% !important;
						-ms-text-size-adjust: 100% !important;
						-webkit-font-smoothing: antialiased !important;
					}
					.tableContent img {
						border: 0 !important;
						display: block !important;
						outline: none !important;
					}
					a { color:#382F2E; }

					p, h1 {
					  color:#382F2E;
					  margin:0;
					}
					p {
						text-align:left;
						color:#999999;
						font-size:14px;
						font-weight:normal;
						line-height:19px;
					}
					a.link1{
						color:#382F2E;
					}
					a.link2{
						font-size:16px;
						text-decoration:none;
						color:#ffffff;
					}

					h2{
						text-align:left;
						color:#222222; 
						font-size:19px;
						font-weight:normal;
					}
					div,p,ul,h1{
						margin:0;
					}
					.bgItem {
						background-image:url("http://nile.ingeniousonline.co.in/projects/demomailtest/images/bkg1.jpg");
						background-size:cover !important;
						background-repeat:no-repeat !important;
						background-position:center !important;
					}
					</style></head>';
			
				$acepter_pic = "";
				if(!empty($aa->acepter_pic)){
					$acepter_pic = base_url().'uploads/profile/64/'.$aa->acepter_pic;
				}
				else {
					$acepter_pic = base_url().'images/user64x64.jpg';
				}
				$message .= '<body style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">';
				$message .= '<table width="600" border="0" cellspacing="0" cellpadding="0" class="tableContent bgBody" align="center"  style="font-family:Helvetica, Arial,serif;">';
				$message .= '<tr><td height="25"></td></tr><tr>';
				$message .= '<td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="bgItem"  style="">';
				$message .= '<tr><td width="40"></td><td width="520"><table width="520" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td height="75"></td></tr><tr>';
				$message .= '<td class="movableContentContainer" valign="top"><div lass="movableContent">';
				$message .= '<table width="520" border="0" cellspacing="0" cellpadding="0" align="center">';
				$message .= '<tr><td valign="top" align="center"><div class="contentEditableContainer contentTextEditable">';
				$message .= '<div class="contentEditable"><p style="text-align:center; margin:0; font-family:Georgia,Time,sans-serif; font-size:26px; color:#222222;"></span></p>';
				$message .= '</div></div></td></tr></table></div>';
				$message .= '<div class="movableContent"><table width="520" border="0" cellspacing="0" cellpadding="0" align="center">';
				$message .= '<tr><td valign="top" align="center"><div class="contentEditableContainer contentImageEditable">';
				$message .= '<div class="contentEditable"><p style="text-align:center; color:#ffffff; font-size:40px; font-family:Verdana, Geneva, sans-serif;font-weight:bold;line-height:35px; padding-top:20px;">RONDAS</p></div></div></td></tr></table></div>';
				$message .= '<div class="movableContent"><table width="520" border="0" cellspacing="0" cellpadding="0" align="center">';
				$message .= '<tr><td height="55"></td></tr><tr><td height="20"></td></tr><tr><td align="left">';
				$message .= '<div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">
							<img src="'.$acepter_pic.'"></div></div></td></tr>';
				$message .= '<tr><td height="20"></td></tr><tr><td align="left"><div class="contentEditableContainer contentTextEditable">';
				$message .= '<div class="contentEditable" align="center"><p style="text-align:center; color:#ffffff; font-size:28px; font-weight:400; line-height:auto; font-family: "Roboto",sans-serif; letter-spacing:3px;"><br><br><span style="color:#ffffff; font-size:28px; font-weight:bold;">'.$aa->acepter_nickname.' </span>Cuentanos come fue <br> <br> tu<span style="color:#ffffff; font-size:28px;font-weight:bold;"> LUNCH </span>con '.$aa->requester_nickname.' </p> </div> </div></td></tr>';
				$message .= '<tr><td height="55"></td></tr><tr><td height="55"></td></tr>';
				$message .= '<tr><td align="center"><table><tr><td align="center" style="padding:0px 10px; height:10px; border:2px solid #ffffff;-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px;">';
				$message .= '<div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">';
				$message .= '<a target="_blank" href="'.base_url().'index.php/LunchExperience?requester='.base64_encode($aa->requester_ceo_id) . '&accepter='.base64_encode($aa->acepter_ceo_id) . '&propid='.base64_encode($aa->proposal_id) .'&lunchid='.base64_encode($aa->lunch_id) .'&log_id='.base64_encode($aa->log_id) .'&rateby=a" class="link2" style="padding: 0px;font-family: "Roboto",sans-serif; font-weight:lighter; font-size:20px;color:#ffffff;">RATE YOUR LUNCH</a></div></div></td></tr></table></td></tr>';
				$message .= '<tr><td height="20"></td></tr><tr><td height="75"></td></tr><tr><td height="75"></td></tr>';
				$message .= '<tr><td align="left"><div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center"><p style="text-align:center; color:#ffffff; font-size:10px; font-weight:lighter; line-height:30px; font-family: "Roboto",sans-serif; letter-spacing:2px;"> Rondas Corporation © 2015</p></div></div></td></tr></table>';
				$message .= '</div></td></tr></table></td><td width="40"></td></tr></table></td></tr><tr>';
				$message .= '<td height="88"></td></tr></table></body></html>';
				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers .= 'From: <pardeep@ingeniousonline.co.in>' . "\r\n";
				mail($to,$subject,$message,$headers);
				
				
				/**************************************************************/
				
				/***Mail To Requester***/		
				
				$to1 = $aa->requester_email;
				$subject1 = "Rate Your Lunch!";
				$message1 = '<html xmlns="http://www.w3.org/1999/xhtml"><head><style type="text/css">
					body {
						padding-top: 0 !important;
						padding-bottom: 0 !important;
						padding-top: 0 !important;
						padding-bottom: 0 !important;
						margin:0 !important;
						width: 100% !important;
						-webkit-text-size-adjust: 100% !important;
						-ms-text-size-adjust: 100% !important;
						-webkit-font-smoothing: antialiased !important;
					}
					.tableContent img {
						border: 0 !important;
						display: block !important;
						outline: none !important;
					}
					a { color:#382F2E; }

					p, h1 {
					  color:#382F2E;
					  margin:0;
					}
					p {
						text-align:left;
						color:#999999;
						font-size:14px;
						font-weight:normal;
						line-height:19px;
					}
					a.link1{
						color:#382F2E;
					}
					a.link2{
						font-size:16px;
						text-decoration:none;
						color:#ffffff;
					}

					h2{
						text-align:left;
						color:#222222; 
						font-size:19px;
						font-weight:normal;
					}
					div,p,ul,h1{
						margin:0;
					}
					.bgItem {
						background-image:url("http://nile.ingeniousonline.co.in/projects/demomailtest/images/bkg1.jpg");
						background-size:cover !important;
						background-repeat:no-repeat !important;
						background-position:center !important;
					}
					</style></head>';
			
				$requester_pic = "";
				if(!empty($aa->requester_pic)){
					$requester_pic = base_url().'uploads/profile/64/'.$aa->requester_pic;
				}
				else {
					$requester_pic = base_url().'images/user64x64.jpg';
				}
				$message1 .= '<body style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">';
				$message1 .= '<table width="600" border="0" cellspacing="0" cellpadding="0" class="tableContent bgBody" align="center"  style="font-family:Helvetica, Arial,serif;">';
				$message1 .= '<tr><td height="25"></td></tr><tr>';
				$message1 .= '<td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="bgItem"  style="">';
				$message1 .= '<tr><td width="40"></td><td width="520"><table width="520" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td height="75"></td></tr><tr>';
				$message1 .= '<td class="movableContentContainer" valign="top"><div lass="movableContent">';
				$message1 .= '<table width="520" border="0" cellspacing="0" cellpadding="0" align="center">';
				$message1 .= '<tr><td valign="top" align="center"><div class="contentEditableContainer contentTextEditable">';
				$message1 .= '<div class="contentEditable"><p style="text-align:center; margin:0; font-family:Georgia,Time,sans-serif; font-size:26px; color:#222222;"></span></p>';
				$message1 .= '</div></div></td></tr></table></div>';
				$message1 .= '<div class="movableContent"><table width="520" border="0" cellspacing="0" cellpadding="0" align="center">';
				$message1 .= '<tr><td valign="top" align="center"><div class="contentEditableContainer contentImageEditable">';
				$message1 .= '<div class="contentEditable"><p style="text-align:center; color:#ffffff; font-size:40px; font-family:Verdana, Geneva, sans-serif;font-weight:bold;line-height:35px; padding-top:20px;">RONDAS</p></div></div></td></tr></table></div>';
				$message1 .= '<div class="movableContent"><table width="520" border="0" cellspacing="0" cellpadding="0" align="center">';
				$message1 .= '<tr><td height="55"></td></tr><tr><td height="20"></td></tr><tr><td align="left">';
				$message1 .= '<div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">
							<img src="'.$requester_pic.'"></div></div></td></tr>';
				$message1 .= '<tr><td height="20"></td></tr><tr><td align="left"><div class="contentEditableContainer contentTextEditable">';
				$message1 .= '<div class="contentEditable" align="center"><p style="text-align:center; color:#ffffff; font-size:28px; font-weight:400; line-height:auto; font-family: "Roboto",sans-serif; letter-spacing:3px;"><br><br><span style="color:#ffffff; font-size:28px; font-weight:bold;">'.$aa->requester_nickname.' </span>Cuentanos come fue <br> <br> tu<span style="color:#ffffff; font-size:28px;font-weight:bold;"> LUNCH </span>con '.$aa->acepter_nickname.' </p> </div> </div></td></tr>';
				$message1 .= '<tr><td height="55"></td></tr><tr><td height="55"></td></tr>';
				$message1 .= '<tr><td align="center"><table><tr><td align="center" style="padding:0px 10px; height:10px; border:2px solid #ffffff;-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px;">';
				$message1 .= '<div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">';
				$message1 .= '<a target="_blank" href="'.base_url().'index.php/LunchExperience?requester='.base64_encode($aa->requester_ceo_id) .'&accepter='.base64_encode($aa->acepter_ceo_id) .'&propid='.base64_encode($aa->proposal_id) .'&lunchid='.base64_encode($aa->lunch_id) .'&log_id='.base64_encode($aa->log_id) .'&rateby=r" class="link2" style="padding: 0px;font-family: "Roboto",sans-serif; font-weight:lighter; font-size:20px;color:#ffffff;">RATE YOUR LUNCH</a></div></div></td></tr></table></td></tr>';
				$message1 .= '<tr><td height="20"></td></tr><tr><td height="75"></td></tr><tr><td height="75"></td></tr>';
				$message1 .= '<tr><td align="left"><div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center"><p style="text-align:center; color:#ffffff; font-size:10px; font-weight:lighter; line-height:30px; font-family: "Roboto",sans-serif; letter-spacing:2px;"> Rondas Corporation © 2015</p></div></div></td></tr></table>';
				$message1 .= '</div></td></tr></table></td><td width="40"></td></tr></table></td></tr><tr>';
				$message1 .= '<td height="88"></td></tr></table></body></html>';	
				// Always set content-type when sending HTML email
				$headers1 = "MIME-Version: 1.0" . "\r\n";
				$headers1 .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers1 .= 'From: <pardeep@ingeniousonline.co.in>' . "\r\n";
				mail($to1,$subject1,$message1,$headers1);
				
			}
		}
	}
		
		
}
?>