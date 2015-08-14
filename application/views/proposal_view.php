<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(isset($proposal_info)){
?>
<script>
$(document).ready(function(){
$("#proposal-bg-container").css({"background": "url(<?php echo base_url()?>uploads/proposal/<?php echo $proposal_info['background_img_url'];?>)",'background-size': 'cover', 'background-repeat': 'no-repeat'});
});
</script>
<?php } ?>

<!-- Wrapper for Slides -->
<section class="detail-edit-row" id="proposal-bg-container">
  <div class="container">
  <div class="loader-block"></div>
    <div class="row">
     <?php	
			 $attributes = array( 
							'name' 		=>	"EditProposal_form",
							'id' 		=>	"EditProposal_form"
						);
			 if(isset($proposal_info['proposal_id'])){
			 echo form_open_multipart('Proposal/UpdateProposal', $attributes);
			 $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			 ?>
             <input type="hidden" name="hidden_url" value="<?php echo $actual_link; ?>"/>
			 <input type="hidden" name="hidden_id" value="<?php echo $proposal_info['proposal_id']; ?>"/>
			 <?php
			 }
			 else{
				 $attributes = array( 
							'name' 		=>	"AddProposal_form",
							'id' 		=>	"AddProposal_form"
						);
			 echo form_open_multipart('Proposal/AddProposal', $attributes); ?>
			 <?php } ?>
             
    <div class="col-sm-12 top-edit-btns">
    	
    	<div id="upload-proposal-bg" class="edit-profile-icon">
      		  <input type="file" name="proposal_bg" id="proposal_bg" value="" onchange="proposalbgURL(this);"/>
        </div>
        <span class="error_upload"></span>
        <p>
			<?php if(isset($message)) {?>
            <h2 class="msg_area"><?php echo $message; } ?></h2>
           <?php if(!empty($proposal_msg)) {?> <h2 class="msg_area">
		   <?php echo $proposal_msg; } ?></h2>
        	<h2 class="second"></h1>
        </p>
        
    </div>
    <?php 
	$set_data = $this->session->all_userdata();
	?>
      <div class="col-sm-8 Detalles-left-col">
        <div class="Propuesta-detail-row">
        
       <div class="slider-rating-row"><?php if(isset($proposal_info['proposal_id'])){ ?> <span class="star-col"> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> </span>
            <p id="popoverId4" class="popoverThis btn btn-large" data-original-title="" title=""><i class="Library3"></i>0</p>
            <!--<div id="popoverContent4" class="hide">
              <h4 class="popover-title">Just Lunch CON</h4>
              <ul>
                <li>Pepe Ezquivel </li>
                <li>Carlos Bursich </li>
                <li>Marco Gutierrez .</li>
                <li>Hector Guyot</li>
              </ul>
            </div>-->
            <p id="popoverId5" class="popoverThis btn btn-large" data-original-title="" title=""><i class="Library4"></i>0</p>
            <!--<div id="popoverContent5" class="hide">
              <h4 class="popover-title">Seguidores</h4>
              <ul>
                <li>Eugenio Beccar</li>
                <li>Ramón Esquivel</li>
                <li>Lucas Schoen</li>
                <li>Federico Brizuela</li>
                <li>Marcelo Nabel</li>
                <li>Marcel Santos</li>
                <li>Juan Osvaldo Bouzo</li>
                <li>Nahuel Quimey</li>
                <li>Ricardo Ernesto Vaca</li>
                <li>Santiago Zurbana</li>
                <li>Carlos Menditegui</li>
                <li>Agustín Bonadeo</li>
                <li>Wenceslao Cesar</li>
              </ul>
            </div>-->  
			<?php } ?>
          </div>
		  
		<div class="title_div" id="div_prop_title">
			<div class="title_span">
				<input type="text" name="proposal_title"  readonly id="prop_title" class="proposal_description prop_input h2" value="<?php if(empty($proposal_info)) { ?><?php } else { echo $proposal_info['title']; } ?>"  tabindex="1" placeholder="Title"/>
			</div>
			<div class="icons_div">
				<i class="fa fa-pencil editable_icons"></i>
			</div>
        </div>
		
		<a href="javascript:void(0);" class="Descripción-btn">Descripción</a>
		
		<div class="title_div" id="div_proposal_desc">		
			<div class="title_span">
			<textarea readonly tabindex="2" id="proposal_desc" name="proposal_desc" rows='5' cols="71" class="get_error noscrollbars prop_input desc"><?php if(isset($proposal_info)) { echo $proposal_info['description']; } ?></textarea>
			</div>
			<div class="icons_div">
				<i class="fa fa-pencil editable_icons"></i>
			</div>
		</div>
		  
		<a href="javascript:void(0);" class="Descripción-btn">beneficios exclusivos</a>
   		
		<div class="title_div" id="div_proposal_benefits">
			<div class="title_span"><textarea readonly id="proposal_benefits" name="proposal_benefits" rows='5'  tabindex="3" cols="71" class="get_error noscrollbars prop_input desc"><?php if(isset($proposal_info)) {echo $proposal_info['looking_for_desc']; }?></textarea>
            </div>
			<div class="icons_div">
				<i class="fa fa-pencil editable_icons"></i>
			</div>
        </div>
        
			<input type="hidden" name="ceo_id"  value="<?php echo $result['0']['id']; ?>" id="ceo_id"/>
			<input type="hidden" name="ind_id" id="ind_id"  value=""/>
          
          <a class="Descripción-btn" href="javascript:void(0);">click on industry tabs to select</a>
          <p class="editable-text neweditable"> 
          <?php if(isset($business_industry) && !empty($business_industry)){ ?>
          <?php	$click_state = 0; $selectedclass = "";
			//echo '<pre>';print_r($business_industry);echo "</pre>";
		  		 foreach($business_industry as $industry_tabs) { ?>
				 <?php if(!empty($proposal_info['industries']) && !empty($industry_tabs['id'])) { if(in_array($industry_tabs['id'], $proposal_info['industries'])) { ?>
				 <?php $click_state = 1; $selectedclass = "highlight"; } else { $click_state = 0; $selectedclass = ""; } } ?>
					<a href="javascript:void(0);" class="tab-btns <?php echo $selectedclass; ?>" rel="<?php if(!empty($industry_tabs['id'])) { echo $industry_tabs['id']; } ?>" data-click-state="<?php echo $click_state; ?>"><?php if(!empty($industry_tabs['name'])) { echo $industry_tabs['name']; } ?></a>
			
				 <?php } }  ?>
             
          </p>
		  
			<p class="slider-btn-row">
				<a class="slider-btns btn disabled" disabled="disabled"><i class="Library8"></i>JUST LUNCH</a> 
				<a class="slider-btns btn disabled" disabled="disabled"><i class="fa fa-plus-circle follow_editable"></i>SEGUIR</a>
			</p>
			
        </div>
		<p class="sub-btn">
			<?php $opts = "class='proposal-submit'";	echo form_reset('reset', 'CANCELAR', $opts); ?>
			<?php if(isset($proposal_info['proposal_id'])) { echo form_submit('submit', 'Guardar', $opts);	?>
			<input type="hidden" name="prop_id" value="<?php echo $proposal_info['proposal_id']; ?>" id="prop_id">
			<?php }	else { echo form_submit('submit', 'GUaRDAR', $opts); } ?>
		</p>
      </div>
	  
      <div class="col-sm-4 sidebar-col">
        <div class="Propuesta-detail-row">
        <div class="sidebar-user"> <a href="javascript:void(0);" class="Descripción-btn">CEO</a>
		<i class="ceo_profile_pic" style="background:url('<?php if(!empty($result['0']['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $result['0']['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user.jpg<?php } ?>')">
		</i>
		<span><?php echo $result['0']['nickname']?><font><?php echo $result['0']['first_name'].' '.$result['0']['last_name']; ?></font></span>
        </div>
        <a href="javascript:void(0);" class="Descripción-btn">Empresa</a>
		<?php if(!empty($result['0']['logo_url'])) { ?>
		<i><img src="<?php echo base_url(); ?>uploads/business/logo/150/<?php echo $result['0']['logo_url']; ?>" alt="" width="182" height="auto"></i>
		<?php } else { ?>
		<i><img src="<?php echo base_url(); ?>images/demo-logo150x150.jpg" alt="" width="182" height="auto"></i>
		<?php } ?>
          <h6><?php echo $result['0']['business_name'] ;?></h6>
          <p><?php  echo $result['0']['description']; ?></p>
         <!-- <h6>Contacto</h6>
          <p class="Contacto"><i><img src="<?php //echo base_url(); ?>images/location.png" alt=""></i>Arenales 4030<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Florida, PBA, Argentina</p>
          <p class="Contacto"><i><img src="<?php //echo base_url(); ?>images/msg.png" alt=""></i>CEO@brunoschillig.com</p>
          <p class="Contacto"><i><img src="<?php //echo base_url(); ?>images/phone.png" alt=""></i>+54+11-4730-1100</p>-->
        </div>
      </div>
	 
       <?php echo form_close(); ?>
    </div>
  </div>
