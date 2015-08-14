$(document).ready(function(){

// Proposal Case ADD EDIT
	
	$('.title_div').hover(function(){
		$('.title_div').attr('title','Click here to edit');
	})
	
	$("#div_prop_title").click(function(){
		$("#prop_title").removeAttr("readonly").css({"background":"#fff","border":"1px solid #333"});
		$("#proposal_desc").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none","height":"250px"});
		$("#proposal_benefits").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none","height":"250px"});
	});
	
	$("#div_proposal_desc").click(function(){
		$("#proposal_desc").removeAttr("readonly").css({"background":"#fff","border":"1px solid #333","height":"auto","overflow":"visible"});
		$("#prop_title").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none"});
		$("#proposal_benefits").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none","height":"250px"});
	});
	
	$("#div_proposal_benefits").click(function(){
		$("#proposal_benefits").removeAttr("readonly").css({"background":"#fff","border":"1px solid #333","height":"auto","overflow":"visible"});
		$("#prop_title").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none"});
		$("#proposal_desc").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none","height":"250px"});
	});
	
	$("#prop_title").focus(function(){
		$(this).parent().parent('div').css({"border":"none"});
		$(this).removeAttr("readonly").css({"background":"#fff","border":"1px solid #333","cursor":"auto"});
		$("#proposal_benefits").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none"});
		$("#proposal_desc").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none","height":"250px"});
	});
	
	$("#proposal_desc").focus(function(){
		$(this).parent().parent('div').css({"border":"none"});
		$(this).removeAttr("readonly").css({"background":"#fff","border":"1px solid #333","height":"auto","overflow":"visible","cursor":"auto"});
		$("#prop_title").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none"});
		$("#proposal_benefits").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none","height":"250px"});
	});
	
	$("#proposal_benefits").focus(function(){
		$(this).parent().parent('div').css({"border":"none"});
		$(this).removeAttr("readonly").css({"background":"#fff","border":"1px solid #333","height":"auto","overflow":"visible","cursor":"auto"});
		$("#prop_title").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none"});
		$("#proposal_desc").attr("readonly","readonly").css({"background":"none","border":"0","outline":"none","height":"250px"});
	});
	
	$("#prop_title").focusout(function(){
		$(this).attr("readonly","readonly");
	});
	
	$("#proposal_desc").focusout(function(){
		$(this).attr("readonly","readonly");
	});
	
	$("#proposal_benefits").focusout(function(){
		$(this).attr("readonly","readonly");
	});
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$("#EditProposal_form").submit(function(){
		
		var flag = true;
		var ProposalTitle = $.trim($("#prop_title").val());
		var ProposalDescription = $.trim($("#proposal_desc").val());
		var ProposalBenefits = $.trim($("#proposal_benefits").val());
		var ProposalBg = $.trim($("#proposal_bg").val());
		
		if( ProposalTitle == null || ProposalTitle == "" )
		{
			$("#proposal_title_id").css({"border":"1px solid red"});
			$('.title_span').css({display: "block"});
			$('#proposal_title_id').prev('.title_span').show("slow");
			flag = false;
		}
		
		if( ProposalDescription == null || ProposalDescription == "" )
		{
			$("#proposal_desc").css({"border":"1px solid red"});
			$('.title_span').css({display: "block"});
			$('#proposal_desc').prev('.title_span').show("slow");
			flag = false;
		}
		
		if( ProposalBenefits == null || ProposalBenefits == "" )
		{
			$("#proposal_benefits").css({"border":"1px solid red"});
			$('.title_span').css({display: "block"});
			$('#proposal_benefits').prev('.title_span').show("slow");
			flag = false;
		}
		
		/*if( ProposalBg == null || ProposalBg == "" )
		{
			$(".error_upload").text("Please upload Background").css({"color":"red","font-size":"14px","float":"left","font-weight": "bold", "margin-left":"15px"});
			flag = false;
		}
		else if( ProposalBg != "" )
		{
			$(".error_upload").text("");
		}
		*/
		
		if(flag == false){
			$('html, body').animate({scrollTop:0}, 'slow');
			$(".second").text("Please fill all fields!").css("color","red");
			return false;
		}
		else{
			$('.loader-block').css('display', 'block');
			return true;
		}
	});
	
	$("#AddProposal_form").submit(function(){
		var flag = true;
		var ProposalTitle = $.trim($("#prop_title").val());
		var ProposalDescription = $.trim($("#proposal_desc").val());
		var ProposalBenefits = $.trim($("#proposal_benefits").val());
		var ProposalBg = $.trim($("#proposal_bg").val());
		
		if( ProposalTitle == "" )
		{
			$("#div_prop_title").css({"border":"1px solid red"});
			flag = false;
		}
		
		if( ProposalDescription == "" )
		{
			$("#div_proposal_desc").css({"border":"1px solid red"});
			flag = false;
		}
		
		if( ProposalBenefits == "" )
		{
			$("#div_proposal_benefits").css({"border":"1px solid red"});
			flag = false;
		}
		
		if( ProposalBg == "" )
		{
			$(".error_upload").text("Please upload Background").css({"color":"red","font-size":"14px","float":"left","font-weight": "bold", "margin-left":"15px"});
			flag = false;
		}
		else if( ProposalBg != "" )
		{
			$(".error_upload").text("");
		}
		
		if(flag == false){
			$('html, body').animate({scrollTop:0}, 'slow');
			$(".second").text("Please fill all fields!").css("color","red");
			return false;
		}
		else{
			$('.loader-block').css('display', 'block');
			return true;
		}
	});
	
	
	
	 /*------*/	
	var findindus = [];
	$('.neweditable').find('a.highlight').each(function() {
		ind = $(this).attr('rel');
		findindus.push(ind);
		$("#ind_id").val(findindus);
	});
	
	 $('.tab-btns').on('click',function(){
		 if ( $( "#ind_id" ).length > 0)
		 {
			var abc = jQuery(this).attr('rel');
			
			if(findindus.indexOf( abc )>=0)
			{
				var index = findindus.indexOf(abc);
				findindus.splice( index , 1);
				$("#ind_id").val(findindus);
			}
			else
			{ 
				findindus.push(abc);
				$("#ind_id").val(findindus);
			}
		} 
		if($(this).attr('data-click-state') == 0)
		{
			$(this).attr('data-click-state', 1);
			$(this).css({'background': '#1AAECA', 'color': '#FFF'});
			var industryid = $(this).attr('rel');
		}
		else
		{
			$(this).attr('data-click-state', 0);
			$(this).css({'background': '#CFEAEE', 'color': '#b1b1b1'});
			//$('#industry'+$(this).attr('rel')).remove();
		}
	 });
	

////for stop submitting form on enter button
	
	$("#registration_form").bind("keypress", function (e) {
		if (e.keyCode == 13 && ($(e.target)[0]!=$("textarea")[0])) {
				$('.loader-block').css({"display":"none"})
				e.preventDefault();
				return false;
	        }
	});
	
	$("#edit_profile_form").bind("keypress", function (e) {
		if (e.keyCode == 13 && ($(e.target)[0]!=$("textarea")[0])) {
				$('.loader-block').css({"display":"none"})
				e.preventDefault();
				return false;
	        }
	});
////////////////////////////////////////////////////////////////////////	
	
////adding comments on proposals	
	$("#comment_msg").bind("keypress", function (e) {
		if (e.keyCode == 13) {
			var form = $('#comment-form-proposal');
			var root = window.location.origin;
			var myString = location.pathname.split("index.php");
			var baseurl = root + myString[0];
			var ceopic = "";
				$.ajax({
					type:'POST',
					datatype:'json',
					url:form.attr( 'action' ),
					data: form.serialize(),
					success:function(data){
						var c = $.parseJSON(data);
						if(c[0].ceo_profile_pic != "") {
							ceopic = "../../../uploads/profile/64/"+c[0].ceo_profile_pic+"";
						} else {
							ceopic = "../../../images/user.jpg";
						}
						
						$(".comments-sec").append('<div class="row coment-row"><div class="col-sm-2 comentario-pro"><i><img alt="" src="'+ceopic+'"></i><span><a class="spananchor" href="'+baseurl+'index.php/CompanyProfileUser?ci='+btoa(c[0].commenter_id)+'&bs='+btoa(c[0].business_id)+'" >'+c[0].nickname+'</a><font>'+c[0].first_name+' '+c[0].last_name+'</font></span> </div><div class="col-sm-10 comentario-cmt"><p>'+c[0].message+'</p></div></div>');
						$(".comments-sec").load();
						$('#comment-form-proposal')[0].reset();
						//location.reload();					
					}
				})
			}
	});
//////////////////////////////////////////////////////////////////////	
	
////Change Notification status when read
	
	/* $('.notification-main').on('click', 'li a', function() {
		var logid = $(this).attr('id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var burl = root + myString[0];
		$.ajax({
			url	: burl+'index.php/login/changeStatusNotification',
			type: 'POST',
			data: { logid : logid },
			success:function(){	
				$(this).parent('li').removeClass('unread-msg');
			}
		})
	}); */
	

//////////////////////////Friend request notification count////////////////////////////
	
	$('.friendnotification a.friend-notification').hover(function(){
		var cid = $(this).attr('rel');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
			url	: baseurl+'index.php/Common/changeFriendNotificationStatus',
			type: 'POST',
			data: { notification_id : cid },
			success:function (a){ 
				$(".request").css({"visibility":"hidden"});
			}
		})
	}) 
			
