$(function(){
	$('#industry_tag').keypress(function(){
		if($('.ind_err').is(':visible')){
			$('.ind_err').css({"display":"none"});
		}
	})
	//when the Add Field button is clicked
	
	$("#industry_tag").bind("keypress", function (e) {
		if (e.keyCode == 13) {
			var tag = jQuery("#industry_tag").val();
			if(tag != "") {
				$('.in-loader-class').css({"display":"block"});
				var checkvalindus = CheckIndustyExistDB(tag, 'checkindustry');
				if(checkvalindus == 1){
					var cec = checkInputVal(tag);
					if(cec == 1)
					{
						$('.in-loader-class').css({"display":"none"});
						$("#industry_tag").val("");
						$('.ind_err').text("You have already added this industry!").css({"display":"block"});
					}
					else{
						$('.in-loader-class').css({"display":"none"});
						$(".add-tags").append("<span class='appendspan'><input type='hidden' name='tag_value[]' value='"+tag+"' />"+tag+"<img class='delete' src='../../images/1433172107_close.png'></span>");
						$("#industry_tag").val("");
					}
				}
				else{
					$('.in-loader-class').css({"display":"none"});
					$("#industry_tag").val("");
					$('.ind_err').css({"display":"block"});
				}			
			} 
		}
	});
	
	
	$(".Anadir").click(function () {
		//Append a new row of code to the &quot;#items&quot; div
		var tag = jQuery("#industry_tag").val();
		if(tag != "") {
			$('.in-loader-class').css({"display":"block"});
			var checkvalindus = CheckIndustyExistDB(tag, 'checkindustry');
			if(checkvalindus == 1){
				var cec = checkInputVal(tag);
				if(cec == 1)
				{
					$('.in-loader-class').css({"display":"none"});
					$("#industry_tag").val("");
					$('.ind_err').text("You have already added this industry!").css({"display":"block"});
				}
				else{
					$('.in-loader-class').css({"display":"none"});
					$(".add-tags").append("<span class='appendspan'><input type='hidden' name='tag_value[]' value='"+tag+"' />"+tag+"<img class='delete' src='../../images/1433172107_close.png'></span>");
					$("#industry_tag").val("");
				}
			}
			else{
				$("#industry_tag").val("");
				$('.ind_err').css({"display":"block"});
				$('.in-loader-class').css({"display":"none"});
			}			
		}
	});
		
	$("body").on("click", ".delete", function () {
		$(this).parent("span").remove();
	});
	
	$("#industry_tag").focus(function () {
		$(".ind_err").css({"display":"none"});
	});
	
	
/////////////////////////////////////LOGIN FORM SUBMITTION///////////////////////////////////////////////////////	

	//Login Form Script
	$("#login_form").submit(function(){
		var loginusername = $.trim($("#Input_Login_Username").val());
		var loginpassword = $("#Input_Login_Password").val();
		var baseurl = $("#baseurl").val();
		if( loginusername == null || loginusername == "" || loginpassword == null || loginpassword == "" )
		{ 
			$(".warning").text('Please enter all fields!');
			$(".warning").show();
		}
		else {
			$(".warning").hide();
			$.ajax({
				type: "POST",
				url: baseurl+"index.php/Login/checkLogin",
				data: {
					login_username: loginusername, 
					login_password: loginpassword, 
				},
				success: function(a){
					if( a == "" || a == null )
					{
						$(".warning").text('Incorrect Login Details!');
						$(".warning").show();
						return false;
					}
					else 
					{
						window.location.href = baseurl+"index.php/Feed";
					}
				}
			});
		} 
		
		return false;
		
	})
	
////////////////////////////////////////END LOGIN FORM SUBMITTION///////////////////////////////////////////////////////

/////////////////////////////////////REGISTRATION FORM SUBMITTION///////////////////////////////////////////////////////	
	
	//Registration Form Submittion
	$("#registration_form").submit(function(){
		var flag = true;
		
		var baseurl 			= 	$.trim($("#baseurl").val());
		var register_name 		= 	$.trim($("#RegisterName").val());
		var RegisterSurname 	= 	$.trim($("#RegisterSurname").val());
		var RegisterEmail 		= 	$.trim($("#RegisterEmail").val());
		var RegisterLinkedinUrl = 	$.trim($("#RegisterLinkedinUrl2").val());
		var RegisterPassword 	= 	$.trim($("#RegisterPassword").val());
		var RegisterNickname 	= 	$.trim($("#RegisterNickname").val());
		var vistage_group_id 	= 	$.trim($("#vistage_group_id").val());
		var business_name 		= 	$.trim($("#business_name").val());
		var CUIT 				= 	$.trim($("#CUIT").val());
		//var business_logo 		= 	$.trim($("#business_logo").val());
		var website_url 		= 	$.trim($("#website_url").val());
		var RegBusinessDescription = $.trim($("#RegBusinessDescription").val());
		
		
		if ($('.add-tags').find('input').length == 0) { 
			$(".Industrias-Relacionadas-row").css({"border":"1px solid red"});
			flag = false;
		}
		
		if( register_name == "" )
		{
			$("#RegisterName").css({"border":"1px solid red"});
			$(".RegisterName img").attr('src',baseurl+'/images/no.png');
			$("#RegisterName").next("span").css({"display":"block"});
			flag = false;
		}
		else{
			$("#RegisterName").css({"border":"1px solid green"});
			$(".RegisterName img").attr('src',baseurl+'/images/yes.png');
			$("#RegisterName").next("span").css({"display":"block"});
		}
		
		if( RegisterSurname == "" )
		{
			$("#RegisterSurname").css({"border":"1px solid red"});
			$(".RegisterSurname img").attr('src',baseurl+'/images/no.png');
			$("#RegisterSurname").next("span").css({"display":"block"});
			flag = false;
		}
		else{
			$("#RegisterSurname").css({"border":"1px solid green"});
			$(".RegisterSurname img").attr('src',baseurl+'/images/yes.png');
			$("#RegisterSurname").next("span").css({"display":"block"});
		}
		
		if( RegisterEmail == "" )
		{
			$("#RegisterEmail").css({"border":"1px solid red"});
			$(".RegisterEmail img").attr('src',baseurl+'/images/no.png');
			$("#RegisterEmail").next("span").css({"display":"block"});
			flag = false;
		}
		else{
			var res = CheckValExistDB(RegisterEmail,'checkingemail');
			if(res == 1){ 
			
				$(".email_error").css({"display":"block"});
				$("#RegisterEmail").css({"border":"1px solid red"});
				$(".RegisterEmail img").attr('src',baseurl+'/images/no.png');
				$("#RegisterEmail").next("span").css({"display":"block"});
				flag = false;	
			}else
			{
				$(".email_error").css({"display":"none"});
				$("#RegisterEmail").css({"border":"1px solid green"});
				$(".RegisterEmail img").attr('src',baseurl+'/images/yes.png');
				$("#RegisterEmail").next("span").css({"display":"block"});
			}
		}
		
		if( RegisterPassword == "" )
		{
			$("#RegisterPassword").css({"border":"1px solid red"});
			$(".RegisterPassword img").attr('src',baseurl+'/images/no.png');
			$("#RegisterPassword").next("span").css({"display":"block"});
			flag = false;
		}
		else
		{
			var regularExpression  = /^(?=.*[0-9])(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*]{8,}$/;
			if(!regularExpression.test(RegisterPassword)) 
			{
				$("#RegisterPassword").css({"border":"1px solid red"});
				$(".RegisterPassword img").attr('src',baseurl+'/images/no.png');
				$("#RegisterPassword").next("span").css({"display":"block"});
				$(".pas_error").css({"display":"block"});
				flag = false;
			}
			else{
				$("#RegisterPassword").css({"border":"1px solid green"});
				$(".RegisterPassword img").attr('src',baseurl+'/images/yes.png');
				$("#RegisterPassword").next("span").css({"display":"block"});
				$(".pas_error").css({"display":"none"});
			}			
		}
		
		if(  RegisterNickname == "" )
		{
			$("#RegisterNickname").css({"border":"1px solid red"});
			$(".RegisterNickname img").attr('src',baseurl+'/images/no.png');
			$("#RegisterNickname").next("span").css({"display":"block"});
			flag = false;
		}
		else
		{
			$("#RegisterNickname").css({"border":"1px solid green"});
			$(".RegisterNickname img").attr('src',baseurl+'/images/yes.png');
			$("#RegisterNickname").next("span").css({"display":"block"});
		}
		
		if(  vistage_group_id == "" )
		{
			$("#vistage_group_id").css({"border":"1px solid red"});
			flag = false;
		}
		else{
			$("#vistage_group_id").css({"border":"1px solid green"});
		}
		
		/* if( business_logo == "" )
		{
			$(".error_upload").text("Please upload logo").css({"color":"red","font-style":"italic","position":"relative","top":"-20px"});
			flag = false;
		}
		else 
		{
			$(".error_upload").text("");
		} */
		
		
		if( business_name == "" )
		{
			$("#business_name").css({"border":"1px solid red"});
			$(".business_name img").attr('src',baseurl+'/images/no.png');
			$("#business_name").next("span").css({"display":"block"});
			flag = false;
		}
		else
		{
			$("#business_name").css({"border":"1px solid green"});
			$(".business_name img").attr('src',baseurl+'/images/yes.png');
			$("#business_name").next("span").css({"display":"block"});
		}
		
		if( CUIT == "" )
		{
			$("#CUIT").css({"border":"1px solid red"});
			$(".CUIT img").attr('src',baseurl+'/images/no.png');
			$("#CUIT").next("span").css({"display":"block"});
			flag = false;
		}
		else{
			var ress = CheckValExistDB(CUIT,'checkingcuit');
			if(ress == 1){ 
				$(".cuit_error").css({"display":"block"});
				$("#CUIT").css({"border":"1px solid red"});
				$(".CUIT img").attr('src',baseurl+'/images/no.png');
				$("#CUIT").next("span").css({"display":"block"});
				flag = false;	
			}
			else{
				$(".cuit_error").css({"display":"none"});
				$("#CUIT").css({"border":"1px solid green"});
				$(".CUIT img").attr('src',baseurl+'/images/yes.png');
				$("#CUIT").next("span").css({"display":"block"});
			}
		}
		
		
		if( website_url == "" )
		{
			$("#website_url").css({"border":"1px solid red"});
			$(".website_url img").attr('src',baseurl+'/images/no.png');
			$("#website_url").next("span").css({"display":"block"});
			flag = false;
		}
		else{
			/* var myRegExp =/^(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;

			  if (!myRegExp.test(website_url)) {
					$("#website_url").css({"border":"1px solid red"});
					$(".website_url img").attr('src',baseurl+'/images/no.png');
					$("#website_url").next("span").css({"display":"block"});
					flag=false;
				}
				else{
					$("#website_url").css({"border":"1px solid green"});
					$(".website_url img").attr('src',baseurl+'/images/yes.png');
					$("#website_url").next("span").css({"display":"block"});
				} */
				
				
				
		}
		
		if( RegBusinessDescription == "" )
		{
			$("#RegBusinessDescription").css({"border":"1px solid red"});
			flag = false;
		}
		else{
			$("#RegBusinessDescription").css({"border":"1px solid green"});
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
	
	
/////////////////////////////////////END REGISTRATION FORM SUBMITTION///////////////////////////////////////////////////////	
	
	$(".get_error").keyup(function(){
		$(".second").text("");
		var inputID = $(this).attr('id');
		$("#"+inputID).css({"border":"1px solid #e5ecef"});
		$(this).next("span").css({"display":"none"});
	});
	
	
	$(".get_error").mouseup(function(){
		$(".second").text("");
		var inputID = $(this).attr('id');
		$("#"+inputID).css({"border":"1px solid #e5ecef"});
		$(this).next("span").css({"display":"none"});
	});
		
	$("#RegisterLinkedinUrl2").blur(function(){
		var baseurl = 	$.trim($("#baseurl").val());
		var RegisterLinkedinUrl2 = 	$.trim($("#RegisterLinkedinUrl2").val());
		
		if(RegisterLinkedinUrl2 != "") {
			$("#RegisterLinkedinUrl2").val(RegisterLinkedinUrl2);
			$(".relative.form-control.get_error.link").css({"border":"1px solid green"});
			$(".RegisterLinkedinUrl img").attr('src',baseurl+'/images/yes.png');
			$("#RegisterLinkedinUrl2").next("span").css({"display":"block"});
		}
		else{
			$(".RegisterLinkedinUrl img").attr('src','');
			$("#RegisterLinkedinUrl2").next("span").css({"display":"none"});
		}
	})
	
	
	
	//for showing password while clicking on eye icon
	$('.classeye').click(function(){
		var input_type = $('#RegisterPassword').attr('type');
		if(input_type == 'password')
		{
			$('i.classeye').removeClass('fa-eye').addClass('fa-eye-slash');
			$('#RegisterPassword').attr('type','text');
		}
		else {
			$('i').removeClass('fa-eye-slash').addClass('fa-eye');
			$('#RegisterPassword').attr('type','password');
		}
	})
	
	//hiding error of email exist in registration page	
	$( "#RegisterEmail" ).focus(function() {
		if ($('.email_error').is(':visible')) { 	
			$(".email_error").css({"display":"none"});
		}
	});
	$( "#RegisterPassword" ).focus(function() {
		if ($('.pas_error').is(':visible')) { 	
			$(".pas_error").css({"display":"none"});
		}
	}); 
	$( "#CUIT" ).focus(function() {
		if ($('.cuit_error').is(':visible')) { 	
			$(".cuit_error").css({"display":"none"});
		}
	});
	$( "#RegisterLinkedinUrl2" ).focus(function() {
		$(".relative.form-control.get_error.link").css({"border":"1px solid rgb(229, 236, 239)"});
	}); 
	
	$( "#industry_tag" ).focus(function() {
		$(".Industrias-Relacionadas-row").css({"border":"1px solid #f0f0f0"});
	}); 
	
});

function CheckValExistDB(em,status){
	var result;
	var jqXHR = $.ajax({
		url:'check_if_Exist',
		type:'POST',
		async: false,
		data:{  inputval : em, action : status },
	})
	return jqXHR.responseText;
}



function onblurFunction( a, b, baseurl ){
	
	var inputval = $.trim(a);
	
	var inputid = $.trim(b);
	
	if( inputval == "" )
	{
		$("#"+inputid).css({"border":"1px solid red"});
		$("."+inputid+" img").attr('src',baseurl+'/images/no.png');
		$("#"+inputid).next("span").css({"display":"block"});
	}
	else {
		$("#"+inputid).css({"border":"1px solid green"});
		$("."+inputid+" img").attr('src',baseurl+'/images/yes.png');
		$("#"+inputid).next("span").css({"display":"block"});
	}
	
}


function onblurcheckEmail( a, b, baseurl ) {
	
	var inputval = $.trim(a);
	
	var inputid = $.trim(b);
	
	if( inputval == "" ){
		$("#"+inputid).css({"border":"1px solid red"});
		$("."+inputid+" img").attr('src',baseurl+'/images/no.png');
		$("#"+inputid).next("span").css({"display":"block"});	
	}
	else{
		var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		if(re.test(inputval))
		{
			var res = CheckValExistDB(inputval,'checkingemail');
			if(res == 1){ 
				$(".email_error").text("This email already exist!").css({"display":"block"});
				$("#"+inputid).css({"border":"1px solid red"});
				$("."+inputid+" img").attr('src',baseurl+'/images/no.png');
				$("#"+inputid).next("span").css({"display":"block"});
			} else {
				$(".email_error").css({"display":"none"});
				$("#"+inputid).css({"border":"1px solid green"});
				$("."+inputid+" img").attr('src',baseurl+'/images/yes.png');
				$("#"+inputid).next("span").css({"display":"block"});
			}
		} else {
			$(".email_error").text("Not Valid Email!").css({"display":"block"});
		}
	}
}

function onblurcheckPassword( a, b, baseurl ) {
	
	var inputval = $.trim(a);
	
	var inputid = $.trim(b);
	
	if( inputval == "" ){
		$("#"+inputid).css({"border":"1px solid red"});
		$("."+inputid+" img").attr('src',baseurl+'/images/no.png');
		$("#"+inputid).next("span").css({"display":"block"});	
	}
	else{
		var regularExpression  = /^(?=.*[0-9])(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*]{8,}$/;
		if(regularExpression.test(inputval))
		{
			$(".pas_error").css({"display":"none"});
			$("#"+inputid).css({"border":"1px solid green"});
			$("."+inputid+" img").attr('src',baseurl+'/images/yes.png');
			$("#"+inputid).next("span").css({"display":"block"});
		} else {
			$(".pas_error").css({"display":"block"});
			$("#"+inputid).css({"border":"1px solid red"});
			$("."+inputid+" img").attr('src',baseurl+'/images/no.png');
			$("#"+inputid).next("span").css({"display":"block"});
		}
	}
}

function onblurcheckCUIT( a, b, baseurl ) {
	
	var inputval = $.trim(a);
	
	var inputid = $.trim(b);
	
	if( inputval == "" ){
		$("#"+inputid).css({"border":"1px solid red"});
		$("."+inputid+" img").attr('src',baseurl+'/images/no.png');
		$("#"+inputid).next("span").css({"display":"block"});	
	}
	else{
		var ress = CheckValExistDB(inputval,'checkingcuit');
		if(ress == 1){ 
			$(".cuit_error").css({"display":"block"});
			$("#"+inputid).css({"border":"1px solid red"});
			$("."+inputid+" img").attr('src',baseurl+'/images/no.png');
			$("#"+inputid).next("span").css({"display":"block"});
		} else {
			$(".cuit_error").css({"display":"none"});
			$("#"+inputid).css({"border":"1px solid green"});
			$("."+inputid+" img").attr('src',baseurl+'/images/yes.png');
			$("#"+inputid).next("span").css({"display":"block"});
		}
	}
}
	
	//previewing image before uploading
	function readURL(input) {
		$(".error_upload").text("");
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#preview').attr('src', e.target.result);
				$("#upload-file-container").css({"background":"none","overflow":"hidden"});
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	

 function CheckIndustyExistDB(industryname,status){
	var result;
	var jqXHR = $.ajax({
		url:'CheckIndustryExist',
		type:'POST',
		async: false,
		data:{  inputval : industryname, action : status },
	})
	return jqXHR.responseText;
} 

//for auto correct the Website URL in Registration page	
function checkURLvalid (abc, baseurl) {
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

//for removing space between the string	
/* function hasWhiteSpace(s) {
	  var check = "";
	  if(s.indexOf(' ') >= 0){
		  return check = s.replace(/\s/g, "");
	  }
	  else{
		  return check = s;
	  }
	 
	}
*/
 
function checkInputVal(tag){
	var msg;
	$( ".appendspan input" ).each(function( ) {
		if($(this).val() != "")
		{
			if($(this).val() == tag)	{
				msg = 1;
			}
		}
	});
	return msg;
}
