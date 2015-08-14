<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ControllerName = $this->uri->segment(1);
$MethodName = $this->uri->segment(2);
$userdata = $this->session->userdata('UserData');
$UserData = json_decode($userdata);
$cuserid = $UserData[0]->id;
?>

<script type="text/javascript">

		window.setInterval(function() {
			
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		var requests_html = "";
		var messages_html = "";
		var general_html = "";
		var feeds_html = "";
		var cuserid = <?php echo $cuserid; ?>;
		var requests_notifications = [];
		var general_notifications = [];
		var messages_notifications = [];
		var feeds_notifications = [];
		$.ajax({
			url	: baseurl+'index.php/Common/getNotificationJquery',
			type: 'POST',
			data: { status : 'continue' },
			success:function (a){
				
				//feed page notification
				$.each( $.parseJSON(a), function( key, value ) {
					if(value.log_parent_id != 13){
						feeds_notifications.push(value);
					}
				});				
				
				//menu notification
				$.each( $.parseJSON(a), function( key, value ) {
					
					if( value.log_parent_id == 1 || value.log_parent_id == 11 ) {
						
						requests_notifications.push(value);
					
					} else if( value.log_parent_id == 17 ){
					
						messages_notifications.push(value);
	
					} else if( ( value.log_parent_id == 2 || value.log_parent_id == 8 || value.log_parent_id == 12 || value.log_parent_id == 13 || value.log_parent_id == 15 ) && ( value.performed_to_ceo == cuserid ) ){
					
						general_notifications.push(value);
					
					}
					
				});
				
				if(requests_notifications != "")
				{
					var requestcount = 0;
					$.each( requests_notifications, function( key, value ) {
						var img = "";
						if(value.is_notified == 1){
							requestcount++;	
						}
						if( value.log_parent_id == 1 ) { 
						
							if(value.ceo_profile_pic != ""){
								img = baseurl+'uploads/profile/64/'+value.ceo_profile_pic;
							} else {
								img = baseurl+'images/user64x64.jpg';
							}
							requests_html += '<li class="relativediv prclass'+value.log_id+'" id="lunch'+value.log_id+'">';
							requests_html += '<i style="background:url('+img+')"></i>';
							requests_html += '<div class="clssdiv"><a class="read_notification" href="">'+value.first_name+' '+value.first_name+'<font> quiere conectarse contigo.</font></a>';
							requests_html += '<span class="req-btn"><button state=1 requester="'+value.performed_by_ceo+'" task_id="'+value.task_id+'" log_id="'+value.log_id+'" business_id="'+value.business_id+'" current_user="'+value.performed_to_ceo+'" requester_nick="'+value.nickname+'" class="proposal-submit connectionbtn">Acepter</button>';
							requests_html += '<button state=0  requester="'+value.performed_by_ceo+'" task_id="'+value.task_id+'" log_id="'+value.log_id+'" business_id="'+value.business_id+'" requester_nick="'+value.nickname+'" current_user="'+value.performed_to_ceo+'" class="proposal-submit connectionbtn">Decliner</button></span><span class="req-loader" id="loader'+value.log_id+'"></span></div></li>';
						
						} else if(value.log_parent_id == 11) {
							if(value.requester_ceo_pic != ""){
								img = baseurl+'uploads/profile/64/'+value.requester_ceo_pic;
							} else {
								img = baseurl+'images/user64x64.jpg';
							}
							requests_html += '<li class="relativediv prclass'+value.log_id+'">';
							requests_html += '<i style="background:url('+img+')"></i>';
							requests_html += '<div class="clssdiv"><a class="read_notification" href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.lunch_proposal_id+'">'+value.requester_ceo_fname+' '+value.requester_ceo_lname+'<font> has sent you lunch request on "'+value.proposal_title+'" !</font></a>';
							requests_html += '<span class="req-btn"><button state=1 requester="'+value.performed_by_ceo+'" task_id="'+value.task_id+'" log_id="'+value.log_id+'" business_id="'+value.business_id+'" current_user="'+value.performed_to_ceo+'" lunch_on_proposal="'+value.proposal_title+'" requester_nick="'+value.requester_ceo_nickname+'"  proposal_id="'+value.lunch_proposal_id+'" class="proposal-submit lunchbtn">Acepter</button>';
							requests_html += '<button state=0 requester="'+value.performed_by_ceo+'" task_id="'+value.task_id+'" log_id="'+value.log_id+'" business_id="'+value.business_id+'" requester_nick="'+value.requester_ceo_nickname+'" current_user="'+value.performed_to_ceo+'" lunch_on_proposal="'+value.proposal_title+'" proposal_id="'+value.lunch_proposal_id+'" class="proposal-submit lunchbtn">Decliner</button></span><span class="req-loader" id="loader'+value.log_id+'"></span></div></li>';
						} else { 
							requests_html += '<li><span class="no-notification" href="#">No Requests!</span></li>';
						}
						$('.requests-main .notification-requests-main ul').html(requests_html);
						
					});
					if(requestcount != 0){
						$('.requests-main .req-count').text(requestcount).css({"visibility":"visible", "display":"block"});
					}
				}
				
				
				if(messages_notifications != "")
				{
					var msgcount = 0;
					$.each( messages_notifications, function( key, value ) {
						if(value.is_notified == 1){
							msgcount++;	
						}
						var img = "";
						messages_html += '<li><i style="background:url()"></i>';
						messages_html += '<a href="'+baseurl+'index.php/messages?c_id='+btoa(value.message_sender)+'"><font>'+value.first_name+' '+value.last_name+'</font><span class="msgdesc">'+value.message+'</span><span class="msgtime">'+value.logtime+'</span></a></li>';
					});
				
				} else {
					messages_html += '<li><span class="" href="#">No Mensajes!</span></li>';
				}
					$('.message-main .messages-menu-main ul').html(messages_html);
				if(msgcount != 0){
					$('.message-main .message').text(msgcount).css({"visibility":"visible"});
				}	
				if(general_notifications != "")
				{
					var countno = 0;
					$.each( general_notifications, function( key, value ) {
						if(value.is_notified == 1){
							countno++;	
						}
						var img = "";
						var cls = "";
						if(value.requester_ceo_pic != ""){
							img = baseurl+'uploads/profile/64/'+value.ceo_profile_pic;
						} else {
							img = baseurl+'images/user64x64.jpg';
						}
						if(value.is_viewed == 1) {
							cls = "unread-msg";
						} else {
							cls = "";
						}
						
						messages_notifications += '<li class="prclass '+cls+'" rel="'+value.log_id+'">';
						messages_notifications += '<i style="background:url('+img+')"></i>';
						
						if(value.log_parent_id == 2)
						{
							messages_notifications += '<a class="read_notification" href="'+baseurl+'index.php/CompanyProfileUser?ci='+btoa(value.id)+'&bs='+btoa(value.id)+'"><font>'+value.first_name+' '+value.last_name+'<font>  has accepted your friend request!</a>';
						} else if(value.log_parent_id == 8) {
							messages_notifications += '<a class="read_notification" href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.proposal_id+'"><font>'+value.commenter_fname+' '+value.commenter_lname+'</font> has commented on your proposal "'+value.title+'"</a>';
						} else if(value.log_parent_id == 12){
							messages_notifications += '<a class="read_notification" href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.lunch_proposal_id+'"><font>'+value.proposal_ceo_fname+' '+value.proposal_ceo_lname+'</font> has accepted your lunch request on proposal "'+value.proposal_title+'"</a>';
						} else if(value.log_parent_id == 13){
							messages_notifications += '<a class="read_notification" href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.lunch_proposal_id+'"><font>'+value.requester_ceo_fname+' '+value.requester_ceo_lname+'</font> has declined your lunch request on proposal "'+value.proposal_title+'"</a>';
						} else if(value.log_parent_id == 15){
							messages_notifications += '<a class="read_notification" href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.proposal_id+'"><font>'+value.first_name+' '+value.last_name+'</font> has start follow your proposal "'+value.title+'"</a></li>';
						}
					
					});
					
					if(countno != 0){
						$('.generalnotification .user-num-col').text(countno).css({"visibility":"visible"});
					}
					
				} else {
					messages_notifications += '<li><span class="no-notification" href="#">No Notifications!</span></li>';
				}
					$('.generalnotification .notification-main ul').html(messages_notifications);
				
				
				
//FEED PAGE Notificaciones

				if(feeds_notifications != "") {
					
				$.each( feeds_notifications, function( key, value ) {
					var bg = "";
					var img = "";
					if( value.log_parent_id == 1)
					{
						if(value.logo_url != ""){
							bg = baseurl+"uploads/business/logo/150/"+value.logo_url;
						} else {
							bg = baseurl+"images/demo-logo150x150.jpg";
						}
						if(value.ceo_profile_pic != "") {
							img =  baseurl+"uploads/profile/150/"+value.ceo_profile_pic;
						} else {
							img =  baseurl+"images/user64x64.jpg";	
						}
						
						feeds_html += '<div class="row feed-row loader-div" id="loader-div'+value.log_id+'">';
						feeds_html += '<div class="col-sm-12"><div class="col-sm-9"><div class="feed-user1">'; 
						feeds_html += '<i class="bs-logo"><img width="100%" src="'+bg+'" alt=""></i>';
						feeds_html += '<span class="dd"><i class="req-pic" style="background:url('+img+');"></i></span>'; 
						feeds_html += '<p class="c1"><a href="'+baseurl+'index.php/messages?c_id='+btoa(value.business_id)+'">'+value.nickname+'</a><font>'+value.business_name+'</font></p></div>';
						feeds_html += '<div class="new-sction"><p class="c3">Nueva solicitud de conexión</p>';
						feeds_html += '<p class="c2">'+value.first_name+' '+value.last_name+' quiere conectarse contigo</p></div></div>';
						feeds_html += '<div class="col-sm-3 feed-date">'+value.newlogtime+'<div class="req-btn-acepter"><button class="proposal-submit-reg connection-button" state=1 requester="'+value.performed_by_ceo+'" task_id="'+value.task_id+'" log_id="'+value.log_id+'" current_user="'+value.performed_to_ceo+'">Acepter</button>';
						feeds_html += '<button class="proposal-submit-reg connection-button" state=0 requester="'+value.performed_by_ceo+'" task_id="'+value.task_id+'" log_id="'+value.log_id+'" current_user="'+value.performed_to_ceo+'">Decliner</button>';
						feeds_html += '</div></div></div><span class="lunch-loader"></span></div>';
					}
					
					if( value.log_parent_id == 2)
					{
						var logo = "";
						var img = "";
						if(value.logo_url != ""){
							logo = baseurl+"uploads/business/logo/150/"+value.logo_url;
						} else {
							logo = baseurl+"images/demo-logo150x150.jpg";
						}
						if(value.ceo_profile_pic != "") {
							img =  baseurl+"uploads/profile/150/"+value.ceo_profile_pic;
						} else {
							img =  baseurl+"images/user64x64.jpg";	
						}
						feeds_html += '<div class="row feed-row"><div class="col-sm-12"><div class="col-sm-9">';
						feeds_html += '<div class="feed-user1"><i><img width="100%" src="'+logo+'" alt=""></i>';
						feeds_html += '<i class="req-pic" style="background:url('+img+');"></i>';
						feeds_html += '<p class="c1">'+value.nickname+'<font>'+value.first_name+' '+value.last_name+'</font></p></div>'; 
						feeds_html += '<div class="new-sction"><p class="c2">Felicitaciones</p>';
						feeds_html += '<p class="c3">¡Te has conectado con '+value.nickname+'!</p>';
						feeds_html += '<p class="c2">'+value.first_name+' '+value.last_name+' y tú ahora son contactos </p></div></div>';
						feeds_html += '<div class="col-sm-3 feed-date"><p>'+value.newlogtime+'</p>';
						feeds_html += '<div class="new-sction1"><i class="fa fa-comments"></i></div>';
						feeds_html += '<p class="c4">Enviale un mensaje</p></div></div></div>';
					}
					
					
					if( value.log_parent_id == 5)
					{
						var bg = "";
						var img = "";
						var logo = "";
						var ds = "";
						if(value.proposal_ceo == cuserid) { 
							ds = 'disabled="disabled"';
						}else {
							ds = "";
						}
						
						if(value.proposal_background_img != ""){
							bg = baseurl+"uploads/proposal/"+value.proposal_background_img;
						} 
						if(value.ceo_profile_pic != "") {
							img =  baseurl+"uploads/profile/150/"+value.ceo_profile_pic;
						} else {
							img =  baseurl+"images/user64x64.jpg";	
						}
						if(value.logo_url != "") {
							logo =  baseurl+"uploads/business/logo/150/"+value.logo_url;
						} else {
							logo =  baseurl+"images/demo-logo150x150.jpg";	
						}
						feeds_html += '<div class="row feed-row" style="background:url('+bg+'); background-size:cover; background-position:center;">';
						feeds_html += '<div class="col-sm-12"><div class="col-sm-10"><div class="feed-user comentario-pro">';
						feeds_html += '<i style="background:url('+img+');"></i>';
						if(value.proposal_ceo == cuserid)
						{
						feeds_html += '<span><a class="spananchor" href="javascript:void(0)">'+value.nickname+'</a><font>'+value.business_name+'</font></span></div>';
						}
						else {
						feeds_html += '<span><a class="spananchor" href="CompanyProfileUser?ci='+btoa(value.proposal_ceo)+'&bs='+btoa(value.business_id)+'">'+value.nickname+'</a><font>'+value.business_name+'</font></span></div>';
						}
						feeds_html += '<p class="feed-coment">Público una nueva propuesta</p></div>';
						feeds_html += '<div class="col-sm-2 feed-date">'+value.newlogtime+'</div></div>';
						feeds_html += '<div class="col-sm-12 feed-banners bgfeed'+value.proposal_id+'">';
						feeds_html += '<div class="feed-banners-col"><i><img width="150" src="'+logo+'" alt=""></i>';
						feeds_html += '<h3><a style="color:#1aaeca" href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.proposal_id+'">'+value.title+'</a></h3><p>'+value.description.substr(0,200)+'....</p></div></div>';
					    feeds_html += '<div class="col-sm-12 feed-btn"><p class="slider-btn-row">'; 
						feeds_html += '<a href="javascript:void(0)" class="slider-btns btn feed-just-lunch btndis'+value.proposal_id+'" current-ceo-id="'+cuserid+'" prop-ceo-id="'+value.proposal_ceo+'" pro-id="'+value.proposal_id+'" '+ds+'>';
						feeds_html += '<i class="Library"></i><span>Just Lunch</span></a>'; 
						feeds_html += '<a class="slider-btns btn1" href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.proposal_id+'"><i class="Library1"></i>MÁS INFO</a><a rel="'+value.proposal_id+'" prop-ceo="'+value.proposal_ceo+'" current-ceo="'+<?php echo $cuserid; ?>+'" href="javascript:void(0)" class="slider-btns btn  followbtn_page" '+ds+'><i class="Library2"></i>SEGUIR</a></p>';
						feeds_html += '<div class="feed-rating-row"><span class="star-col"> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> </span>';
						feeds_html += '<p onmouseover="feedlunchpropshow('+value.proposal_id+');" onmouseout="feedlunchprophide('+value.proposal_id+');" class="popoverThis btn btn-large p_lunch" data-original-title="" title=""><i class="Library3"></i>'+value.totallunches+'</p><div id="lu'+value.proposal_id+'" class="lu-pop"><h4 class="popover-title">Just Lunch</h4> <ul> </ul></div>';
						feeds_html += '<p onmouseover="feedfollowpropshow('+value.proposal_id+');" onmouseout="feedfollowprophide('+value.proposal_id+');" class="popoverThis btn btn-large p_follow" data-original-title="" title=""><i class="Library4"></i>'+value.totalfollows+'</p><div id="fo'+value.proposal_id+'" class="fo-pop"><h4 class="popover-title">Follows</h4> <ul> </ul></div></div></div> </div></div>';
					
					}
					
					
					if( value.log_parent_id == 8)
					{
						var img = "";
						if(value.ceo_profile_pic != "") {
							img =  baseurl+"uploads/profile/150/"+value.ceo_profile_pic;
						} else {
							img =  baseurl+"images/user64x64.jpg";	
						}
						
					feeds_html += '<div class="row feed-row"><div class="col-sm-12"><div class="col-sm-10">';
					feeds_html += '<div class="feed-user comentario-pro"><i style="background:url('+img+');"></i>'; 
					feeds_html += '<span><a class="spananchor" href="CompanyProfileUser?ci='+btoa(value.performed_by_ceo)+'&bs='+btoa(value.performed_by_ceo)+'">'+value.commenter_nickname+'</a><font>'+value.commenter_fname+' '+value.commenter_lname+'</font></span> </div>';
					feeds_html += '<p class="feed-coment">Comentó en la propuesta de<font>'+value.receiver_nickname+'</font> <a  href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.proposal_id+'">'+value.title+'</a><br></p></div>';
					feeds_html += '<div class="col-sm-2 feed-date"><p>'+value.newlogtime+'</p></div></div>';
					feeds_html += '<div class="col-sm-12 feed-text-col"><p>'+value.message+'</p></div></div>';
					
					}
					
					if( value.log_parent_id == 11)
					{
						var bg = "";
						var img = "";
						if(value.proposal_background != "") {
							bg =  baseurl+"uploads/proposal/"+value.proposal_background;
						} 
						if(value.requester_ceo_pic != "") {
							img =  baseurl+"uploads/profile/150/"+value.requester_ceo_pic;
						} else {
							img =  baseurl+"images/user64x64.jpg";	
						}
						
						feeds_html += '<div class="row lunch-row loader-div" id="loader-div'+value.log_id+'" style="background:url('+bg+'); background-size:cover; background-position:center;">';
						feeds_html += '<p class="feed-date">'+value.newlogtime+'</p>';
						feeds_html += '<div class="lunch-main"><div class="just-lunch-col-div">';
						feeds_html += '<span class="span-lunch-img"><i class="lunch-req-pic" style="background:url('+img+');"></i> </span>';
						feeds_html += '<p class="nc">'+value.requester_ceo_nickname+'<font>'+value.business_name+'</font></p>';
						feeds_html += '<h3><i class="glyphicon glyphicon-ok-circle"></i>JUST LUNCH</h3><a class="slider-btns2 btn lunchrequest" state=1 requester="'+value.performed_by_ceo+'" task_id="'+value.task_id+'" log_id="'+value.log_id+'" business_id="'+value.business_id+'" current_user="'+value.performed_to_ceo+'"  lunch_on_proposal="'+value.proposal_title+'" requester_nick="'+value.requester_ceo_nickname+'" proposal_id="'+value.lunch_proposal_id+'" href="javascript:void(0)">Aceptar</a>';
						feeds_html += '<a class="slider-btns2 btn lunchrequest" state=0 requester="'+value.performed_by_ceo+'" task_id="'+value.task_id+'" log_id="'+value.log_id+'" business_id="'+value.business_id+'" current_user="'+value.performed_to_ceo+'" lunch_on_proposal="'+value.proposal_title+'" requester_nick="'+value.requester_ceo_nickname+'"  proposal_id="'+value.performed_to_ceo+'" lunch_on_proposal="'+value.proposal_title+'" requester_nick="'+value.lunch_proposal_id+'" href="javascript:void(0)">Declinar</a>';
						feeds_html += '</div></div><span class="lunch-loader"></span></div>';
					}
					
					if( value.log_parent_id == 12)
					{
						var bg = "";
						var img = "";
						var logo = "";
						if(value.proposal_background != "") {
							bg =  baseurl+"uploads/proposal/"+value.proposal_background;
						} 
						if(value.requester_pic != "") {
							img =  baseurl+"uploads/profile/150/"+value.requester_pic;
						} else {
							img =  baseurl+"images/user64x64.jpg";	
						}
						if(value.proposal_ceo_business_logo != "") {
							logo =  baseurl+"uploads/business/logo/150/"+value.proposal_ceo_business_logo;
						} else {
							logo =  baseurl+"images/demo-logo150x150.jpg";	
						}
						
						feeds_html += '<div class="row lunch-row" style="background:url('+bg+'); background-size:cover; background-position:center;">';
						feeds_html += '<p class="feed-date">'+value.newlogtime+'</p>';
						feeds_html += '<div class="lunch-main"><hr><div class="lunch-user">';
						feeds_html += '<i class="feed-lunch-pic" style="background:url('+img+');"></i>'; 
						feeds_html += '<p>'+value.proposal_ceo_nickname+'<font>'+value.proposal_ceo_fname+' '+value.proposal_ceo_lname+'</font></p></div>';
						feeds_html += '<div class="just-lunch-col feedlunchcol"><i><img width="100%" src="'+logo+'" alt=""></i>';
						feeds_html += '<h3><i class="glyphicon glyphicon-ok-circle"></i>JUST LUNCH</h3><p>'+value.proposal_title+'</p></div>';
						feeds_html += '<div class="lunch-user lunch-user-2"><i class="feed-lunch-pic" style="background:url('+img+');"></i>'; 
						feeds_html += '<p>'+value.requester_nick+'<font>'+value.requester_fn+' '+value.requester_ln+'</font></p></div></div></div>';
					}
					
					if( value.log_parent_id == 14 )
					{
						var bg = "";
						var img = "";
						var logo = "";
						if(value.proposal_background != "") {
							bg =  baseurl+"uploads/proposal/"+value.proposal_background;
						} 
						if(value.rater_pic != "") {
							img =  baseurl+"uploads/profile/150/"+value.rater_pic;
						} else {
							img =  baseurl+"images/user64x64.jpg";	
						}
						if(value.proposal_ceo_business_logo != "") {
							logo =  baseurl+"uploads/business/logo/150/"+value.proposal_ceo_business_logo;
						} else {
							logo =  baseurl+"images/demo-logo150x150.jpg";	
						}
						var iss = 1;
						var cls = "";
						while (iss <= 5) {
							if(value.requester_rating >= iss){
								cls = "fa-star fillstar";
							} else {
								cls = "fa-star-o";
							}
						iss++;
						}
						
						feeds_html += '<div class="row feed-row feed-bottom" style="background:url('+bg+'); background-size:cover; background-position:center;">';
						feeds_html += '<div class="col-sm-12"><div class="col-sm-12 feed-date"><p>'+value.newlogtime+'</p></div></div>';
						feeds_html += '<div class="clearfix"></div> <div class="feed-content1-col"><div class="col-sm-12">';
						feeds_html += '<div class="feed-user2 comentario-pro"><i style="background:url('+img+')"></i> <span>'+value.rater_nick+'<font>'+value.rater_fn+' '+value.rater_ln+'</font></span> </div>';
						feeds_html += '<p class="feed-coment1">Dejó una experiencia <font>'+value.req_nick+' <a href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.lunch_proposal_id+'">"'+value.proposal_title+'"</a></font></p></div>';
						feeds_html += '<p>'+value.requester_feedback+'<span>';
						feeds_html += '<i class="fa '+cls+'"></i></span></p></div></div>';
					}
					
					
					if( value.log_parent_id == 15 )
					{
						var img = "";
						if(value.ceo_profile_pic != "") {
							img =  baseurl+"uploads/profile/150/"+value.ceo_profile_pic;
						} else {
							img =  baseurl+"images/user64x64.jpg";	
						}
						
						feeds_html += '<div class="row feed-row"><div class="col-sm-12"><div class="col-sm-10">';
						feeds_html += '<div class="feed-user comentario-pro"><i style="background:url('+img+');"></i>'; 
						feeds_html += '<span><a class="spananchor" href="CompanyProfileUser?ci='+btoa(value.performed_by_ceo)+'&bs='+btoa(value.performed_by_ceo)+'">'+value.first_name+' '+value.last_name+'</a></span> </div>';
						feeds_html += '<p class="feed-coment">Start follow proposal "<font> <a  href="'+baseurl+'index.php/Proposal/ProposalDetail/'+value.proposal_id+'">'+value.title+'</a><br></p></div>';
						feeds_html += '<div class="col-sm-2 feed-date"><p>'+value.logtime+'</p></div></div></div>';
						
					}
					
					if( value.log_parent_id == 20 )
					{
						var img = "";
						if(value.ceo_profile_pic != "") {
							img =  baseurl+"uploads/profile/150/"+value.ceo_profile_pic;
						} else {
							img =  baseurl+"images/user64x64.jpg";	
						}
						
						feeds_html += '<div class="row feed-row"><div class="col-sm-12"><div class="col-sm-10">';
						feeds_html += '<div class="feed-user comentario-pro"><i style="background:url('+img+');"></i>'; 
						feeds_html += '<span><a class="spananchor" href="CompanyProfileUser?ci='+btoa(value.updater_ceo_id)+'&bs='+btoa(value.updater_business_id)+'">'+value.nickname+'</a><font>'+value.business_name+'</font></span></div>';
						feeds_html += '<p class="feed-coment"><font>'+value.nickname+'</font> actualizó su perfil</p></div>';
						feeds_html += '<div class="col-sm-2 feed-date"><p>'+value.newlogtime+'</p></div></div></div>';
					}
				});
				
				}
				else {
					feeds_html += '<div class="row feed-row"><p class="noprop">No Feeds Yet!</p></div>';
				}
				$('.feed-container .container .feeds').html(feeds_html);
			} 
		})
	  
	}, 10000);
	