///////////////////////Lunch Request Notification Count/////////////////////////////
	
	$('.requests-main a.requests').hover(function(){
		var cid = $(this).attr('rel');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
			url	: baseurl+'index.php/Common/changeRequestsNotificationStatus',
			type: 'POST',
			data: { notification_id : cid },
			success:function (a){ 
				$(".req-count").css({"visibility":"hidden"});
			}
		})
	})
	
/////////////////////////General Notification count//////////////////////////////////
	
	$('.generalnotification a#notify').hover(function(){
		var cid = $(this).attr('rel');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
			url	: baseurl+'index.php/Common/changeGeneralNotificationStatus',
			type: 'POST',
			data: { notification_id : cid },
			success:function (){ 
				$(".user-num-col").css({"visibility":"hidden"});
			}
		})
	})
			
/////////////////////////Message Notification count//////////////////////////////////
	
	$('.message-main a.message-notification').hover(function(){
		var cid = $(this).attr('rel');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
			url	: baseurl+'index.php/Common/changeMessageNotificationStatus',
			type: 'POST',
			data: { notification_id : cid },
			success:function (){ 
				$(".message").css({"visibility":"hidden"});
			}
		})
	})
			
///////////////////////////////////////////////////////////////////////////////////	
	
	//for connect button
	$('#connect').click(function(){
		var receiverid = $(this).attr('rel');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
			url	: baseurl+'index.php/Common/friendrequest',
			type: 'POST',
			data: { receiverid : receiverid },
			success:function (){ 
				$('#connect').attr('disabled',true).text("Request Sent").css({"background-color":"#1AAECA", "color":"#ffffff"});
			}
		})
	})
	
	
//**** lunch request on just lunch button feed proposal only ****//
	
	$('.feeds').on('click','.slider-btn-row  .feed-just-lunch',function(){
		var proposal_id = $(this).attr('pro-id');
		var proposal_ceo_id = $(this).attr('prop-ceo-id');
		var current_ceo_id = $(this).attr('current-ceo-id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
			url	: baseurl+'index.php/Proposal/lunchRequest',
			type: 'POST',
			data: { 
					proposal_id : proposal_id, 
					proposal_ceo_id : proposal_ceo_id, 
					current_ceo_id : current_ceo_id 
					},
			 success:function(a) {
				alert(a);
				/* $('.btndis'+proposal_id).addClass('disabled').attr("disabled",true);
				$('.btndis'+proposal_id+' span').text('Waiting for approval'); */
			}
		});
	});
	
	
	
