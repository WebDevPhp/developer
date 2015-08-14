<?php 
/* echo "<pre>";
print_r($lunchinfo);
print_r($getLunchInfo);
echo "</pre>"; */

$ceo_profile_pic = "";
$ceo_name = "";
$ceo_business_name = "";
$performed_by = "";
$performed_to = "";
$rating = "";

if(!empty($lunchinfo) && $lunchinfo['rateby'] == 'r'){
	if(!empty($getLunchInfo[0]->requester_pic)){
		$ceo_profile_pic = base_url().'uploads/profile/64/'.$getLunchInfo[0]->requester_pic;
	}
	else {
		$ceo_profile_pic = base_url().'images/user64x64.jpg';
	}
}
else if(!empty($lunchinfo) && $lunchinfo['rateby'] == 'a'){
	if(!empty($getLunchInfo[0]->acepter_pic)){
		$ceo_profile_pic = base_url().'uploads/profile/64/'.$getLunchInfo[0]->acepter_pic;
	}
	else {
		$ceo_profile_pic = base_url().'images/user64x64.jpg';
	}
}

if(!empty($lunchinfo) && $lunchinfo['rateby'] == 'r') {
	if(!empty($getLunchInfo[0]->requester_nickname)){
		$ceo_name = $getLunchInfo[0]->requester_nickname;
	}
}
else if(!empty($lunchinfo) && $lunchinfo['rateby'] == 'a'){
	if(!empty($getLunchInfo[0]->acepter_nickname)){
		$ceo_name = $getLunchInfo[0]->acepter_nickname;
	}
}

if(!empty($lunchinfo) && $lunchinfo['rateby'] == 'r') {
	if(!empty($getLunchInfo[0]->requester_business_name)){
		$ceo_business_name = $getLunchInfo[0]->requester_business_name;
	}
}
else if(!empty($lunchinfo) && $lunchinfo['rateby'] == 'a'){
	if(!empty($getLunchInfo[0]->acepter_business_name)){
		$ceo_business_name = $getLunchInfo[0]->acepter_business_name;
	}
}


if(!empty($lunchinfo) && $lunchinfo['rateby'] == 'r') {
	if(!empty($getLunchInfo[0]->requester_ceo_id)){
		$performed_by = $getLunchInfo[0]->requester_ceo_id;
		$performed_to = $getLunchInfo[0]->acepter_ceo_id;
	}
}
else if(!empty($lunchinfo) && $lunchinfo['rateby'] == 'a'){
	if(!empty($getLunchInfo[0]->acepter_ceo_id)){
		$performed_by = $getLunchInfo[0]->acepter_ceo_id;
		$performed_to = $getLunchInfo[0]->requester_ceo_id;
	}
}
?>
<!-- Wrapper for Slides -->
<section class="container-fluid testimoanls-main1">
  <div class="container">
  <div class="add1">
    <div class="Experien">
      <h1>Experiencias</h1>
    </div>
    <div id="myCarousel2" class="col-md-12" data-ride="carousel">
      <div class="row">
        <div class="col-md-12"></div>
      </div>
      <br>
      <!-- Carousel items -->
      <div class="carousel-inner">
        <div class="item active">
         <?php if(empty($ratingmsg) && !empty($lunchinfo)) { ?> 
		  <div class="col-sm-2"> 
			<a href="javascript:void(0);"> 
				<i style="background:url('<?php echo $ceo_profile_pic ?>') no-repeat scroll center center / cover rgba(0, 0, 0, 0); " class="thumbnail"></i>
			</a> <span><?php echo $ceo_name; ?></span>
            <p class="CEO">CEO at <?php echo $ceo_business_name; ?></p>
          </div>
		 
			<div class="col-sm-10"> <a class="Descripción-btn" href="javascript:void(0);">A quienes podría interesarle</a><span class="rating_error"></span>
				<div class="coment-row-filed1">
					<?php $attribute = array('class'=>'coment-textarea1', 'method'=>'POST', 'id'=>'rating_form');?>
					<?php echo form_open('LunchExperience/AddRatings',$attribute) ;?>
					<input type="hidden" name="log_id" id="log_id" value="<?php if(!empty($lunchinfo['log_id'])) { echo $lunchinfo['log_id']; } ?>" />
					<input type="hidden" name="requester" id="requester" value="<?php if(!empty($lunchinfo['requester'])) { echo $lunchinfo['requester']; } ?>" />
					<input type="hidden" name="accepter" id="accepter" value="<?php if(!empty($lunchinfo['accepter'])) { echo $lunchinfo['accepter']; } ?>" />
					<input type="hidden" name="propid" id="propid" value="<?php if(!empty($lunchinfo['propid'])) { echo $lunchinfo['propid']; } ?>" />
					<input type="hidden" name="performed_by" id="performed_by" value="<?php if(!empty($performed_by)) { echo $performed_by; } ?>" />
					<input type="hidden" name="performed_to" id="performed_to" value="<?php if(!empty($performed_to)) { echo $performed_to; } ?>" />
					<input type="hidden" name="lunchid" id="lunchid" value="<?php if(!empty($lunchinfo['lunchid'])) { echo $lunchinfo['lunchid']; } ?>" />
					<input type="hidden" name="rating" id="rating" value="" />
					<textarea name="rating_text" id="rating_text" cols="" rows="1" class="form-control1" placeholder="Escribe un comentario........"></textarea>
					<div class="clearfix"></div>
					
					<p class="rating-sec"> 
						<a class="Descripción-btn" href="javascript:void(0);">A quienes podría interesarle</a> 
						<i class="fa fa-star-o star-rating"></i>
						<i class="fa fa-star-o star-rating"></i>
						<i class="fa fa-star-o star-rating"></i>
						<i class="fa fa-star-o star-rating"></i>
						<i class="fa fa-star-o star-rating"></i>
					</p>
					<input type="submit" name="submit_ratings" style="float:right;" />
				<?php form_close(); ?>
				</div>
			</div>
		 <?php } else if(empty($lunchinfo) && !empty($ratingmsg) ){ ?>
			<?php echo $ratingmsg; ?>
		 <?php } else { ?>
			<div style="height:300px;"></div>
		 <?php } ?>
          <!--/row-fluid-->
          <div class="clearfix"></div>
        </div>
        <!--/item-->
        <!--/item--> 
      </div>
      <div class="row">
        <div class="col-md-12"></div>
      </div>
    </div>
    </div>
  </div>
</section>