</script>

<?php

$noti = "";

if(!empty($getNotifications)){
	
	foreach($getNotifications as $n){
		
		if($n['log_parent_id'] == 1 || $n['log_parent_id'] == 11) {
			$noti['requests'][] = $n;
		}
		else if(($n['log_parent_id'] == 2 || $n['log_parent_id'] == 8 || $n['log_parent_id'] == 12 || $n['log_parent_id'] == 13 || $n['log_parent_id'] == 15) && ($n['performed_to_ceo'] == $UserData[0]->id)){
			$noti['general_notification'][] = $n;
		}
		else if( $n['log_parent_id'] == 17 ){
			$noti['private_messages'][] = $n;
		}
		
	}
	
}

?>	
<body class="register-main">
<!-- Full Page Image Background Carousel Header -->
<header> 
  <!-- Navigation -->
  <nav class="navbar navbar-inverse navbar-fixed-top static-nav-color" role="navigation">
    <div class="container"> 
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/Feed">RONDAS</a> </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div id="navbar" class="navbar-collapse collapse">
		<div class="form-group searchbox">
			<form class="navbar-form navbar-left" method="post" action="">
				<a href="javascript:void(0);" class="btn btn-success searchimgbtn"></a>
				<input type="text" placeholder="" class="form-control" id="_search">
			<div class="search_result_main">
				<!--Cuenta y configuración-->
				<div class="search_result_col popover-content popover" id="ceos">
					<h4 class="popover-title">CEOS <?php echo anchor('AdvanceSearch','Advance Search',array('class'=>'adv')); ?></h4>
					<ul>
						<li>
							<span class="search_loader"></span>
						</li>
					</ul>
				</div>
				
				 <!--Cuenta y configuración-->
				
				<div class="search_result_col popover-content popover" id="business">
					<h4 class="popover-title">Empresas</h4>
					  <ul>
						<li>
							<span class="search_loader"></span> 
						</li>
					  </ul>
				</div>
				
				<!--Industrias-->
				<div class="search_result_col popover-content popover" id="industries">
					<h4 class="popover-title">Industrias</h4>
					 <div class="s_Industrias">
						<span class="search_loader"></span> 
					 </div>
				</div>
				
				<!--Rubros-->
				<div class="search_result_col popover-content popover" id="proposals">
					<h4 class="popover-title">Propuestas</h4>
					 <div class="s_Industrias">
						<span class="search_loader"></span> 
					 </div>
				</div>
			
            </div>
			</form>
			
		</div>
        <ul class="nav navbar-nav navbar-right">
          <li class="Lunchs-col"> 
			<a style="padding-right:0;" href="<?php echo base_url(); ?>index.php/Feed">
            <div class="account" style="background:url('<?php if( !empty($UserData[0]->ceo_profile_pic) ) { ?><?php echo base_url(); ?>uploads/profile/32/<?php echo $UserData[0]->ceo_profile_pic; ?><?php } else { ?><?php echo base_url(); ?>images/user30x30.jpg<?php } ?>')"> 
			</div>
			</a>
			<a href="javascript:void(0)">
            <div class="user-mini pull-right"> <span class="welcome">
				<?php echo ucwords($UserData[0]->first_name.' '.$UserData[0]->last_name); ?>
			 <font>see my profile</font></span></div>
            </a>
          	
            	<div id="popoverContent0" class="hide popover-content popover profi-popover">
                <h4 class="popover-title">Cuenta y configuración</h4>
            <ul>
           		<li>
					<?php echo anchor('Proposal', '+ Nueva Propuesta', 'class="profi"'); ?>
					<?php echo anchor('Proposal', 'AGREGAR', 'class="edit"'); ?>
                </li>
             <?php 
			 	if(isset($proposal) && !empty($proposal)){
					foreach($proposal as $proposal_data)
					{
						?>
						<li>
                         <?php echo anchor('Proposal/ProposalDetail/'.$proposal_data['id'], $proposal_data['title'], 'class="profi"'); ?>
                         <?php echo anchor('Proposal/ProposalEdit/'.$proposal_data['id'], 'EDITAR', 'class="edit"'); ?>
						</li>	
						<?php			
					}
				}
				?>
				
				<li class="logoutbtn"><?php echo anchor('Login/EditProfile', 'Edit Profile'); ?></li>
				<li class="logoutbtn"><?php echo anchor('CompanyProfile', 'CEO/Company View'); ?></li>
				<li class="logoutbtn"><?php echo anchor('Login/Logout', 'Logout'); ?></li>
			  </ul>
			</div>
            </li>
