<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$userdata = $this->session->userdata('UserData');
$UserData = json_decode($userdata,true);
if(!empty($proposal_info)){
?>
<script>
$(document).ready(function(){
$("#proposal-bg-container").css({"background": "url(<?php echo base_url()?>uploads/proposal/<?php echo $proposal_info['background_img_url'];?>)",'background-size': 'cover', 'background-repeat': 'no-repeat'});
});
</script>
<?php } ?>

<?php 

/* echo "<pre>"; 
print_r($proposal_info); 
print_r($total_lunches); 
echo "</pre>"; */


?>
<section class="detail-edit-row bottom-space" id="proposal-bg-container">
  <div class="container">
  <div class="succ"><?php if(!empty($succmsg)) { echo $succmsg; }?></div>
    <div class="row">
      <div class="col-sm-8 Detalles-left-col popupdetailpage">
        <div class="Propuesta-detail-row">
		<div class="slider-rating-row"> <span class="star-col"> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> </span>
            <div class="f_dd">
				<p id="lunchpo" onmouseover="detailproposallunchpopupshow(this)" onmouseout="detailproposallunchpopuphide()" prop-id="<?php echo $proposal_info['proposal_id'] ?>" ><i class="Library3"></i><?php echo $proposal_info['totallunches'] ?></p>
				<div class="fullpropdetail">
					<h4>Just Lunch</h4>
					<ul></ul>
				</div>
				<p id="followpo" onmouseover="detailproposalfollowpopupshow(this)" onmouseout="detailproposalfollowpopuphide()" prop-id="<?php echo $proposal_info['proposal_id'] ?>"><i class="Library4"></i><?php echo $proposal_info['totalfollows'] ?></p>
				
				<div class="fullpropdetailfollow">
					<h4>Follows</h4>
					<ul></ul>
				</div>
			
			</div>
			<?php if( $UserData[0]['id'] == $proposal_info['ceo_id'] ) { ?>
				<p class="edit-prop">
					<a class="Descripción-btn" href="<?php echo base_url('index.php/Proposal/ProposalEdit/'.$proposal_info['proposal_id']); ?>">Edit Proposal</a>
				</p>
			<?php } ?>
			
          </div>
		
          <h2 class="fullviewh2"><?php echo $proposal_info['title']; ?></h2>
          <a href="javascript:void(0);" class="Descripción-btn">Descripción</a>
          <p><?php echo $proposal_info['description']; ?></p>
          
          <a href="javascript:void(0);" class="Descripción-btn">beneficios exclusivos</a>
          <p><?php echo $proposal_info['looking_for_desc']; ?></p>
          
		  <p>
			<?php 
			if(!empty($proposal_industry)){
				foreach($proposal_industry as $industry_tabs) {
					if(in_array($industry_tabs['id'], $proposal_info['industries'])) { 
						$selectedIndustries[] = $industry_tabs['name'];
					}
				}
			}
			?>
			
			<?php if(!empty($selectedIndustries)) { ?>
			<?php foreach($selectedIndustries as $industries) { ?>
				<a href="javascript:void(0);" class="detail-tab-btns"><?php echo $industries; ?></a> 
			<?php } } ?>
          </p>
          <p class="slider-btn-row"> 
          <a class="slider-btns btn feed-just-lunch btndis<?php echo $proposal_info['proposal_id']; ?> <?php if(($proposal_info['ceo_id'] == $UserData[0]['id']) || (!empty($proposal_info['proposalstatus']) && $proposal_info['proposalstatus'][0]['lunch_request_status'] == 1)  || (!empty($proposal_info['proposalstatus']) && $proposal_info['proposalstatus'][0]['lunch_request_status'] == 0) ) { echo 'disabled"'; } ?>" href="javascript:void(0)" current-ceo-id="<?php echo $UserData[0]['id']; ?>" prop-ceo-id="<?php echo $proposal_info['ceo_id']; ?>" pro-id="<?php echo $proposal_info['proposal_id']; ?>" <?php if($proposal_info['ceo_id'] == $UserData[0]['id']) { echo 'disabled="disabled"'; } ?>>
		  <?php if(!empty($proposal_info['proposalstatus'])) { ?>
			
			<?php if($proposal_info['proposalstatus'][0]['lunch_request_status'] == 0 ){ ?>
				<i class="Library8"></i><span>Waiting for approval</span>
			<?php } else if($proposal_info['proposalstatus'][0]['lunch_request_status'] == 1 ) { ?>
				<i class="Library8"></i><span>Accepted</span>
		  <?php } else if($proposal_info['proposalstatus'][0]['lunch_request_status'] == 3 ) { ?>
				<i class="Library8"></i><span>Just Lunch</span>
		  <?php } } else {  ?><i class="Library8"></i><span>Just Lunch</span><?php } ?>
		  
		  </a>
		  <a class="slider-btns btn followbtn <?php if($proposal_info['ceo_id'] == $UserData[0]['id']) { echo 'disabled"'; } ?>" href="javascript:void(0)" <?php if($proposal_info['ceo_id'] == $UserData[0]['id']) { echo 'disabled="disabled"'; } ?>  current-ceo-id="<?php echo $UserData[0]['id']; ?>" prop-ceo-id="<?php echo $proposal_info['ceo_id']; ?>" pro-id="<?php echo $proposal_info['proposal_id']; ?>" id="follow<?php echo $proposal_info['proposal_id']; ?>" log_id="<?php if(!empty($proposal_info['checkLogprop'])){ echo $proposal_info['checkLogprop'][0]['log_id']; } ?>" follow_id="<?php if(!empty($proposal_info['checkLogprop'])){ echo $proposal_info['checkLogprop'][0]['task_id']; } ?>">
		  <i class="fa fa-plus-circle fullview_icon"></i><span><?php if(!empty($proposal_info['checkLogprop'])){ echo "dejar de seguir"; } else { echo "SEGUIR"; } ?></span></a>
          </p>
        </div>
      </div>
      <div class="col-sm-4 sidebar-col">
        <div class="Propuesta-detail-row">
        <div class="sidebar-user"> <a href="javascript:void(0);" class="Descripción-btn">CEO</a>
		<i class="ceo_profile_pic" style="background:url(<?php if(!empty($proposal_info['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $proposal_info['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user.jpg<?php } ?>)">
        </i><span><?php echo anchor('CompanyProfileUser?ci='.base64_encode($proposal_info['ceo_id']).'&bs='.base64_encode($proposal_info['ceo_id']),$proposal_info['nickname'],array('class' => 'spananchor'));?><font><?php echo $proposal_info['first_name'].' '.$proposal_info['last_name']; ?></font></span>
        </div>
		<div class="ceo_info">
			<h4>Perfil</h4>
			<div class="com">
			<div class="dn">
				<span class="one">
					<i style="background:url(<?php if(!empty($proposal_info['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $proposal_info['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user.jpg<?php } ?>) no-repeat scroll center center / cover" /></i>
				</span>
			
				<span class="two">
					<?php echo anchor('CompanyProfileUser?ci='.base64_encode($proposal_info['ceo_id']).'&bs='.base64_encode($proposal_info['ceo_id']),$proposal_info['nickname'],array('class' => 'spananchor'));?><font><?php echo $proposal_info['first_name'].' '.$proposal_info['last_name']; ?></font>
					<label>CEO at <?php echo $proposal_info['business_name']; ?></label>
					<a class="linkd" href="<?php echo $proposal_info['linkedin_url']; ?>"><i class="fa fa-linkedin-square"></i>
					See LinkedIn profile</a>
				</span>
			</div>
			<hr class="hrclass">
			<div class="ldiv">
				<a href="javascript:void(0);" class="Descripción-btn">Lunch With</a> 
				<?php if(!empty($proposal_info['lunchwith'])) { ?>
					<ul>
					<?php for($r=0; $r<count($proposal_info['lunchwith']['name']); $r++) { ?>
						<li><?php echo $proposal_info['lunchwith']['name'][$r]. ' <label>' .$proposal_info['lunchwith']['business'][$r].'</lable>' .count($proposal_info['lunchwith']); ?></li>
					<?php } ?>
					</ul> 
					<?php } ?>
			</div>
			</div>
		</div>
        <a href="javascript:void(0);" class="Descripción-btn bdu">Empresa</a> 
		<i><?php if(!empty($proposal_info['logo_url'])) { ?>
			<img src="<?php echo base_url(); ?>uploads/business/logo/150/<?php echo $proposal_info['logo_url']; ?>" alt="" width="182" height="auto">
		<?php } else { ?>
			<img src="<?php echo base_url(); ?>images/demo-logo150x150.jpg" alt="">
        <?php } ?></i>
		
          <h6><?php echo $proposal_info['business_name'] ;?></h6>
          <div class="content-scroll"><p><?php  echo $proposal_info['busdesc']; ?></p></div>
          <!--<h6>Contacto</h6>
          <p class="Contacto"><i><img src="<?php //echo base_url(); ?>images/location.png" alt=""></i>Arenales 4030<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Florida, PBA, Argentina</p>
          <p class="Contacto"><i><img src="<?php //echo base_url(); ?>images/msg.png" alt=""></i>CEO@brunoschillig.com</p>
          <p class="Contacto"><i><img src="<?php //echo base_url(); ?>images/phone.png" alt=""></i>+54+11-4730-1100</p>-->
        </div>
      </div>
    </div>
  </div>