</section>

<!--<section class="container-fluid testimoanls-main">
  <div class="container">
    <div class="Experiencias">
      <h1>Experiencias</h1>
    </div>
    <div id="myCarousel2" class="vertical-slider carousel vertical slide col-md-12" data-ride="carousel">
      <div class="row">
        <div class="col-md-12"> <span data-slide="next" class="btn-vertical-slider next glyphicon glyphicon-circle-arrow-up " style="font-size: 30px"></span> </div>
      </div>
      <br>
     
      <div class="carousel-inner">
        <div class="item active">
          <div class="col-sm-2"> <a href="javascript:void(0);"> <img src="<?php echo base_url(); ?>images/testimonal-ing.jpg" class="thumbnail" alt="Image"></a> <span>Ernest<font>Ernesto Funes</font></span>
            <p class="CEO">CEO at Plop!</p>
          </div>
          <div class="col-sm-10"> <a class="Descripción-btn" href="javascript:void(0);">A quienes podría interesarle</a>
            <p class="testimoanls-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris interdum eu nulla eu vestibulum. Mauris lobortis efficitur augue, non mollis odio efficitur sed. Aliquam mauris ligula, venenatis vel dignissim ac, commodo vel turpis.<br>
              m ipsum dolor sit amet, consectetur adipiscing elit. Mauris interdum eu nulla eu vestibulum. Mauris lobortis efficitur augue, non mollis odio efficitur sed. Aliquam mauris ligula, venenatis vel dignissim ac, commodo vel turpis.m ipsum dolor sit amet, consectetur adipiscing elit. Mauris interdum eu nulla eu<br>
              vestibulum. Mauris lobortis efficitur augue, non mollis odio efficitur sed. Aliquam mauris ligula, venenatis vel dignissim ac, commodo vel turpis.vestibulum. Mauris lobortis efficitur augue, non mollis odio efficitur sed. Aliquam mauris ligula, venenatis vel dignissim ac, commodo vel turpis.</p>
            <p> <a class="Descripción-btn" href="javascript:void(0);">A quienes podría interesarle</a> <img src="<?php echo base_url(); ?>images/rating-star-img.png" alt=""> </p>
          </div>
          
        
          <div class="clearfix"></div>
        </div>
       
        <div class="item">
          <div class="col-sm-2"> <a href="javascript:void(0);"> <img src="<?php echo base_url(); ?>images/testimonal-ing.jpg" class="thumbnail" alt="Image"></a> <span>Ernest<font>Ernesto Funes</font></span>
            <p class="CEO">CEO at Plop!</p>
          </div>
          <div class="col-sm-10"> <a class="Descripción-btn" href="javascript:void0;">A quienes podría interesarle</a>
            <p class="testimoanls-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris interdum eu nulla eu vestibulum. Mauris lobortis efficitur augue, non mollis odio efficitur sed. Aliquam mauris ligula, venenatis vel dignissim ac, commodo vel turpis.<br>
              m ipsum dolor sit amet, consectetur adipiscing elit. Mauris interdum eu nulla eu vestibulum. Mauris lobortis efficitur augue, non mollis odio efficitur sed. Aliquam mauris ligula, venenatis vel dignissim ac, commodo vel turpis.m ipsum dolor sit amet, consectetur adipiscing elit. Mauris interdum eu nulla eu<br>
              vestibulum. Mauris lobortis efficitur augue, non mollis odio efficitur sed. Aliquam mauris ligula, venenatis vel dignissim ac, commodo vel turpis.vestibulum. Mauris lobortis efficitur augue, non mollis odio efficitur sed. Aliquam mauris ligula, venenatis vel dignissim ac, commodo vel turpis.</p>
            <p> <a class="Descripción-btn" href="javascript:void(0);">A quienes podría interesarle</a> <img src="<?php echo base_url(); ?>images/rating-star-img.png" alt=""> </p>
          </div>
          
          
          <div class="clearfix"></div>
        </div>
        
      </div>
      <div class="row">
        <div class="col-md-12"> <span data-slide="prev" class="btn-vertical-slider prev glyphicon glyphicon-circle-arrow-down" style="color: Black; font-size: 30px"></span> </div>
      </div>
    </div>
  </div>
</section>-->