<?php 


$general_notification_count = 0;
if(!empty($noti['general_notification']))
{
	for ($row = 0; $row < count($noti['general_notification']); $row++) {
		if($noti['general_notification'][$row]["is_notified"] == true) {
			 $general_notification_count++;
		}
	}
}

$private_messages=0;

if(!empty($noti['private_messages']))
{
	for ($row = 0; $row < count($noti['private_messages']); $row++) {
		if($noti['private_messages'][$row]['is_notified'] == true) {
			 $private_messages++;
		}
	}
}

$requests=0;

if(!empty($noti['requests']))
{
	for ($row = 0; $row < count($noti['requests']); $row++) {
		if($noti['requests'][$row]['is_notified'] == true) {
			 $requests++;
		}
	}
}
/* echo "<pre>";
print_r($noti['general_notification']);
echo "</pre>"; */

?>
			
<!----------------------------------------------Requests Notificaciones--------------------------------------------------->			
			
			<li class="Lunchs-col requests-main">
				<a class="requests" title="Requests" href="javascript:void(0)" rel="<?php echo $UserData[0]->id; ?>">
					<i class="fa fa-exclamation"></i>
					<span class="req-count" style="<?php if($requests == 0) { ?>display:none;<?php } ?>"><?php echo $requests; ?></span> 
				</a>
				<div id="popoverContent0" class="hide popover-content popover notification-requests-main">
					<h4 class="popover-title">Notificaciones</h4>
					<ul>
						<?php if(!empty($noti['requests'])) { ?>
						<?php foreach($noti['requests'] as $req) : ?>
						<?php if($req['log_parent_id'] == 1) { ?>
							<li class="relativediv prclass<?php echo $req['log_id']; ?>" id="lunch<?php echo $req['log_id'];?>">
							<i style="background:url(<?php if(!empty($req['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/64/<?php echo $req['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>)"></i>
							<div class="clssdiv">
							<a class="read_notification" href=""> <?php echo $req['first_name'] .' '. $req['last_name']; ?><font> quiere conectarse contigo.</font></a>
							<span class="req-btn">
								<button state=1 requester="<?php echo $req['performed_by_ceo']; ?>" task_id="<?php echo $req['task_id']; ?>" log_id="<?php echo $req['log_id']; ?>" business_id="<?php echo $req['business_id']; ?>" current_user="<?php echo $req['performed_to_ceo']; ?>" requester_nick="<?php echo $req['nickname']; ?>" class="proposal-submit connectionbtn">Acepter</button>
								<button state=0  requester="<?php echo $req['performed_by_ceo']; ?>" task_id="<?php echo $req['task_id']; ?>" log_id="<?php echo $req['log_id']; ?>" business_id="<?php echo $req['business_id']; ?>" requester_nick="<?php echo $req['nickname']; ?>" current_user="<?php echo $req['performed_to_ceo']; ?>" class="proposal-submit connectionbtn">Decliner</button>
							</span>
							<span class="req-loader" id="loader<?php echo $req['log_id']; ?>"></span>
							</div>
							
							</li>
						<?php } else if($req['log_parent_id'] == 11) { ?>
						<li class="relativediv prclass<?php echo $req['log_id']; ?>">
							<i style="background:url(<?php if(!empty($req['requester_ceo_pic'])) { ?><?php echo base_url(); ?>uploads/profile/64/<?php echo $req['requester_ceo_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>)"></i>
							<div class="clssdiv">
							<?php echo anchor('Proposal/ProposalDetail/'.$req['lunch_proposal_id'],$req['requester_ceo_fname'].' '.$req['requester_ceo_lname'].'<font> has sent you lunch request on "'.$req['proposal_title'].'" !</font>',array('class' => 'read_notification'));?> 
							<span class="req-btn">
								<button state=1 requester="<?php echo $req['performed_by_ceo']; ?>" task_id="<?php echo $req['task_id']; ?>" log_id="<?php echo $req['log_id']; ?>" business_id="<?php echo $req['business_id']; ?>" current_user="<?php echo $req['performed_to_ceo']; ?>"  lunch_on_proposal="<?php echo $req['proposal_title']; ?>" requester_nick="<?php echo $req['requester_ceo_nickname']; ?>"  proposal_id="<?php echo $req['lunch_proposal_id']; ?>" class="proposal-submit lunchbtn">Acepter</button>
								<button state=0 requester="<?php echo $req['performed_by_ceo']; ?>" task_id="<?php echo $req['task_id']; ?>" log_id="<?php echo $req['log_id']; ?>" business_id="<?php echo $req['business_id']; ?>" requester_nick="<?php echo $req['requester_ceo_nickname']; ?>" current_user="<?php echo $req['performed_to_ceo']; ?>" lunch_on_proposal="<?php echo $req['proposal_title']; ?>" proposal_id="<?php echo $req['lunch_proposal_id']; ?>" class="proposal-submit lunchbtn">Decliner</button>
							</span>
							<span class="req-loader" id="loader<?php echo $req['log_id']; ?>"></span>
							</div>
						</li>
						<?php } endforeach; } else { ?>
							<li><span class="no-notification" href="#">No Requests!</span></li>
						<?php } ?>
					</ul>
				</div>
            </li>
			
		