</section>
<!--section start here-->
<?php 
/* echo "<pre>"; 
print_r($proposal_info['comments']); 
echo "</pre>"; */
?>
<section class="container-fluid detalle-container">
  <div class="container">
    <div class="row commentarios-row">
      <div class="col-sm-12">
        <h3 class="Propuesta-main-title">Comentarios</h3>
        <div class="Propuesta-detail-row">
		<div class="comments-sec" >
		<?php if(!empty($proposal_info['comments'])) { ?>
				<?php foreach($proposal_info['comments'] as $comments) : ?>
				  <div class="row coment-row">
					<div class="col-sm-2 comentario-pro"> 
					
					<i style="background:url(<?php if(!empty($comments['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/64/<?php echo $comments['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user.jpg<?php } ?>)"></i> 
					
					<span><?php echo anchor('CompanyProfileUser?ci='.base64_encode($comments['commenter_id']).'&bs='.base64_encode($comments['business_id']),$comments['nickname'],array('class' => 'spananchor'));?><font><?php echo $comments['first_name'].' '.$comments['last_name']; ?></font></span> </div>
					<div class="col-sm-10 comentario-cmt">
					  <p><?php echo $comments['message']; ?></p>
					</div>
				  </div>
			<?php endforeach; ?>
		<?php } ?>
		</div>
		<div class="coment-row-filed"> 
		<i class="coment-user-img" style="background:url(<?php if(!empty($UserData[0]['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/64/<?php echo $UserData[0]['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>);">
		</i>
			<?php 	$attributes = array( 
						'name' 		=>	"coment-textarea",
						'id' 		=>	"comment-form-proposal",
						'enctype'	=>	"multipart/form-data",
					);
			echo form_open('Proposal/addComments', $attributes); ?>
			<input type="hidden" name="comment_proposal_id" value="<?php echo $proposal_info['proposal_id'] ?>" />
			<input type="hidden" name="comment_writer_id" value="<?php echo $UserData[0]['id'] ?>" />
			<input type="hidden" name="comment_receiver_id" value="<?php echo $proposal_info['ceo_id'] ?>" />
			<textarea id="comment_msg" name="comment_msg" cols="" rows="1" class="form-control comment_msg" placeholder="Escribe un comentario........"></textarea>
		<?php echo form_close();?>
		<div class="clearfix"></div>
		</div>
	  </div>
	 </div>
	</div>
 </div>
