$(function(){
	
	$('#industry_tag_edit').keypress(function(){
		if($('.ind_err_edit').is(':visible')){
			$('.ind_err_edit').css({"display":"none"});
		}
	}) 
	
	$("#edit_profile_form").bind("keypress", function (e) {
		if (e.keyCode == 13) {
			var ccd = jQuery("#industry_tag_edit").val();
			if(ccd != "") {
				$('.in-loader').css({"display":"block"});
				var checkvalindus = CheckIndustyEditExistDB(ccd, 'checkindustry');
				if(checkvalindus == 1){
					var cccd = checkInputValEdit(ccd);
					if(cccd == 1){
						$('.in-loader').css({"display":"none"});
						$("#industry_tag_edit").val("");
						$('.ind_err_edit').text("You have already added this industry!").css({"display":"block"});
						
					}
					else
					{
						$('.in-loader').css({"display":"none"});
						$(".add-tags-edit").append("<span class='appendspan'><input type='hidden' name='edit_tag_value[]' value='"+ccd+"' />"+ccd+"<img class='delete' src='../../images/1433172107_close.png'></span>");
						$("#industry_tag_edit").val("");
						
					} 
				}
				else{
					$("#industry_tag_edit").val("");
					$('.ind_err_edit').css({"display":"block"});
				}	
			}
		}
	});		
	
	
	$(".editAnadir").click(function(){
		var ccd = jQuery("#industry_tag_edit").val();
		if(ccd != "") {
			$('.in-loader').css({"display":"block"});
			var checkvalindus = CheckIndustyEditExistDB(ccd, 'checkindustry');
			if(checkvalindus == 1){
				var cccd = checkInputValEdit(ccd);
				if(cccd == 1){
					$("#industry_tag_edit").val("");
					$('.ind_err_edit').text("You have already added this industry!").css({"display":"block"});
					$('.in-loader').css({"display":"none"});
				}
				else
				{
					$(".add-tags-edit").append("<span class='appendspan'><input type='hidden' name='edit_tag_value[]' value='"+ccd+"' />"+ccd+"<img class='delete' src='../../images/1433172107_close.png'></span>");
					$("#industry_tag_edit").val("");
					$('.in-loader').css({"display":"none"});
				} 
			}
			else{
				$("#industry_tag_edit").val("");
				$('.ind_err_edit').css({"display":"block"});
			}	
		}
		
		$("body").on("click", ".delete", function () {
			$(this).parent("span").remove();
		});
	})
	
	$("#industry_tag_edit").focus(function () {
		$(".ind_err_edit").css({"display":"none"});
	});
	
	//Edit Profile Page Validation
	$("#edit_profile_form").submit(function(){
		
		var flag = true;
		var baseurl 					= 	$.trim($("#baseurl").val());
		var business_id 				= 	$.trim($("#business_id").val());
		var ceo_id 						= 	$.trim($("#ceo_id").val());
		var edit_first_name 			= 	$.trim($("#edit_first_name").val());
		var edit_nickname 				= 	$.trim($("#edit_nickname").val());
		var edit_last_name 				= 	$.trim($("#edit_last_name").val());
		var edit_linkedin 				= 	$.trim($("#edit_linkedin2").val());
		var edit_password 				= 	$.trim($("#edit_password").val());
		var edit_confirm_password 		= 	$.trim($("#edit_confirm_password").val());
		var edit_useremail 				= 	$.trim($("#edit_useremail").val());
		var edit_business_name 			= 	$.trim($("#edit_business_name").val());
		var edit_cuit 					= 	$.trim($("#edit_cuit").val());
		var edit_website_url 			= 	$.trim($("#edit_website_url").val());
		var edit_business_description 	= 	$.trim($("#edit_business_description").val());
		
		if ($('.add-tags-edit').find('.appendspan').length == 0) { 
			$(".Industrias-Relacionadas-row").css({"border":"1px solid red"});
			flag = false;
		}
		
		if( edit_first_name == "" )
		{
			$("#edit_first_name").css({"border":"1px solid red"});
			flag = false;
		}
		if( edit_nickname == "" )
		{
			$("#edit_nickname").css({"border":"1px solid red"});
			flag = false;
		}
		
		if( edit_last_name == "" )
		{
			$("#edit_last_name").css({"border":"1px solid red"});
			flag = false;
		}
		
		if ( edit_password != "" ){
			
			var regularExpression  = /^(?=.*[0-9])(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*]{8,}$/;
			
			if(!regularExpression.test(edit_password)) 
			{
				$("#edit_password").css({"border":"1px solid red"});
				$(".errpss").text("Password should contain 8 alphanumeric letters with atleast 1 Capital letter character!").css({"display":"block"});
				flag = false;
			}

			else if ( edit_confirm_password == "" )
			{
				$("#edit_confirm_password").css({"border":"1px solid red"});
				$(".errpss").text("Confirm password must be filled!").css({"display":"block"});
				flag = false;
			}
			else if(edit_confirm_password != edit_password)
			{
				$("#edit_confirm_password").css({"border":"1px solid red"});
				$(".errpss").text("Password Does Not Match!").css({"display":"block"});
				flag = false;
			}
		}
		
		if( edit_useremail == "" )
		{
			$("#edit_useremail").css({"border":"1px solid red"});
			flag = false;	
		}
		else{
		
			var ress = CheckValExistDBCUIT(edit_useremail,'checkingemail',ceo_id);
			if(ress == 1){ 
				$(".edit_email_error").css({"display":"block"});
				$("#edit_useremail").css({"border":"1px solid red"});
				flag = false;	
			}
			else{
				$(".edit_email_error").css({"display":"none"});
				$("#edit_useremail").css({"border":"1px solid #e5ecef"});
			}
			
		}
		
		if( edit_business_name == "" )
		{
			$("#edit_business_name").css({"border":"1px solid red"});
			flag = false;
		}
		
		
		if( edit_cuit == "" )
		{
			$("#edit_cuit").css({"border":"1px solid red"});
			flag = false;
		}
		else{
			var resss = CheckValExistDBCUIT(edit_cuit,'checkingcuit',business_id);
			if(resss == 1){ 
				$(".edit_cuit_error").css({"display":"block"});
				$("#edit_cuit").css({"border":"1px solid red"});
				flag = false;	
			}
		}
		
		if( edit_website_url == "" )
		{
			$("#edit_website_url").css({"border":"1px solid red"});
			flag = false;
		}
		
		if( edit_business_description == "" )
		{
			$("#edit_business_description").css({"border":"1px solid red"});
			flag = false;
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

//////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	$( "#industry_tag_edit" ).focus(function() {
		$(".Industrias-Relacionadas-row").css({"border":"1px solid #f0f0f0"});
	});
	
	$(".get_edit_error").mouseup(function(){
		$(".second").text("");
		var inputID = $(this).attr('id');
		$("#"+inputID).css({"border":"1px solid #e5ecef"});
	});
	
	$(".get_edit_error").keyup(function(){
		$(".second").text("");
		var inputID = $(this).attr('id');
		$("#"+inputID).css({"border":"1px solid #e5ecef"});
		$(this).next("span").css({"display":"none"});
	});
	
	$("#edit_password").keyup(function(){
		if ($('.errpss').is(':visible')) { 	
			$(".errpss").css({"display":"none"});
		}
	});
	
	$("#edit_password").mouseup(function(){
		if ($('.errpss').is(':visible')) { 	
			$(".errpss").css({"display":"none"});
		}
	});
	
	$("#edit_cuit").mouseup(function(){
		if ($('.edit_cuit_error').is(':visible')) { 	
			$(".edit_cuit_error").css({"display":"none"});
		}
	});
	
	$("#edit_cuit").keyup(function(){
		if ($('.edit_cuit_error').is(':visible')) { 	
			$(".edit_cuit_error").css({"display":"none"});
		}
	});
	
	$("#edit_useremail").mouseup(function(){
		if ($('.edit_email_error').is(':visible')) { 	
			$(".edit_email_error").css({"display":"none"});
		}
	});
	
	$("#edit_linkedin2").blur(function(){
		var edit_linkedin2 = 	$.trim($("#edit_linkedin2").val());
		
		if(edit_linkedin2 != "") {
			$("#edit_linkedin2").val(edit_linkedin2);
		}
	})
	
	$("#edit_useremail").keyup(function(){
		if ($('.edit_email_error').is(':visible')) { 	
			$(".edit_email_error").css({"display":"none"});
		}
	});
	
	$(".remove_pic").click(function(){
		var ceo_id = $(this).attr('id');
		var pic = $(this).attr('rel');
		var result;
		var jqXHR = $.ajax({
				url:'DeleteProfilePic',
				type:'POST',
				async: false,
				data:{  ceo_id : ceo_id, pic : pic, status : 'delete' },
			})
		window.location.reload();
	})
	

/////////////////////////////////////////////////////////////////////////////////////////////////////
});	

function CheckValExistDBCUIT(em,status,id){
	var result;
	var jqXHR = $.ajax({
						url:'check_if_Exist_Edit_Profile',
						type:'POST',
						async: false,
						data:{  inputval : em, action : status, id : id },
					})
	return jqXHR.responseText;
}  
	
	
	function edit_readURL(input) {
		$(".error_upload").text("");
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#edit_preview').attr('src', e.target.result);
				$("#edit-upload-file-container").css({"background":"none","overflow":"hidden"});
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function bg_business_readURL(input) {
		$(".error_upload_bg").text("");
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#big-preview').attr('src', e.target.result);
				$("#edit-bg-image").css({"background":"none","overflow":"hidden"});
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function profile_pic_readURL(input) {
		$(".remove_pic").css({"display":"none"});
		$(".error_upload_profile_pic").text("");
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#profile_pic_img').attr('src', e.target.result);
				$("#upload-profile-pic").css({"background":"none","overflow":"hidden"});
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	
//for auto correct the Website URL in edit profile page	
	function EditcheckURLvalid (abc) {
		var string = abc.value;
		if(string != ""){
			var str = string;
			var ab = str.indexOf("www");
			if(ab == -1) {
				var ts = str.indexOf("http://");
				if(ts == -1) {
					var cc = str.indexOf("https://");
					if(cc == -1)
					{
						str = "http://www." + str;
					}
					else{
						var ee = str.replace("https://","");
						str = "https://www." + ee;
					}
				}
				else {
					var dd = str.replace("http://","");
					str = "http://www." + dd;
				}
				//var res = str.substring(0, ab);
			} else {
				var res = str.substring(0, ab);
				if(res == ""){
					str = "http://" + str;
				}
			}
			abc.value = str;
		}
	}	
	 
	function CheckIndustyEditExistDB(industryname,status){
		var result;
		var jqXHR = $.ajax({
			url:'CheckIndustryExist',
			type:'POST',
			async: false,
			data:{  inputval : industryname, action : status },
		})
		return jqXHR.responseText;
	} 

	function hasWhiteSpaceEdit(s) {
	  var check = "";
	  if(s.indexOf(' ') >= 0){
		  return check = s.replace(/\s/g, "");
	  }
	  else{
		  return check = s;
	  }
	 
	}
	
	function checkInputValEdit(tag){
		var msg = "";
		var two = "";
		$( ".appendspan input" ).each(function( ) {
			if($(this).val() != "")
			{
				two = $(this).val();
				if(two == tag)	{
					msg = 1;
				}
			}
		});
		return msg;
	}

	