<!----------------------------------------------Message Notificaciones--------------------------------------------------->
		  
			<li class="Lunchs-col message-main" id="">
				<a class="message-notification" title="Messages" href="javascript:void(0)" rel="<?php echo $UserData[0]->id; ?>">
				<span class="message" style="<?php if($private_messages == 0) { ?>display:none;<?php } ?>"><?php echo $private_messages; ?></span> </a>
				<div id="popoverContent0" class="hide popover-content popover messages-menu-main">
				  <h4 class="popover-title">Mensajes <?php echo anchor('messages','View All',array('class' => 'popover-title'));?></h4>
					<ul>
						<?php if(!empty($noti['private_messages'])) { ?>
						<?php foreach($noti['private_messages'] as $req) : ?>
						<?php 
							$actual_date = date("dS M Y", strtotime($req['logtime'])); 
							$time_am_pm = date("h:i A", strtotime($req['logtime'])); 
							$onlydate = date("M d", strtotime($req['logtime'])); 
							$propdate = $req['logtime'];
							$timemsg = "";
							$currentdate = date("Y-m-d H:i:s");
							$t1 = StrToTime ( $currentdate );
							$t2 = StrToTime ( $propdate );
							$diff = $t1 - $t2;
							$hours = $diff / ( 60 * 60 );
							$date1 = new DateTime($propdate);
							$date2 = new DateTime($currentdate);
							$diff = $date2->diff($date1);
						?>
						<?php if($hours < 24) { $timemsg =  $time_am_pm;  } ?>
						<?php if($hours > 24 && $hours < 720) { $timemsg =  $onlydate; } ?> 
						<?php if($hours > 720) { $timemsg =  $onlydate; } ?> 
						<li>
							<i style="background:url('<?php echo base_url(); ?>images/notification-img.png')"></i>
							<?php echo anchor('messages?c_id='.base64_encode($req['message_sender']).'','<font>'.$req['first_name'].' '.$req['last_name'].'</font><span class="msgdesc">'.$req['message'].'</span><span class="msgtime">'.$timemsg.'</span>'); ?>
						</li>
						<?php endforeach; } else { ?>
						<li><span class="" href="#">No Mensajes!</span></li>
						<?php } ?>
					</ul>
				</div>
            </li>
			