//**** lunch request from Detail proposal and Feed Slider lunch button ****//
	
	$('.slider-btn-row').on('click','.feed-just-lunch',function(){
		var proposal_id = $(this).attr('pro-id');
		var proposal_ceo_id = $(this).attr('prop-ceo-id');
		var current_ceo_id = $(this).attr('current-ceo-id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
			url	: baseurl+'index.php/Proposal/lunchRequest',
			type: 'POST',
			data: { 
					proposal_id : proposal_id, 
					proposal_ceo_id : proposal_ceo_id, 
					current_ceo_id : current_ceo_id 
					},
			 success:function(a) {
				alert(a);
				/* $('.btndis'+proposal_id).addClass('disabled').attr("disabled",true);
				$('.btndis'+proposal_id+' span').text('Waiting for approval'); */
			}
		});
	});
	
	//follow proposal detail page
	$('.followbtn').click(function(){
		var st = "";
		var proposal_id = $(this).attr('pro-id');
		var proposal_ceo_id = $(this).attr('prop-ceo-id');
		var current_ceo_id = $(this).attr('current-ceo-id');
		var log_id = $(this).attr('log_id');
		var follow_id = $(this).attr('follow_id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		if(log_id == "" && follow_id == "")
		{
			st = "followProposal";
		}
		else {
			st = "unfollowProposal";
		}
		
		$.ajax({
			url	: baseurl+'index.php/Proposal/'+st,
			type: 'POST',
			data: { 
					proposal_id : proposal_id, 
					proposal_ceo_id : proposal_ceo_id, 
					current_ceo_id : current_ceo_id,
					follow_id : follow_id,
					log_id : log_id,
					},
			success:function() {
				location.reload();				
			}
		});
	});
	
	//Follow Proposal Through FEED Slider 
	$(".followbtn_Slider").click(function(){
		var proposal_id = $(this).attr('rel');
		var proposal_ceo_id = $(this).attr('prop-ceo');
		var current_ceo_id = $(this).attr('current-ceo');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		
		$.ajax({
			url	: baseurl+'index.php/Feed/feedsliderfollow',
			type: 'POST',
			data: { 
					proposal_id : proposal_id, 
					proposal_ceo_id : proposal_ceo_id, 
					current_ceo_id : current_ceo_id,
				},
			success:function(a) {
				alert(a);				
			}
		});
	});
	
	
	
	//Follow Proposal Through FEED PAGE 
	$(".feeds").on('click','.followbtn_page',function(){
		var proposal_id = $(this).attr('rel');
		var proposal_ceo_id = $(this).attr('prop-ceo');
		var current_ceo_id = $(this).attr('current-ceo');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		
		$.ajax({
			url	: baseurl+'index.php/Feed/feedsliderfollow',
			type: 'POST',
			data: { 
					proposal_id : proposal_id, 
					proposal_ceo_id : proposal_ceo_id, 
					current_ceo_id : current_ceo_id,
				},
			success:function(a) {
				alert(a);				
			}
		});
	});
	
	
	//friend request on menu
	$('.notification-requests-main').on('click', 'li .connectionbtn', function() {
		var cont = this;
		var requester_id = $(this).attr('requester');
		var current_user = $(this).attr('current_user');
		var state = $(this).attr('state');
		var task_id = $(this).attr('task_id');
		var log_id = $(this).attr('log_id');
		var business_id = $(this).attr('business_id');
		var requester_nick = $(this).attr('requester_nick');
		
		var responsehtml = "";
		var inc = 0;
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$("#loader"+log_id).css({"visibility":"visible"});
		 
		$.ajax({
			url	: baseurl+'index.php/Common/updateFriendRequest',
			type: 'POST',
			data: { 
					requester_id : requester_id, 
					current_user : current_user, 
					state : state, 
					task_id : task_id, 
					log_id : log_id, 
				},
			success:function (a){
				$("#loader"+log_id).css({"visibility":"hidden"});	
				$(".feed-container #loader-div"+log_id).css({"display":"none"})
				if(state == 1)
				{
				$('li.prclass'+log_id).find('a').replaceWith( '<a href="'+baseurl+'index.php/CompanyProfileUser?ci'+requester_id+'&bs='+business_id+'" class="read_notification" style="width:86%">You have accepted connection request of '+requester_nick+'!</a>' );
				}
				else if(state == 0)
				{
				$('li.prclass'+log_id).find('a').replaceWith( '<a href="'+baseurl+'index.php/CompanyProfileUser?ci='+btoa(requester_id)+'&bs='+btoa(business_id)+'" class="read_notification" style="width:86%">You have deleted connection request of '+requester_nick+'!</a>' );
				}
				$('li.prclass'+log_id).find('.proposal-submit').replaceWith('');
			} 
		})
	});
	
	
	
	///////// Connection Request From Feed Page////////////
	
	$('.connection-button').click(function() {
		var box = "";
		var requester_id = $(this).attr('requester');
		var current_user = $(this).attr('current_user');
		var state = $(this).attr('state');
		var task_id = $(this).attr('task_id');
		var log_id = $(this).attr('log_id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$('#loader-div'+log_id+' .lunch-loader').css({"visibility":"visible"}); 
		 
		$.ajax({
			url	: baseurl+'index.php/Common/updateFriendRequest',
			type: 'POST',
			data: { 
					requester_id : requester_id, 
					current_user : current_user, 
					state : state, 
					task_id : task_id, 
					log_id : log_id, 
				},
			success:function (a){
				$('.lunch-request-main li.prclass'+log_id).css({"display":"none"});
				var countlunch = $('.request').text();
				var icc = parseInt(countlunch)-1;
				if(icc == 0){
					$('.request').text(icc).css({"visibility":"hidden"});
					$('.friendnotification .friend-main ul').html('<li><span class="no-notification" href="#">No Friend Request!</span></li>');
				}else{
					$('.lunchrequestcount').text(icc);
				}
				
				$('#loader-div'+log_id+' .lunch-loader').css({"visibility":"hidden"});
				box = $('#loader-div'+log_id).css({"transition":"all 2s linear"});
				box.addClass('visuallyhidden');
				box.one('transitionend', function(e) {
					box.addClass('hidden');
				});
				
			} 
		})
	
	});
	
	//lunch notification menu
	$('.notification-requests-main').on('click', 'li .lunchbtn', function() {
		var cont = this;
		
		var requester_id = $(this).attr('requester');
		var current_user = $(this).attr('current_user');
		var state = $(this).attr('state');
		var task_id = $(this).attr('task_id');
		var log_id = $(this).attr('log_id');
		var business_id = $(this).attr('business_id');
		var requester_nick = $(this).attr('requester_nick');
		var lunch_on_proposal = $(this).attr('lunch_on_proposal');
		var proposal_id = $(this).attr('proposal_id');
		
		
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$('#loader'+log_id).css({"visibility":"visible"}); 
		$.ajax({
			url	: baseurl+'index.php/Common/responseLunchRequest',
			type: 'POST',
			data: { 
				proposal_id : proposal_id, 
				task_id : task_id, 
				state : state, 
				log_id : log_id, 
				requester_id : requester_id, 
				current_user : current_user 
			},
			success:function (){
				$('#loader'+log_id).css({"visibility":"hidden"}); 
				$('.feed-container #loader-div'+log_id).css({"display":"none"});
				if(state == 1)
				{
				$('li.prclass'+log_id).find('a').replaceWith( '<a href="'+baseurl+'index.php/Proposal/ProposalDetail'+proposal_id+'" class="read_notification">You have accepted the lunch request on "'+lunch_on_proposal+'"!</a>' );
				}
				else if(state == 0)
				{
				$('li.prclass'+log_id).find('a').replaceWith( '<a href="'+baseurl+'index.php/Proposal/ProposalDetail'+proposal_id+'" class="read_notification">You have declined the lunch request on "'+lunch_on_proposal+'"!</a>' );
				}
				$('li.prclass'+log_id).find('.lunchbtn').replaceWith('');
			}
		}); 
	});
	
	
	
	///////// Feeds ////////////
	
	$('.lunchrequest').click(function() {
		var cont = this;
		var box = "";
		var requester_id = $(this).attr('requester');
		var current_user = $(this).attr('current_user');
		var state = $(this).attr('state');
		var task_id = $(this).attr('task_id');
		var log_id = $(this).attr('log_id');
		var business_id = $(this).attr('business_id');
		var requester_nick = $(this).attr('requester_nick');
		var lunch_on_proposal = $(this).attr('lunch_on_proposal');
		var proposal_id = $(this).attr('proposal_id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$('#loader-div'+log_id+' .lunch-loader').css({"visibility":"visible"}); 
			$.ajax({
				url	: baseurl+'index.php/Common/responseLunchRequest',
				type: 'POST',
				data: { 
					proposal_id : proposal_id, 
					task_id : task_id, 
					state : state, 
					log_id : log_id, 
					requester_id : requester_id, 
					current_user : current_user 
				},
			success:function (a){
				$('.lunch-request-main li.prclass'+log_id).css({"display":"none"});
				var countlunch = $('.lunchrequestcount').text();
				var icc = parseInt(countlunch)-1;
				if(icc == 0){
					$('.lunchrequestcount').text(icc).css({"visibility":"hidden"});
					$('.lunch-requests-noti .lunch-request-main ul').html('<li><span class="no-notification" href="#">No Lunch Request!</span></li>');
				}else{
					$('.lunchrequestcount').text(icc);
				}
				$('#loader-div'+log_id+' .lunch-loader').css({"visibility":"hidden"});
				box = $('#loader-div'+log_id).css({"transition":"all 2s linear"});
				box.addClass('visuallyhidden');
				box.one('transitionend', function(e) {
					box.addClass('hidden');
				});
			}
		}); 
	});
	
	
	//message thread chat
	$("#add_msg").bind("keypress", function (e) {
		if (e.keyCode == 13) {
			var receiver_ceo = $('#receiver_ceo_id').val();
			if(receiver_ceo != "")
			{
			var form = $('#savemessage');
			var response = "";
			var res_info = "";
			var root = window.location.origin;
			var myString = location.pathname.split("index.php");
			var baseurl = root + myString[0];
			var ceopic = "";
				$.ajax({
					type:'POST',
					datatype:'json',
					url:form.attr( 'action' ),
					data: form.serialize(),
					success:function(data){
						$('#savemessage')[0].reset();
						var obj = $.parseJSON(data);
						if(obj != "")
						{
							if(obj['message'] != "")
							{
								$.each( obj['message'], function( key, value ) {
									
									var FinalTimeMsg = "";
									
									var msgtime = value.message_logtime;		
									
									var msgfulltime = MessageLogTime(msgtime);
									
									// less then 24 hours time format message
									var timedate = getTimeAMPM(msgfulltime);
									
									//Get Hours Difference
									var hoursdiff = getDiffTime(msgfulltime);
									
									//get Month and Day
									var MonDay =  getDayMonth(msgfulltime);
									
									////////////////////////////////////////
									
									
									if( hoursdiff < 24 ) {
										FinalTimeMsg = timedate;
									}
									else {
										FinalTimeMsg = MonDay;
									}
									
									if(value.writer_ceo_pic == "") {
										img = baseurl+'images/user64x64.jpg';
									}
									else {
										img = baseurl+'uploads/profile/64/'+value.writer_ceo_pic;
									}
									response += '<div class="area">';
									response += '<div class="pic-area"><i style="background:url('+img+')"></i></div>';
									response += '<div class="message-area">';
									response += '<span class="sender-name">'+value.writer_ceo_fname+' '+value.writer_ceo_lname+'</span>';
									response += '<span class="message-date">'+FinalTimeMsg+'</span>';
									response += '<p class="msg">'+value.message+'</p></div></div>';
								});
								$('.messages-wrapper .read-messages').append(response);
								$('.messages-wrapper .read-messages').animate({
									scrollTop: $('.messages-wrapper .read-messages').prop("scrollHeight")
								}, 500);
								$('.scrollconnection ul li#mes'+receiver_ceo).addClass('ceoactive');
								$('.messages-content .messages-wrapper').addClass('messages-wrapper-active');
								if ( $( ".messages-wrapper .read-messages div" ).find( ".typename" ) ) {
									$('.typename').remove();
								}
							}
						
							var cl = "";
							
							if(obj['ceos_info'] != "")
							{
								$.each( obj['ceos_info'], function( key, value ) {
									
									var FinalTimeMsg = "";
									
									var msgtime = value.message_logtime;		
									
									var msgfulltime = MessageLogTime(msgtime);
									
									// less then 24 hours time format message
									var timedate = getTimeAMPM(msgfulltime);
									
									//Get Hours Difference
									var hoursdiff = getDiffTime(msgfulltime);
									
									//get Month and Day
									var MonDay =  getDayMonth(msgfulltime);
									
									////////////////////////////////////////
									
									if( hoursdiff < 24 ) {
										FinalTimeMsg = timedate;
									}
									else {
										FinalTimeMsg = MonDay;
									} 
									
									if(value.ceo_profile_pic == "") {
										img = baseurl+'images/user64x64.jpg';
									}
									else {
										img = baseurl+'uploads/profile/64/'+value.ceo_profile_pic;
									}
									if(receiver_ceo == value.msg_ceos_id){
										cl = "ceoactive";
									}else{
										cl = "";
									}
									res_info += '<li id="mes'+value.msg_ceos_id+'" class="message_li '+cl+'" ceo-id="'+value.msg_ceos_id+'"><p class="time-right">'+FinalTimeMsg+'</p>';
									res_info += '<span class="picture_left_small"><i style="background:url('+img+')"></i></span>';
									res_info += '<div class="picture_right">';
									res_info += '<span class="picture_right_name">'+value.first_name+' '+value.last_name+'</span>';
									res_info += '<span class="picture_right_secondname">'+value.message+'</span></div></li>';
								})
								$('.message-left .scrollconnection ul').html(res_info);
							}
						}
						
					}
				})
			}
			else{
				$('.typename .search_name').addClass('redborder');
				$('#send_msg_to').focus();
			}
			}
		});
		
		//new message chat
		
		$('.newmsg').click(function(){
			$('#receiver_ceo_id').val("");
			var current_ceo_id = $('#current_ceo_id').val();
			$('.messages-wrapper').removeClass("messages-wrapper-active");
			if ( $( ".scrollconnection ul li.message_li" ).is( ".ceoactive" ) ) {
				$('.scrollconnection ul li.message_li').removeClass("ceoactive");
			}
			$('.messages-wrapper .read-messages').html('<div class="typename"><div class="search_name"><input type="text" rel="'+current_ceo_id+'" name="send_msg_to" id="send_msg_to" class="send_msg_to" placeholder="Type Name...." /><div class="search-result"><ul></ul></div></div>');
		})
		$('.read-messages').on('keyup', '#send_msg_to', function(e) {
			var response = "";
			var MIN_LENGTH = 1;
			var root = window.location.origin;
			var myString = location.pathname.split("index.php");
			var baseurl = root + myString[0];
			var keyword = $("#send_msg_to").val();
			var cid = $("#send_msg_to").attr('rel');
			var i = 0;
			var cls = "";
			var currid = "";
			var keyw = "";
			if (keyword.length > 0) {
				if ( $( ".read-messages .typename .search_name" ).is( ".redborder" ) ) {
					$('.read-messages .typename .search_name').removeClass("redborder");
				}	
			}
			if (keyword.length >= MIN_LENGTH) {
				//case 13: // Enter
				//case 38: // Up
				//case 40: // Down
				
				if (e.keyCode != '38' && e.keyCode != '40' && e.keyCode != '13') {
				$.ajax({
					url:baseurl+"index.php/Messages/AutoCompleteName",
					type:'GET',
					datatype:'json',
					data: { 
						keyword: keyword, cid : cid 
					},
					success:function(data){
						var obj = $.parseJSON(data);
						if(obj != "")
						{
							$.each( obj, function( key, value ) {
								i++;
								if(i == 1){	cls = "back"; } else { cls = ""; }
								if(value.ceo_profile_pic != "") {
									ceopic = baseurl+"uploads/profile/64/"+value.ceo_profile_pic+"";
								} else {
									ceopic = baseurl+"images/user.jpg";
								}
								response += '<li class="search_res '+cls+'" id="append'+value.ceo_id+'" rel="'+value.ceo_id+'" count="'+i+'">';
								response += '<div class="search-img">';
								response += '<i style="background:url('+ceopic+') no-repeat scroll center center / cover  rgba(0, 0, 0, 0)"></i></div>';
								response += '<div class="search-right-info">';
								response += '<span class="one">'+value.first_name+' '+value.last_name+'</span>';
								response += '<span class="two">'+value.business_name+'</span>';
								response += '</div></li>';
							})
							$('.typename .search-result ul').html(response);	
						}
						else {
							response += '<li>No Result found!</li>';
							$('.typename .search-result ul').html(response);
							
						}
					}
				
				}); 
				}
				else if (e.keyCode == '40' ) {
					if( $( ".search-result ul li.search_res" ).is( ".back" ) ) {
							var length_li = parseInt($('.search-result ul li').length);						
							currid = $('.back').attr("id");
							var count = parseInt($('.back').attr("count"));
							if(count < length_li)
							{
								$('#'+currid).next('li').addClass('back');
								$('#'+currid).removeClass('back');
							}
					}
				}
				else if (e.keyCode == '38' ) {
					if( $( ".search-result ul li.search_res" ).is( ".back" ) ) {
							currid = $('.back').attr("id");
							var count = parseInt($('.back').attr("count"));
							var length_li = parseInt($('.search-result ul li').length);						
							if(count != 1)
							{
								$('#'+currid).prev('li').addClass('back');
								$('#'+currid).removeClass('back');
							}
					}
				}
				else if (e.keyCode == '13' ) {
					if( $( ".search-result ul li.search_res" ).is( ".back" ) ) {
							var ceo_id = $(".back").attr('rel');
							var id_li = $(".back").attr('id');
							var dd = $('#'+id_li + ' .search-right-info .one').text();
							$("#receiver_ceo_id").val(ceo_id);
							$(".search-result").remove();
							$(".send_msg_to").val('');
							$(".search_name").html('<span class="btnClass">'+dd+'</span>');
							$("#add_msg").focus();
					}
				}
			}
			
		});
		//$('.notification-requests-main').on('click', 'li .connectionbtn', function() {
		$('.read-messages').on('click','.search_res', function(){
			var ceo_id = $(this).attr('rel');
			var id_li = $(this).attr('id');
			var dd = $('#'+id_li + ' .search-right-info .one').text();
			$("#receiver_ceo_id").val(ceo_id);
			$(".search-result").remove();
			$(".send_msg_to").val('');
			$(".search_name").html('<span class="btnClass">'+dd+'</span>');
			$("#add_msg").focus();
		});
		
		$('.read-messages').on('mouseover','.search_res', function(){
			var id_li = $(this).attr('id');
			if ( $( ".read-messages ul li.search_res" ).is( ".back" ) ) {
				$('.read-messages ul li.search_res').removeClass('back');
				$('.read-messages ul li#'+id_li).addClass('back');
			}
		});
		
		$(".star-rating").click(function(){
			var indexcount = $(this).index();
			$('.rating-sec .star-rating').each(function(index){
				// assign class according to li's index ... index = li number -1: 1-6 = 0-5; 7-12 = 6-11, etc.
				if ( index < indexcount )    {
					$(this).removeClass("fa-star-o");	
					$(this).addClass("fa-star");
				}
				else{
					$(this).addClass("fa-star-o");	
					$(this).removeClass("fa-star");				
				}
			});
			$('#rating').val(indexcount);
		});
		
		$("#rating_form").submit(function(){
			var starval 	= 	$("#rating").val();
			var ratingtxt 	= 	$.trim($("#rating_text").val());
			if(starval == "" || ratingtxt == "" ) {
				$(".rating_error").text("Rating and description cannot be blanked!");
				return false;
			}
		});
		
		
		//change the color of read unread msg of generalnotification
		$(".generalnotification").on('click','.notification-main ul li',function(){
			var log_id = $(this).attr('rel');
			var root = window.location.origin;
			var myString = location.pathname.split("index.php");
			var baseurl = root + myString[0];
			$.ajax({
				url	: baseurl+'index.php/Common/changeNotificationReadUnread',
				type: 'POST',
				data: { log_id : log_id },
				success:function (){}
			})
			
		});
		
		
		//Search on the top header
		$('.searchbox').on('keyup', '#_search', function(e) {
			var ceopic = "";
			var businesslogo = "";
			var ceo_response = "";
			var business_response = "";
			var industry_response = "";
			var proposal_response = "";
			var keyword = $(this).val();
			if(keyword.length > 0 && e.keyCode != 13)
			{
				
				$('.search_result_main').css({"display":"block"});
				var root = window.location.origin;
				var myString = location.pathname.split("index.php");
				var baseurl = root + myString[0];
				$.ajax({
					url	: baseurl+'index.php/Common/searchTopHeader',
					type: 'POST',
					data: { keyword : keyword },
					success:function(a) {
							var data = $.parseJSON(a); 
							if(data != "") {
								if(data['ceos'] != "") {
									$.each( data['ceos'], function( key, value ) {
										if(value.ceo_profile_pic != "") {
											ceopic = baseurl+"uploads/profile/64/"+value.ceo_profile_pic+"";
										} else {
											ceopic = baseurl+"images/user.jpg";
										}
										ceo_response += '<li><i class="coe-img" style="background:url('+ceopic+') no-repeat scroll center center / cover  rgba(0, 0, 0, 0); "></i>';
										ceo_response += '<a href="'+baseurl+'index.php/CompanyProfileUser?ci='+btoa(value.ceo_id)+'&bs='+btoa(value.business_id)+'"><h1>'+value.first_name+' '+value.last_name+'</h1><p>CEO de '+value.business_name+'</p></a></li>';
									});
									$('.search_result_main #ceos ul').html(ceo_response);
								}
								else {
									$('.search_result_main #ceos ul').html('<li><p>No Ceos Found!</p></li>');
								}
								
								if(data['business'] != "") {
									$.each( data['business'], function( key, value ) {
										if(value.logo_url != "") {
											businesslogo = baseurl+"uploads/business/logo/"+value.logo_url+"";
										} else {
											businesslogo = baseurl+"images/demo-logo150x150.jpg";
										}
										business_response += '<li><i><img width="50" alt="" src="'+businesslogo+'"></i>';
										business_response += '<a href="'+baseurl+'index.php/CompanyProfileUser?ci='+btoa(value.ceo_id)+'&bs='+btoa(value.business_id)+'"><h1>'+value.business_name+'</h1><p>CEO '+value.first_name+' '+value.last_name+'</p></a></li>';
									});
									$('.search_result_main #business ul').html(business_response);
								}
								else {						
									$('.search_result_main #business ul').html("<li><p>No Businesses Found!</p></li>");
								}
								
								if(data['industry'] != "") {
									$.each( data['industry'], function( key, value ) {
										industry_response += '<p>'+value.name+'</p>';
									});
									$('.search_result_main #industries .s_Industrias').html(industry_response);
								}
								else {						
									$('.search_result_main #industries .s_Industrias').html("<p>No Industries Found!</p>");
								}
								
								if(data['proposal'] != "") {
									$.each( data['proposal'], function( key, value ) {
										proposal_response += '<p>'+value.title+'</p>';
									});
									$('.search_result_main #proposals .s_Industrias').html(proposal_response);
								}
								else {						
									$('.search_result_main #proposals .s_Industrias').html("<p>No Proposals Found!</p>");
								}
							}
						}
					
				})
			}
			else {
				$('.search_result_main').css({"display":"none"});	
			}
			
		});
		
		
		$('.advance-search').on('click','.result-left-col ul li input[type="radio"]',function(){
			
			var ceopic = "";
			var radioval 	= $.trim($(this).val());
			var current_ceo = $.trim($(this).attr('rel'));
			var root = window.location.origin;
			var myString = location.pathname.split("index.php");
			var baseurl = root + myString[0];
			var ceo_response = "";
			var proposal_response = "";
			var business_response = "";
			var industries_response = "";
			
			$.ajax({
				url	: baseurl+'index.php/AdvanceSearch/AdvanceSearch',
				type: 'POST',
				data: { 
					radioval : radioval, 
					current_ceo : current_ceo 
				},
				success:function(o) {
					
					var obj = $.parseJSON(o);
					
					if(obj['ceos'] != "") {
						ceo_response += '<h1>ALL CEO&apos;S LIST</h1>';
						$.each(obj['ceos'], function( key, value ){
							if(value.ceo_profile_pic != "") {
								ceopic = baseurl+"uploads/profile/64/"+value.ceo_profile_pic+"";
							} else {
								ceopic = baseurl+"images/user.jpg";
							}
							ceo_response += '<div class="ceo-result-row"><i style="background:url('+ceopic+') no-repeat scroll center center / cover  rgba(0, 0, 0, 0); "></i>';
							ceo_response += '<div class="ceo-resul-col"><h6>CEO</h6><h2>'+value.first_name+'</h2>';
							ceo_response += '<h5>CEO de '+value.business_name+'</h5><p>'+value.description+'</p></div></div>';
						})
						$('.advance-search .result-right-col').html(ceo_response);
						
					} else if(obj['proposals'] != ""){
						
						ceo_response += '<h1>ALL PROPOSALS LIST</h1>';
						$.each(obj['proposals'], function( key, value ){
							if(value.ceo_profile_pic != "") {
								ceopic = baseurl+"uploads/profile/64/"+value.ceo_profile_pic+"";
							} else {
								ceopic = baseurl+"images/user.jpg";
							}
							proposal_response += '<div class="ceo-result-row" style="background:url('+baseurl+'uploads/proposal/'+value.background_img_url+') no-repeat scroll center center / cover; border-radius:10px; margin:10px 0;"><i style="background:url('+ceopic+') no-repeat scroll center center / cover  rgba(0, 0, 0, 0); "></i>';
							proposal_response += '<div class="ceo-resul-col"><a href="#" class="proptitle">'+value.title+'</a>';
							proposal_response += '<p>'+value.description+'</p></div></div>';
						})
						$('.advance-search .result-right-col').html(proposal_response);
						
					} else if(obj['businesses'] != "") {
						
						business_response += '<h1>ALL BUSINESSES LIST</h1>';
						$.each(obj['businesses'], function( key, value ){
							if(value.logo_url != "") {
								businesslogo = baseurl+"uploads/business/logo/"+value.logo_url+"";
							} else {
								businesslogo = baseurl+"images/demo-logo150x150.jpg";
							}
							business_response += '<div class="ceo-result-row"><img src="'+businesslogo+'" width="120">';
							business_response += '<div class="ceo-resul-col"><h2>'+value.business_name+'</h2>';
							business_response += '<p>'+value.description+'</p></div></div>';
						})
						$('.advance-search .result-right-col').html(business_response);
						
					} else if(obj['industries'] != "") {
						
						industries_response += '<h1>ALL INDUSTRIES LIST</h1>';
						$.each(obj['industries'], function( key, value ){
							industries_response += '<div class="ceo-result-row"><p class="industries">'+value.name+'</p></div>';
						})
						$('.advance-search .result-right-col').html(industries_response);
						
					} 					
					else{
						$('.advance-search .result-right-col').html("<h1>No Results!</h1>");
					}
					
					
				}
			});
			
		})
		
		
		/* Body load ceo info advance search */
		
		var firstradio = $('.advance-search input[name=search_radio]:checked').val();
		var ceopic = "";
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		var ceo_response = "";
		
		$.ajax({
			url	: baseurl+'index.php/AdvanceSearch/AdvanceSearch',
			type: 'POST',
			data: { 
				radioval : firstradio, 
			},
			success:function(o) {	
				var obj = $.parseJSON(o);
				if(obj['ceos'] != "") {
					ceo_response += '<h1>ALL CEO&apos;S LIST</h1>';
					$.each(obj['ceos'], function( key, value ){
						if(value.ceo_profile_pic != "") {
							ceopic = baseurl+"uploads/profile/64/"+value.ceo_profile_pic+"";
						} else {
							ceopic = baseurl+"images/user.jpg";
						}
						ceo_response += '<div class="ceo-result-row"><i style="background:url('+ceopic+') no-repeat scroll center center / cover  rgba(0, 0, 0, 0); "></i>';
						ceo_response += '<div class="ceo-resul-col"><h6>CEO</h6><h2>'+value.first_name+'</h2>';
						ceo_response += '<h5>CEO de '+value.business_name+'</h5><p>'+value.description+'</p></div></div>';
					})
					$('.advance-search .result-right-col').html(ceo_response);
				}
				else{
						$('.advance-search .result-right-col').html("<h1>No Results!</h1>");
				}				
			}
		});
	
		
		/* $('.slide .slider-rating-row .lunchpopup').hover(function(){
			var lunchpop = "";
			var propid = $(this).attr('pop-id');
			var root = window.location.origin;
			var myString = location.pathname.split("index.php");
			var baseurl = root + myString[0];
			$.ajax({
			url	: baseurl+'index.php/Proposal/getPopupLunchInfo',
			type: 'POST',
			data: { propid : propid },
			success:function(o) {	
					//alert(o);
					var res = $.parseJSON(o);
					if(res != "")
					{
						$.each(res,function(key,value){
							lunchpop += '<li>'+value.first_name+' '+value.last_name+'</li>';
						})
					}
					else {
							lunchpop += '<li>No Lunch!</li>';
					}
					$('.slider-rating-row #infopop'+propid+' ul').html(lunchpop); 
					$('.slider-rating-row .infopop').css({"display":"block"}); 
					
				}
			})
		});
		
		$('.slider-rating-row').mouseout(function(){
			$('.infopop').css({"display":"none"});
		}); */
		
		/* $('.slide .slider-rating-row .followbtn').hover(function(){
			
			var followpop = "";
			var propid = $(this).attr('pop-id');
			var root = window.location.origin;
			var myString = location.pathname.split("index.php");
			var baseurl = root + myString[0];
			$.ajax({
			url	: baseurl+'index.php/Proposal/getPopupFollowInfo',
			type: 'POST',
			data: { propid : propid },
			success:function(o) {	
					var res = $.parseJSON(o);
					if(res != "")
					{
						$.each(res,function(key,value){
							followpop += '<li>'+value.first_name+' '+value.last_name+'</li>';
						})
					}
					else {
							followpop += '<li>No Follows!</li>';
					}
					$('.slider-rating-row #followpop'+propid+' ul').html(followpop); 
					$('.slider-rating-row .followpop').css({"display":"block"}); 
					
				}
			})
		});
		
		$('.slider-rating-row').mouseout(function(){
			$('.infopop').css({"display":"none"});
			$('.followpop').css({"display":"none"});
		}); */
		
		
		$('.Propuesta-detail-row .sidebar-user .ceo_profile_pic').mouseover(function(){
			
			$('.Propuesta-detail-row .ceo_info').css({"display":"block"});
			
		})
		
		$('.Propuesta-detail-row .sidebar-user .ceo_profile_pic').mouseout(function(){
			
			$('.Propuesta-detail-row .ceo_info').css({"display":"none"});
			
		}) 
		
});

	function feedlunchpropshow(propid){
		var lunchpop = "";
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		
		$.ajax({
			url	: baseurl+'index.php/Proposal/getPopupLunchInfo',
			type: 'POST',
			data: { propid : propid },
			success:function(o) {
				var res = $.parseJSON(o);
				if(res != "")
				{
					$.each(res,function(key,value){
						lunchpop += '<li>'+value.first_name+' '+value.last_name+'</li>';
					})
				}
				else {
						lunchpop += '<li>No Lunch!</li>';
				}
				$('#lu'+propid+' ul').html(lunchpop);
				$('#lu'+propid).css({"display":"block"});
			}
		
		});
	}
	
	function feedlunchprophide(propid){
		$('#lu'+propid).css({"display":"none"});
	}
	
	function feedfollowpropshow(propid) {
		var followpop = "";
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
			url	: baseurl+'index.php/Proposal/getPopupFollowInfo',
			type: 'POST',
			data: { propid : propid },
			success:function(o) {
				var res = $.parseJSON(o);
				if(res != "")
				{
					$.each(res,function(key,value){
						followpop += '<li>'+value.first_name+' '+value.last_name+'</li>';
					})
				}
				else {
						followpop += '<li>No Follows!</li>';
				}
				$('#fo'+propid+' ul').html(followpop);
				$('#fo'+propid).css({"display":"block"});
			}
		});
	}
	
	function feedfollowprophide(propid){
		$('#fo'+propid).css({"display":"none"});
	}
	
	function proposalbgURL(input) {
		$(".error_upload").text("");
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#proposal-bg-container").css({"background-image": "url(" + e.target.result + ")", 'background-size': 'cover', 'background-repeat': 'no-repeat'});
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	/*----Resize textarea----*/
	function autoGrow (oField) {
		alert(oField);
		if (oField.scrollHeight > oField.clientHeight) {
		oField.style.height = oField.scrollHeight + "px";
		}
	}
	
	/*-------- Functions for Date formation --------------*/
	
	//msgtime
	function MessageLogTime(a){
		var t = a.split(/[- :]/);
		var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
		return d;
	}
	
	// less then 24 hours time format message
	function getTimeAMPM(date){
		var hours = date.getHours();
		var minutes = date.getMinutes();
		var ampm = hours >= 12 ? 'pm' : 'am';
		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'
		minutes = minutes < 10 ? '0'+minutes : minutes;
		var strTime = hours + ':' + minutes + ' ' + ampm;
		return strTime;
	}
	
	//get Hours Difference between two dates
	function getDiffTime(date){
		//current date
		var cc = new Date();
		var mili = parseInt(cc.getTime() - date.getTime());
		//difference between current and msgtime in hours
		var numhours = Math.floor(((mili % 31536000) % 86400) / 3600);
		return numhours;
	}
	
	
	// date and month get for greater then 24 hours
	function getDayMonth(date){
		var monthss = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var datess = monthss[date.getMonth()] + " " + date.getDate();
		return datess;
	}
	
	
	//
	function relative_time(date_str) {
		if (!date_str) {return;}
		date_str = $.trim(date_str);
		date_str = date_str.replace(/\.\d\d\d+/,""); // remove the milliseconds
		date_str = date_str.replace(/-/,"/").replace(/-/,"/"); //substitute - with /
		date_str = date_str.replace(/T/," ").replace(/Z/," UTC"); //remove T and substitute Z with UTC
		date_str = date_str.replace(/([\+\-]\d\d)\:?(\d\d)/," $1$2"); // +08:00 -> +0800
		var parsed_date = new Date(date_str);
		var relative_to = (arguments.length > 1) ? arguments[1] : new Date(); //defines relative to what ..default is now
		var delta = parseInt((relative_to.getTime()-parsed_date)/1000);
		delta=(delta<2)?2:delta;
		var r = '';
		if (delta < 60) {
		r = delta + ' seconds ago';
		} else if(delta < 120) {
		r = 'a minute ago';
		} else if(delta < (45*60)) {
		r = (parseInt(delta / 60, 10)).toString() + ' minutes ago';
		} else if(delta < (2*60*60)) {
		r = 'an hour ago';
		} else if(delta < (24*60*60)) {
		r = '' + (parseInt(delta / 3600, 10)).toString() + ' hours ago';
		} else if(delta < (48*60*60)) {
		r = 'a day ago';
		} else {
		r = (parseInt(delta / 86400, 10)).toString() + ' days ago';
		}
		return 'about ' + r;
	};
	
	
	
	
	
	
	function lunchpopupshow(popid){
		var lunchpop = "";
		var propid = $(popid).attr('pop-id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
		url	: baseurl+'index.php/Proposal/getPopupLunchInfo',
		type: 'POST',
		data: { propid : propid },
		success:function(o) {	
				//alert(o);
				var res = $.parseJSON(o);
				if(res != "")
				{
					$.each(res,function(key,value){
						lunchpop += '<li>'+value.first_name+' '+value.last_name+'</li>';
					})
				}
				else {
						lunchpop += '<li>No Lunch!</li>';
				}
				$('.slider-rating-row #infopop'+propid+' ul').html(lunchpop); 
				$('.slider-rating-row .infopop').css({"display":"block"}); 
				
			}
		})
	}

	function lunchpopuphide(){
		$('.infopop').css({"display":"none"});
	}

	function followpopupshow(popid){
		var followpop = "";
		var propid = $(popid).attr('pop-id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
		url	: baseurl+'index.php/Proposal/getPopupFollowInfo',
		type: 'POST',
		data: { propid : propid },
		success:function(o) {	
				var res = $.parseJSON(o);
				if(res != "")
				{
					$.each(res,function(key,value){
						followpop += '<li>'+value.first_name+' '+value.last_name+'</li>';
					})
				}
				else {
						followpop += '<li>No Follows!</li>';
				}
				$('.slider-rating-row #followpop'+propid+' ul').html(followpop); 
				$('.slider-rating-row .followpop').css({"display":"block"}); 
				
			}
		})
	}

	function followpopuphide(){
		$('.followpop').css({"display":"none"});
		//alert('followhide');
	}
	
	
	function detailproposallunchpopupshow(popid){
		var lunchpop = "";
		var propid = $(popid).attr('prop-id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
		url	: baseurl+'index.php/Proposal/getPopupLunchInfo',
		type: 'POST',
		data: { propid : propid },
		success:function(o) {	
			
				var res = $.parseJSON(o);
				if(res != "")
				{
					$.each(res,function(key,value){
						lunchpop += '<li>'+value.first_name+' '+value.last_name+'</li>';
					})
				}
				else {
						lunchpop += '<li>No Lunch!</li>';
				}
				$('.fullpropdetail ul').html(lunchpop); 
				$(".fullpropdetail").css({"display":"block"});
				
			}
		})
		
	}
	
	function detailproposallunchpopuphide(popid){
		$(".fullpropdetail").css({"display":"none"});
	}
	
	
	function detailproposalfollowpopupshow(popid){
		var followpop = "";
		var propid = $(popid).attr('prop-id');
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$.ajax({
		url	: baseurl+'index.php/Proposal/getPopupFollowInfo',
		type: 'POST',
		data: { propid : propid },
		success:function(o) {
				
				var res = $.parseJSON(o);
				if(res != "")
				{
					$.each(res,function(key,value){
						followpop += '<li>'+value.first_name+' '+value.last_name+'</li>';
					})
				}
				else {
						followpop += '<li>No Follows!</li>';
				}
				$('.fullpropdetailfollow ul').html(followpop); 
				$('.fullpropdetailfollow').css({"display":"block"}); 
			}
		})
	
	}
	
	function detailproposalfollowpopuphide(popid){
		$(".fullpropdetailfollow").css({"display":"none"});
	}
	




