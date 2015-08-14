<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$userdata = $this->session->userdata('UserData');
$UserData = json_decode($userdata,true);
?>
<script>
$(document).ready(function(){	
	//get message listStyleType
	if ( $( ".scrollconnection ul li.message_li" ).is( ".ceoactive" ) ) {
		var id_li 		=  	$('.ceoactive').attr('id');
		var ceo_id 		= 	$('.ceoactive').attr('ceo-id');
		var response 	= 	"";
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$("#receiver_ceo_id").val(ceo_id);
		$(".read-messages").addClass('msg-loader');
		$.ajax({
			type:'POST',
			datatype:'json',
			url:baseurl+'index.php/Messages/getmessageslist',
			data: { ceo_id : ceo_id },
			success:function(data){
				$(".read-messages").removeClass('msg-loader');
				$('.scrollconnection ul li').removeClass('ceoactive');
				$('.scrollconnection ul li#'+id_li).addClass('ceoactive');
				var obj = $.parseJSON(data);
				if(obj != "")
				{
					$.each( obj, function( key, value ) {
						
						var FinalTimeMsg = "";
									
						var msgtime = value.msglogtime;		
						
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
						else{
							img = baseurl+'uploads/profile/64/'+value.ceo_profile_pic;
						}
						response += '<div class="area" id="msg'+value.msgid+'">';
						response += '<div class="pic-area"><i style="background:url('+img+')"></i></div>';
						response += '<div class="message-area">';
						response += '<span class="sender-name">'+value.first_name+' '+value.last_name+'</span>';
						response += '<span class="message-date">'+FinalTimeMsg+'</span>';
						response += '<p class="msg">'+value.message+'</p></div></div>';
					});
				}
				else{
					response += '<div class="area"><h1 style="color:#ddd; text-align:center"> NO Messages!!</h1></div>';
				}
					$('.messages-wrapper .read-messages').html(response);
			}
		});
	}
	$(".scrollconnection ul").on('click','.message_li', function(){
		var id_li = $(this).attr('id');
		var ceo_id = $(this).attr('ceo-id');
		$("#receiver_ceo_id").val(ceo_id);
		var response = "";
		var root = window.location.origin;
		var myString = location.pathname.split("index.php");
		var baseurl = root + myString[0];
		$(".read-messages").addClass('msg-loader');
		$.ajax({
			type:'POST',
			datatype:'json',
			url:baseurl+'index.php/Messages/getmessageslist',
			data: { ceo_id : ceo_id },
			success:function(data){
				$(".read-messages").removeClass('msg-loader');
				$('.scrollconnection ul li').removeClass('ceoactive');
				$('.scrollconnection ul li#'+id_li).addClass('ceoactive');
				var obj = $.parseJSON(data);
				if(obj != "")
				{
					$.each( obj, function( key, value ) {
						
						var FinalTimeMsg = "";
									
						var msgtime = value.msglogtime;		
						
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
						else{
							img = baseurl+'uploads/profile/64/'+value.ceo_profile_pic;
						}
						response += '<div class="area" id="'+value.msgid+'">';
						response += '<div class="pic-area"><i style="background:url('+img+')"></i></div>';
						response += '<div class="message-area">';
						response += '<span class="sender-name">'+value.first_name+' '+value.last_name+'</span>';
						response += '<span class="message-date">'+FinalTimeMsg+'</span>';
						response += '<p class="msg">'+value.message+'</p></div></div>';
						
					});
				}
				else{
					response += '<div class="area"><h1 style="color:#ddd; text-align:center"> NO Messages!!</h1></div>';
				}
					$('.messages-wrapper .read-messages').html(response);
			}
		});
	})

});
</script>
<?php 
/* echo "<pre>";
print_r($connections);
echo "</pre>"; */
?>
<!-- Wrapper for Slides -->
<section class="detail-edit-row message-main-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 Detalles-left-col">
        <div class="Propuesta-detail-row message-left">
			<h2>Mensajes</h2>
			<div class="scrollconnection">
			<ul>
				<?php if( !empty( $connections ) ) { ?>
				<?php $c=1; foreach( $connections as $con ) : ?>
					<li class="<?php if(!empty($_GET['c_id'] ) && ( $con->msg_ceos_id == base64_decode($_GET['c_id']) ) || (empty($_GET['c_id']) && ($c == 1) )) { ?>ceoactive<?php } ?> message_li" id="mes<?php echo $con->msg_ceos_id; ?>" ceo-id="<?php echo $con->msg_ceos_id; ?>">
						<?php 
							$actual_date = date("dS M Y", strtotime($con->message_logtime)); 
							$time_am_pm = date("h:i A", strtotime($con->message_logtime)); 
							$onlydate = date("M d", strtotime($con->message_logtime)); 
							$propdate = $con->message_logtime;
							$currentdate = date("Y-m-d H:i:s");
							$t1 = StrToTime ( $currentdate );
							$t2 = StrToTime ( $propdate );
							$diff = $t1 - $t2;
							$hours = $diff / ( 60 * 60 );
						?>
						<?php if($hours < 24) { ?><p class ="time-right"><?php echo $time_am_pm; ?></p><?php } ?>
						<?php if($hours > 24 && $hours < 720) { ?><p class="time-right"><?php echo $onlydate; ?></p><?php } ?> 
						<?php if($hours > 720) { ?><p class="time-right"><?php echo $onlydate; ?></p><?php } ?> 
						
						
						<span class="picture_left_small">
							<i style="background:url('<?php if(!empty($con->ceo_profile_pic)) { echo base_url() ?>uploads/profile/64/<?php echo $con->ceo_profile_pic; } else { echo base_url() ?>images/user64x64.jpg<?php } ?>')"></i>
						</span>
						<div class="picture_right">
						<span class="picture_right_name"><?php echo $con->first_name .' '. $con->last_name; ?></span>
						<span class="picture_right_secondname"><?php echo $con->message; ?></span>
						</div>
					</li>
				<?php $c++; endforeach; } ?>
			</ul>
			</div>
        </div>
      </div>
      <div class="col-sm-9 sidebar-col">
        <div class="Propuesta-detail-row messages-content">
		<h2>Nombre Apellido - CEO Empresa	<a href="javascript:void(0);" class="newmsg">New Message</a></h2>
			<div class="messages-wrapper <?php if(!empty($_GET['c_id'] ) && ( $con->msg_ceos_id == base64_decode($_GET['c_id']) ) || (empty($_GET['c_id']) )) { ?>messages-wrapper-active<?php } ?>">
			
				<!-- Div for display messages -->
					<div class="read-messages">
					
					
					</div>
				<!-- Close -->
				
				<div class="col-sm-9 write-message">
					  <?php 	$attributes = array( 
							'name' 		=>	"savemessage",
							'id' 		=>	"savemessage",
							'enctype'	=>	"multipart/form-data"
						);
					echo form_open('Messages/MessageSave', $attributes); ?>
					<input type="hidden" name="current_ceo_id" id="current_ceo_id" value="<?php echo $UserData[0]['id']; ?>" />
					<input type="hidden" name="receiver_ceo_id" id="receiver_ceo_id" value="" />
					<textarea name="add_msg" id="add_msg" placeholder="Escribe una respuesta......"></textarea>
					<?php form_close(); ?>
				</div>
			</div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--section start here-->