<!------------------------------------------General Notifications------------------------------------------------->
      
		  <li class="Lunchs-col generalnotification" id="popoverId2">
		  <a id="notify" title="Notifications" rel="<?php if(!empty($UserData[0]->id)) { echo $UserData[0]->id; } ?>" href="javascript:void(0)"> <i class="fa fa-bell-o"></i>
            <span class="user-num-col" style="<?php if($general_notification_count == 0) { echo "visibility:hidden"; } ?>"><?php echo $general_notification_count; ?></span> </a>
            <div id="popoverContent0" class="hide popover-content popover notification-main">
              <h4 class="popover-title">Notificaciones</h4>
              <ul>
				<?php if(!empty($noti['general_notification'])) { ?>
				<?php foreach($noti['general_notification'] as $notification) : ?>
					
						<li class="prclass <?php if($notification['is_viewed'] == true) { echo "unread-msg"; } ?>" rel="<?php echo $notification['log_id']; ?>">
							<i style="background:url(<?php if(!empty($notification['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/64/<?php echo $notification['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>)"></i>
							
							<?php if($notification['log_parent_id'] == 2) { ?>
								<?php echo anchor('CompanyProfileUser?ci='.base64_encode($notification['id']).'&bs='.base64_encode($notification['id']),'<font>'.$notification['first_name'].' '.$notification['last_name'].'</font> has accepted your friend request!',array('class' => 'read_notification'));?> 
							<?php } ?>
							
							<?php if($notification['log_parent_id'] == 8) { ?>
								<?php echo anchor("Proposal/ProposalDetail/".$notification['proposal_id'],'<font>'.$notification['commenter_fname'].' '.$notification['commenter_lname'].'</font> has commented on your proposal "'.$notification['title'] .'" !',array('class' => 'read_notification'));?> 
							<?php } ?>
							
							<?php if($notification['log_parent_id'] == 12) { ?>
								<?php echo anchor("Proposal/ProposalDetail/".$notification['lunch_proposal_id'],'<font>'.$notification['proposal_ceo_fname'].' '.$notification['proposal_ceo_lname'].'</font> has accepted your lunch request on proposal "'.$notification['proposal_title'] .'" !',array('class' => 'read_notification'));?> 
							<?php } ?>
							
							<?php if($notification['log_parent_id'] == 13) { ?>
								<?php echo anchor("Proposal/ProposalDetail/".$notification['lunch_proposal_id'],'<font>'.$notification['requester_ceo_fname'].' '.$notification['requester_ceo_lname'].'</font> has declined your lunch request on proposal "'.$notification['proposal_title'] .'" !',array('class' => 'read_notification'));?> 
							<?php } ?>
							
							<?php if($notification['log_parent_id'] == 15) { ?>
								<?php echo anchor("Proposal/ProposalDetail/".$notification['proposal_id'],'<font>'.$notification['first_name'].' '.$notification['last_name'].'</font> has start follow your proposal "'.$notification['title'] .'" !',array('class' => 'read_notification'));?> 
							<?php } ?>
							
						</li>
				
					<?php endforeach; } else { ?>
					<li>
						<span class="no-notification" href="#">No Notifications!</span>
					</li>
				<?php } ?>
              </ul>
            </div>
          </li>
        </ul>
      </div>
      
      <!-- /.navbar-collapse --> 
    </div>
    <!-- /.container --> 
	
  </nav>
  
	<!------------------For Company Profile View------------------->
	<?php 
		if( $ControllerName == 'CompanyProfile' ) { ?>
		<style>.navbar{ margin-bottom: 0px; }</style>
			<div class="container Perfil-Empresa-container">
				<div class="row">
					<div class="col-sm-2">
						<div class="CompanyProfilePic" style="background:url('<?php if(!empty($UserData[0]->ceo_profile_pic)) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $UserData[0]->ceo_profile_pic; ?><?php } else { ?><?php echo base_url(); ?>images/user108x108.jpg<?php } ?>')">
						</div>
					</div>
					<div class="col-sm-3 Tennyson-col-1">
						<h1><?php echo ucfirst($UserData[0]->nickname); ?></h1>
						<h6><?php echo ucwords($UserData[0]->first_name.' '.$UserData[0]->last_name); ?></h6>
						<p>CEO at <?php echo $UserData[0]->business_name; ?></p>
						<a class="Info-Genera-social" target="_blank" href="<?php echo $UserData[0]->linkedin_url; ?>">
						<i class="fa fa-linkedin-square"></i>See Linkedin profile</a>
					</div>
				</div>
		<?php } ?>
	<!-----------------------------------------------------------> 
	<!---------------For Company Profile User View--------------->
	<?php 
		if( $ControllerName == 'CompanyProfileUser' ) { ?>

		<style>.navbar{ margin-bottom: 0px; }</style>
			<div class="container Perfil-Empresa-container">
				<div class="row">
					<div class="col-sm-2">
						<div class="CompanyProfilePic" style="background:url('<?php if(!empty($info['personal'][0]['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $info['personal'][0]['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user108x108.jpg<?php } ?>')">
						</div>
					</div>
					<div class="col-sm-2 Tennyson-col-1">
						<h1><?php echo ucfirst($info['personal'][0]['nickname']); ?></h1>
						<h6><?php echo ucwords($info['personal'][0]['first_name'].' '.$info['personal'][0]['last_name']); ?></h6>
						<p>CEO at <?php echo $info['personal'][0]['business_name']; ?></p>
						<a class="Info-Genera-social" target="_blank" href="<?php echo $info['personal'][0]['linkedin_url']; ?>"><i class="fa fa-linkedin-square"></i>See Linkedin profile</a>
					</div>
					<div class="col-sm-2 connectbtn">
					
					
					<?php if(!empty($checkrequest) && $checkrequest[0]->accepted == 1 && $checkrequest[0]->ceo2_id != $UserData[0]->id ) { ?>
						<button class="btn btn-default dis" disabled="disabled">Connected</button>
					<?php } 

					else if(!empty($checkrequest) && $checkrequest[0]->accepted == 2 && $checkrequest[0]->ceo2_id != $UserData[0]->id) { ?>
						<button class="btn btn-default dis" disabled="disabled">Request Sent</button>
					<?php } 

					else if (!empty($checkrequest) && $checkrequest[0]->accepted == 1 && $checkrequest[0]->ceo2_id == $UserData[0]->id){ ?>
						<button class="btn btn-default dis" disabled="disabled">Connected</button>
					<?php } 

					else if (!empty($checkrequest) && $checkrequest[0]->accepted == 2 && $checkrequest[0]->ceo2_id == $UserData[0]->id){ ?>
						<button class="btn btn-default dis" disabled="disabled">Waiting for Response</button>
					<?php } else { ?>
						<button class="btn btn-default" id="connect" rel="<?php echo $info['personal'][0]['ceoid']; ?>">Connect</button>
					<?php } ?>
					</div>
				</div>
		<?php } ?>
	<!----------------------------------------------------->
</header>
<?php 

function xyz($c){
	echo "helelo";
}


?>