<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$userdata = $this->session->userdata('UserData');
$UserData = json_decode($userdata,true);
$linked = str_replace("https://", "", $UserData[0]['linkedin_url']);
?>

<section class="container-fluid">
  <div class="container register-container">
  <div class="loader-block"></div>
  <!--<form>-->
  <?php 	$attributes = array( 
							'name' 		=>	"edit_profile_form",
							'id' 		=>	"edit_profile_form",
							'enctype'	=>	"multipart/form-data"
						);
				echo form_open('Login/UpdateProfile', $attributes); ?>
	<input type="hidden" name="ceo_id" id="ceo_id" value="<?php echo $UserData[0]['id'] ?>">
	<input type="hidden" name="business_id" id="business_id" value="<?php echo $UserData[0]['ceo_business_id'] ?>">
	<input type="hidden" name="useremail" id="useremail" value="<?php echo $UserData[0]['email'] ?>">
	<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
	<!--<input type="hidden" name="edit_ind" id="edit_ind" value="">-->
	<input type="hidden" name="hidden_password" value="<?php echo $UserData[0]['password'] ?>">
	<input type="hidden" name="hidden_profile_pic" value="<?php echo $UserData[0]['ceo_profile_pic']; ?>">
	<input type="hidden" name="hidden_bg_business" value="<?php echo $UserData[0]['background_img_url']; ?>">
	<input type="hidden" name="hidden_business_logo" value="<?php echo $UserData[0]['logo_url']; ?>">
	<div class="row topmsg">
		<h1 class="first">Bienvenido a <strong>RONDAS</strong>, Creá tu perfil</h1>
		<h1 class="second"><?php if(!empty($EditProfileMsg)) { echo $EditProfileMsg; } ?><h1>
	</div>