</section>
<section class="container-fluid testimoanls-main">
  <div class="container">
    <div class="Experiencias">
      <h1>Experiencias</h1>
    </div>
    <div id="myCarousel2" class="vertical-slider carousel vertical slide col-md-12" data-ride="carousel" style="<?php if(empty($total_lunches)) { ?>display:none <?php } ?>">
      <div class="row">
        <div class="col-md-12"> <span data-slide="next" class="btn-vertical-slider next glyphicon glyphicon-circle-arrow-up " style="font-size: 30px"></span> </div>
      </div>
      <br>
      <!-- Carousel items -->
      <div class="carousel-inner">
	  <?php if(!empty($total_lunches)) { ?>
	  <?php $i=1; foreach($total_lunches as $lunches) : ?>
        <div class="item <?php if($i == 1) { ?>active<?php } ?>">
          <div class="col-sm-2"> <a href="javascript:void(0);"> <i style="background:url('<?php if(!empty($lunches->ceo_profile_pic)) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $lunches->ceo_profile_pic; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>') no-repeat scroll center center / cover  rgba(0, 0, 0, 0);" class="thumbnail ratingpic"></i></a> 
		  <span><?php echo $lunches->nickname ?><font><?php echo $lunches->first_name .' '. $lunches->last_name; ?></font></span>
            <p class="CEO">CEO at <?php echo $lunches->business_name; ?>!</p>
          </div>
          <div class="col-sm-10"> <a class="Descripción-btn" href="javascript:void(0);">A quienes podría interesarle</a>
            <p class="testimoanls-description"><?php echo $lunches->feedback; ?></p>
            <p> <a class="Descripción-btn" href="javascript:void(0);">A quienes podría interesarle</a> 
            <?php $j=1; while( $j <= 5 ) { ?>
				<i class="fa <?php if($lunches->rating >= $j) { ?>fa-star fillstar<?php } else { ?>fa-star-o<?php } ?>"></i>
			<?php $j++; } ?>
			
			</p>
          </div>
          <!--/row-fluid-->
          <div class="clearfix"></div>
        </div>
        <!--/item-->
	  <?php $i++; endforeach; } ?>
      </div>
      <div class="row">
        <div class="col-md-12"> <span data-slide="prev" class="btn-vertical-slider prev glyphicon glyphicon-circle-arrow-down" style="color: Black; font-size: 30px"></span> </div>
      </div>
    </div>
  </div>
</section>

