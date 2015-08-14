<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="container-fluid">
  <div class="container register-container">
	<div class="loader-block"></div>
  <!--<form>-->
  <?php 	$attributes = array( 
							'name' 		=>	"registration_form",
							'id' 		=>	"registration_form",
							'enctype'	=>	"multipart/form-data"
						);
				echo form_open('Login/GetRegister', $attributes); ?>

	<div class="row topmsg">
		<h1 class="first">Bienvenido a <strong>RONDAS</strong>, Creá tu perfil</h1>
		<h1 class="second"><h1>
	</div>
    <div class="row Datos-Personales-row">
    	<div class="col-sm-12">
       		<h2>Datos Personales</h2>
                <div class="col-sm-6">
					<input type="hidden" id="baseurl" value="<?php echo base_url(); ?>" />
					<!--first_name-->
					<p class="relative">
						<input type="text" placeholder="Nombre" id="RegisterName" onblur="return onblurFunction(this.value,this.id,'<?php echo base_url(); ?>')" name="name" class="form-control get_error">
						<span class="register_err_span RegisterName"><img class="err" src=""/></span>
					</p>
					<!--last_name-->
					<p class="relative">
						<input type="text" placeholder="Apellido" id="RegisterSurname" onblur="return onblurFunction(this.value,this.id,'<?php echo base_url(); ?>')" name="surname" class="form-control get_error">
						<span class="register_err_span RegisterSurname"><img class="err" src=""/></span>
					</p>
					<!--nickname-->
					<p class="relative">
						<input type="text" placeholder="Como te dicen?" onblur="return onblurFunction(this.value,this.id,'<?php echo base_url(); ?>')" name="nickname" id="RegisterNickname" class="form-control get_error"> 
						<span class="register_err_span RegisterNickname"><img class="err" src=""/></span>
					</p>
				</div>
                <div class="col-sm-6">
                	<p class="relative reg-2col">
					<span class="email_error">This email already exist!</span>
					<input type="email" placeholder="Email" onblur="return onblurcheckEmail(this.value,this.id,'<?php echo base_url(); ?>')" name="email" id="RegisterEmail" class="form-control Email get_error">
					<span class="register_err_span RegisterEmail"><img class="err" src=""/></span>
					</p>
					<p class="relative reg-2col">
					<span class="pas_error">Password should contain 8 alphanumeric letter with atleast 1 Capital Letter!</span>
					<input type="password" placeholder="Contraseña" onblur="return onblurcheckPassword(this.value,this.id,'<?php echo base_url(); ?>')" name="password" id="RegisterPassword" class="form-control Password get_error"><!--password-->
					<span class="register_err_span RegisterPassword"><img class="err" src=""/></span>
					</p><i class="fa fa-eye classeye"></i>
					
					<select class="form-control get_error" name="vistage_group_id" id="vistage_group_id"  onblur="return onblurFunction(this.value,this.id,'<?php echo base_url(); ?>')" >
					<option value="">--Select Vistage--</option>
                    <?php
					if(!empty($group)) {
						foreach( $group as $g ) : ?>
							<option value="<?php echo $g->id; ?>"><?php echo $g->group_name; ?></option>
						<?php endforeach; ?>
                    <?php } ?>
					</select>
					
					<div class="relative form-control get_error link">
						<input type="text" onblur="checkURLvalid(this,'<?php echo base_url();?>')" name="linkedin_url2" id="RegisterLinkedinUrl2" class="common" placeholder="LinkedIn Username" />
						<span class="register_err_span RegisterLinkedinUrl"><img class="err" src=""/></span>
					</div>
					
					<!--<p class="relative">
					<input type="text" placeholder="LinkedIn URL" name="linkedin_url" id="RegisterLinkedinUrl" class="form-control get_error" >
					<span class="register_err_span RegisterLinkedinUrl"><img class="err" src=""/></span>
					</p>-->
				</div>
        </div>
    </div>
	<script>
	
	</script>
    <div class="row Datos-Personales-row">
    	<div class="col-sm-12">
		
		 <!--businesses table-->
		 
       		<h2>Empresa</h2>
			
                <div class="col-sm-6">
                	<div class="col-sm-4" id="upload-file-container">
						<!--<span class="error_upload"></span>-->
						<!--<img alt="" src="<?php echo base_url(); ?>images/subir-logo.jpg">-->
						<img width="135" id="preview" alt="" src="">
						<input type="file" name="business_logo" onchange="readURL(this);" id="business_logo" value="" />
					</div>
                    
					<div class="col-sm-8">
						<!--Business Name-->
						<p class="relative">
						<input type="text" placeholder="Nombre" onblur="return onblurFunction1(this.value,this.id,'<?php echo base_url(); ?>')" name="business_name" id="business_name" class="form-control get_error"> 
						<span class="register_err_span business_name"><img class="err" src=""/></span>
						</p>
						<!--CUIT / Business TAN NO.-->
						<p class="relative">
						<span class="cuit_error">This CUIT already exist!</span>
						<input class="form-control get_error" onblur="return onblurcheckCUIT(this.value,this.id,'<?php echo base_url(); ?>')" name="CUIT" type="text" id="CUIT" placeholder="CUIT">
						<span class="register_err_span CUIT"><img class="err" src=""/></span>
						</p>
					</div>
                   <textarea placeholder="Texto descriptivo" onblur="return onblurFunction(this.value,this.id,'<?php echo base_url(); ?>')" class="form-control get_error" rows="6" cols="" id="RegBusinessDescription" name="description"></textarea>
				</div>
				
                <div class="col-sm-6">
					<p class="relative">
					<input type="text" placeholder="Website URL" onblur="return onblurFunction(this.value,this.id,'<?php echo base_url(); ?>'), checkURLvalid(this);" name="website_url" id="website_url" class="form-control get_error">
					<span class="register_err_span website_url"><img class="err" src=""/></span>	                 
					</p>
					
					<div class="Industrias-Relacionadas-row get_error">
						<span class="ind_err"> You can choose only existing industries! </span>
						<input type="text" onkeyup="return getIndustries();" placeholder="Industrias Relacionadas" name="" id="industry_tag" class="form-control Industrias">
						<input type="button" value="+ Añadir" class="form-control Anadir" name="">
						<span class="in-loader-class"></span>
						<div class="clearfix"></div>
					</div>
                  <div class="add-tags">
                   
				  </div>
              </div>
        </div>
    </div>
    
    <div class="row">
    	<div class="register-btn">
           <input type="submit" value="Siguiente" name="RegisterSubmit" id="register-submit" class="btn btn-lg btn-default">
        </div>
    </div>
   <?php echo form_close(); ?>
   <!-- </form>-->
  </div>
</section>