<?php //print_r($UserData); ?>
    <div class="row Datos-Personales-row">
    	<div class="col-sm-12">
       		<h2>Datos Personales</h2>
				<?php if(!empty($UserData[0]['ceo_profile_pic'])) { ?>
					<img src="<?php echo base_url(); ?>images/close-24.png" class="remove_pic" title="Delete" id="<?php echo $UserData[0]['id'] ?>" rel="<?php echo $UserData[0]['ceo_profile_pic']; ?>"/>
				<?php } ?>
            	<div class="col-sm-2" id="upload-profile-pic">
					<span class="error_upload_profile_pic"></span>
					<?php if(!empty($UserData[0]['ceo_profile_pic'])) { ?>
						<style>#upload-profile-pic{ background:none; overflow:hidden;} </style>
						<img id="profile_pic_img"  src="<?php echo base_url(); ?>uploads/profile/150/<?php echo $UserData[0]['ceo_profile_pic']; ?>" alt=""/>
					<?php } else { ?>				
					<img alt="" src="" id="profile_pic_img">
					<?php } ?>
					<input type="file" id="profile_pic" onchange="profile_pic_readURL(this);" name="profile_pic"  value="<?php echo $UserData[0]['ceo_profile_pic']; ?>">
				</div>
				
            	<div class="col-sm-3">
                	<input class="form-control get_edit_error" name="edit_first_name" id="edit_first_name" type="text" placeholder="Nombre" value="<?php echo $UserData[0]['first_name'] ?>">
					
					<span class="edit_email_error">This email already exist!</span>
					<input class="form-control get_edit_error" name="edit_useremail" id="edit_useremail" type="text" placeholder="Email" value="<?php echo $UserData[0]['email'] ?>" />
					</div>
                
				<div class="col-sm-3">
                	<input class="form-control get_edit_error" name="edit_last_name" id="edit_last_name" type="text" placeholder="Apellido" value="<?php echo $UserData[0]['last_name'] ?>">
                    <input class="form-control get_edit_error" name="edit_password" id="edit_password" type="password" placeholder="Password" value="">
					
                </div>
                
				<div class="col-sm-3">
                    <input class="form-control get_edit_error" name="edit_nickname" id="edit_nickname" type="text" placeholder="Como te dicen" value="<?php echo $UserData[0]['nickname'] ?>">
					<p style="position:relative">
						<span class="errpss get_edit_error"> </span>
						<input class="form-control get_edit_error" name="edit_confirm_password" id="edit_confirm_password" type="password" placeholder="Confirm Password" value="">
					</p>
				</div>
				<div class="col-sm-9">
					<div class="col-sm-4 groupselect">
					<select name="edit_vistage_group_id" class="form-control">
						<?php foreach($getGroups as $group) { ?>
							<option value="<?php echo $group->id; ?>" <?php if($group->id == $UserData[0]['vistage_id']) { echo "selected='selected'"; } ?>><?php echo $group->group_name; ?></option>
						<?php } ?>
                    </select>
					</div>
					<div class="col-sm-8 form-control editlink">
						<input class="get_edit_error commonedit" name="edit_linkedin2" id="edit_linkedin2" type="text" placeholder="LinkedIn URL" value="<?php echo $linked; ?>" onblur="EditcheckURLvalid(this)" />
					</div>
				</div>
        </div>
    </div>
	
    <div class="row Datos-Personales-row">
    	<div class="col-sm-12">
       		<h2>Empresa</h2>
            	<div class="col-sm-12 big-image" id="edit-bg-image">
					<span class="error_upload_bg"></span>
					<?php if(!empty($UserData[0]['background_img_url'])) { ?>
						<style>#edit-bg-image{ background:none; overflow:hidden;} </style>
						<img id="big-preview"  src="<?php echo base_url(); ?>uploads/business/background/1000/<?php echo $UserData[0]['background_img_url']; ?>" alt="">
					<?php } else { ?>				
					<img id="big-preview" src="" alt="">
					<?php } ?>
					<input type="file" name="bg_business" onchange="bg_business_readURL(this);" id="bg_business" value="<?php echo $UserData[0]['background_img_url']; ?>" />
				</div>
                <div class="col-sm-6">
                	<div class="col-sm-4" id="edit-upload-file-container">
						<span class="error_upload"></span>
						<!--<img alt="" src="<?php echo base_url(); ?>images/subir-logo.jpg">-->
					<?php if(!empty($UserData[0]['logo_url'])) { ?>
						<style>#edit-upload-file-container{ background:none; overflow:hidden;} </style>
						<img width="135" id="edit_preview" src="<?php echo base_url(); ?>uploads/business/logo/150/<?php echo $UserData[0]['logo_url']; ?>" alt="">
					<?php } else { ?>				
					<img width="135" id="edit_preview" alt="" src="">
					<?php } ?>
						<input type="file" name="edit_business_logo" onchange="edit_readURL(this);" id="edit_business_logo" value="<?php echo $UserData[0]['logo_url']; ?>" />
					</div>
                    <div class="col-sm-8">
                    <input class="form-control get_edit_error" name="edit_business_name" id="edit_business_name" type="text" placeholder="Nombre" value="<?php echo $UserData[0]['business_name'] ?>">
                    <span class="edit_cuit_error">This CUIT already exist!</span>
					<input class="form-control get_edit_error" name="edit_cuit" id="edit_cuit" type="text" placeholder="CUIT" value="<?php echo $UserData[0]['CUIT'] ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                  <div class="Industrias-Relacionadas-row">
                	<input type="text" onkeyup="return editProfileIndustries();" placeholder="Industrias Relacionadas" name="" id="industry_tag_edit" class="form-control Industrias">
                    <input type="button" value="+ Añadir" class="form-control editAnadir " name="">
					<span class="in-loader"></span>
                    <div class="clearfix"></div>
                  </div>
                  <div class="add-tags-edit">
				   <span class="ind_err_edit"> You can choose only existing industries! </span>
					<?php if(!empty($selected_industries)) : ?>
						<?php foreach($selected_industries as $key => $selected_industries) : ?>
						<span class="appendspan">
							<input type="hidden" name="edit_tag_value[]" value="<?php echo $selected_industries; ?>" />
							<img class="delete" src="<?php echo base_url(); ?>images/1433172107_close.png">
							<?php echo $selected_industries; ?>
                    	</span>
					<?php endforeach; endif; ?>
                 </div>
              </div>
              <div class="col-sm-12">
				<input type="text" onblur="EditcheckURLvalid(this)" value="<?php echo $UserData[0]['website_url'] ?>" placeholder="Website URL" name="edit_website_url" class="form-control get_edit_error" id="edit_website_url">
              	<textarea name="edit_business_description" id="edit_business_description" cols="" rows="6" class="form-control get_edit_error" placeholder="Texto descriptivo"><?php echo strip_tags($UserData[0]['description']) ?></textarea>
              </div>
        </div>
    </div>
    <div class="row">
    	<div class="register-btn">
        	 <input class="btn btn-lg btn-default" name="" type="reset" value="Cancelar">
             <input class="btn btn-lg btn-default" name="" type="submit" value="Guardar">
        </div>
    </div>
   <?php echo form_close(); ?>
   <!-- </form>-->
  </div>
</section>