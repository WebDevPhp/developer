<?php 
$userdata = json_decode($this->session->userdata('UserData'),true);
$userid = $userdata[0]['id'];
?>
<?php 
/* 	echo "<pre>";
	print_r($slides);
	echo "</pre>";
	exit; 
 */?>
<body>
<div class="slider2">
	<?php $i=1; if(!empty($slides)) { ?>
   <?php  foreach($slides as $slide) { ?>
    <div class="slide" style="background:url('<?php echo base_url(); ?>uploads/proposal/<?php echo $slide->proposal_bg; ?>');"> 
	 <div class="carousel-caption">
        <div class="carousel-caption-inner">
			<div class="user-detail-row"> 
				<i class="user-detail-img" style="background:url('<?php if(!empty($slide->ceo_profile_pic)) { ?><?php echo base_url(); ?>uploads/profile/64/<?php echo $slide->ceo_profile_pic; ?><?php } else { ?><?php echo base_url(); ?>images/user30x30.jpg<?php } ?>');">			
				</i>
				<p class="user-detail-col">
					<?php if($slide->proposal_ceo_id == $userid ) { ?>
					<a href="javascript:void(0)" class="spananchor" ><?php echo $slide->nickname; ?></a><br>
					<font><?php echo ucwords($slide->business_name); ?></font>
					<?php } else { ?>
					<?php echo anchor('CompanyProfileUser?ci='.base64_encode($slide->proposal_ceo_id).'&bs='.base64_encode($slide->business_id),$slide->nickname,array('class' => 'spananchor'));?><br><font><?php echo ucwords($slide->business_name); ?></font>
					<?php } ?>
				</p>
				<i class="company-logo slider_com_logo">
				<?php if(!empty($slide->business_logo)) { ?>
					<img width="150" src="<?php echo base_url(); ?>uploads/business/logo/150/<?php echo $slide->business_logo; ?>" alt="">
				<?php } else { ?>
					<img width="150" src="<?php echo base_url(); ?>images/demo-logo150x150.jpg" alt="">
				<?php } ?>
				</i>
			</div>
          <h1 class="slider-title"><?php echo $slide->proposal_title; ?></h1>
          <p class="slider-detail"><?php echo checkSubStr($slide->description).'.....'; ?></p>
          <div class="slider-rating-row"> 
			<span class="star-col"> 
				<i class="glyphicon glyphicon-star"></i> 
				<i class="glyphicon glyphicon-star"></i> 
				<i class="glyphicon glyphicon-star"></i> 
				<i class="glyphicon glyphicon-star"></i> 
				<i class="glyphicon glyphicon-star"></i> 
			</span>
            <p class="lunchpopup" onmouseover="lunchpopupshow(this);" onmouseout="lunchpopuphide();" data-original-title="" title="" pop-id="<?php echo $slide->proposal_id ?>">
			<i class="Library3"></i><?php if(!empty($slide->totallunch)) { echo $slide->totallunch; } else { echo "0"; } ?></p>
			<div style="position:relative">
				<div class="infopop" id="infopop<?php echo $slide->proposal_id ?>">
					<h4>JUST LUNCH</h4>
					<ul></ul>
				</div>
			</div>
            <p class="followbtn" onmouseover="followpopupshow(this);" onmouseout="followpopuphide();" data-original-title="" title="" pop-id="<?php echo $slide->proposal_id ?>">
			<i class="Library4"></i><?php if(!empty($slide->follow)) { echo $slide->follow; } else { echo "0"; } ?></p>
			 <div style="position:relative" id="f<?php echo $slide->proposal_id ?>">
				<div class="followpop" id="followpop<?php echo $slide->proposal_id ?>">
					<h4>Follows</h4>
					<ul></ul>
				</div>
			</div>
		 </div>
          <div class="clearfix"></div>
        </div>
        <p class="slider-btn-row"> 
		<a href="javascript:void(0)" class="slider-btns btn feed-just-lunch btndis<?php echo $slide->proposal_id ?>" current-ceo-id="<?php echo $userid; ?>" prop-ceo-id="<?php echo $slide->proposal_ceo_id; ?>" pro-id="<?php echo $slide->proposal_id; ?>" <?php if($slide->proposal_ceo_id == $userid) { ?>disabled="disabled"<?php } ?>><i class="Library5"></i><span>Just Lunch</span>	
		</a> 
		
		<?php echo anchor('Proposal/ProposalDetail/'.$slide->proposal_id, '<i class="Library6"></i>MÁS INFO', 'class="slider-btns btn"'); ?>
		<a href="javascript:void(0)" rel="<?php echo $slide->proposal_id ?>" prop-ceo="<?php echo $slide->proposal_ceo_id ?>" current-ceo="<?php echo $userid; ?>" class="slider-btns btn followbtn_Slider" <?php if($slide->proposal_ceo_id==$userid) { ?>disabled="disabled"<?php } ?>>
		<i class="Library7"></i>SEGUIR</a> </p>
      </div>
	</div>
	<?php $i++; } } else { ?>
	<div class="slide" style="background:#000;"> 
	
	<div class="carousel-caption">
		<div class="carousel-caption-inner">
		<div><h1>No proposal yet!</h1></div>
		<div class="clearfix"></div>
	</div>
	</div>
	</div>
	<?php } ?>
</div>

<?php 

	
	$feedpagenotification = "";
	
	if(!empty($getNotifications))
	{
		foreach($getNotifications as $no)
		{
			if($no['log_parent_id'] != 13)
			{
				$feedpagenotification[] = $no;
			}
		}
	}

	/* echo "<pre>";
	print_r($feedpagenotification);
	echo "</pre>"; */

?>

<!--section start here-->
<section class="container-fluid feed-container">
  <div class="container">
    <h4>Bienvenido a <strong>RONDAS</strong>, Este es tu home</h4>
	<div class="feeds">
	<?php if(!empty($feedpagenotification)) { ?>
	
		<?php foreach($feedpagenotification as $log) { ?>
		
				<!---------------------------Connection Request------------------------------------->
				<?php if($log['log_parent_id'] == 1) { ?>
					<div class="row feed-row loader-div" id="loader-div<?php echo $log['log_id'] ?>">
					  <div class="col-sm-12">
						<div class="col-sm-9">
							<div class="feed-user1"> 
								<?php if(!empty($log['logo_url'])) { ?>
								<i class="bs-logo"><img width="100%" src="<?php echo base_url(); ?>uploads/business/logo/150/<?php echo $log['logo_url']; ?>" alt=""></i>
								<?php } else { ?>
								<i class="bs-logo"><img width="100%" src="<?php echo base_url(); ?>images/demo-logo150x150.jpg" alt=""></i>
								<?php } ?>
								
								<span class="dd">
									<i class="req-pic" style="background:url('<?php if(!empty($log['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['ceo_profile_pic']; ?>
									<?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>');"></i></span> 
								<p class="c1"><?php echo anchor('CompanyProfileUser?ci='.base64_encode($log['performed_by_ceo']).'&bs='.base64_encode($log['business_id']),$log['nickname']);?><font><?php echo $log['business_name']; ?></font></p> 
							</div>
							<div class="new-sction">
								<p class="c3">Nueva solicitud de conexión</p>
								<p class="c2"><?php echo $log['first_name'].' '.$log['last_name']; ?> quiere conectarse contigo</p>
							</div>
						</div>
						<div class="col-sm-3 feed-date"><p><?php echo $log['newlogtime']; ?></p>
											
						<div class="req-btn-acepter">
							<button class="proposal-submit-reg connection-button" state=1 requester="<?php echo $log['performed_by_ceo']; ?>" task_id="<?php echo $log['task_id']; ?>" log_id="<?php echo $log['log_id']; ?>" current_user="<?php echo $log['performed_to_ceo']; ?>">Acepter</button>
							<button class="proposal-submit-reg connection-button" state=0 requester="<?php echo $log['performed_by_ceo']; ?>" task_id="<?php echo $log['task_id']; ?>" log_id="<?php echo $log['log_id']; ?>" current_user="<?php echo $log['performed_to_ceo']; ?>">Decliner</button>
						</div>
						</div>
						</div>
						<span class="lunch-loader"></span>
					</div>
				
				<?php } ?>
			
				
				<!---------------------------Connection Request Accept Response---------------------------------->
				<?php if($log['log_parent_id'] == 2) { ?>
				<div class="row feed-row">
					  <div class="col-sm-12">
						<div class="col-sm-9">
							<div class="feed-user1"> 
								<?php if(!empty($log['logo_url'])) { ?>
								<i><img width="100%" src="<?php echo base_url(); ?>uploads/business/logo/150/<?php echo $log['logo_url']; ?>" alt=""></i>
								<?php } else { ?>
								<i><img width="100%" src="<?php echo base_url(); ?>images/demo-logo150x150.jpg" alt=""></i>
								<?php } ?>
								
								<i class="req-pic" style="background:url('<?php if(!empty($log['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['ceo_profile_pic']; ?>
								<?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>');"></i>
								
								
								<p class="c1"><?php echo $log['nickname']; ?><font><?php echo $log['first_name']." ".$log['last_name']; ?></font></p> 
							</div>
							<div class="new-sction">
								<p class="c2">Felicitaciones</p>
								<p class="c3">¡Te has conectado con <?php echo $log['nickname']; ?>!</p>
								<p class="c2"><?php echo $log['first_name']." ".$log['last_name']; ?> y tú ahora son contactos </p>
							</div>
						</div>
						<div class="col-sm-3 feed-date">
							<p><?php echo $log['newlogtime']; ?></p>
							<div class="new-sction1">
							<i class="fa fa-comments"></i>
							</div>
							<p class="c4">Enviale un mensaje</p>
						</div>
						</div>
				 </div>
				<?php } ?>

				
				<?php if($log['log_parent_id'] == 5) { ?>
				
					<div class="row feed-row" style="<?php if(!empty($log['proposal_background_img'])) { ?>background:url('<?php echo base_url() ?>uploads/proposal/<?php echo $log['proposal_background_img'] ?>'); background-size:cover; background-position:center;<?php } ?>">
					  <div class="col-sm-12">
						<div class="col-sm-10">
						  <div class="feed-user comentario-pro">
							<i style="background:url('<?php if(!empty($log['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>');"></i>
							<span>
							<?php if($log['proposal_ceo'] != $userid) { ?>
							<?php echo anchor('CompanyProfileUser?ci='.base64_encode($log['proposal_ceo']).'&bs='.base64_encode($log['business_id']),$log['nickname'],array('class' => 'spananchor'));?>
							<?php } else { ?>
								<a href="javascript:void(0)" class="spananchor" ><?php echo $log['nickname']; ?></a>
							<?php } ?>
							<font><?php echo ucwords($log['business_name']); ?></font>
							</span> 
							
						 </div>
						  <p class="feed-coment">Público una nueva propuesta</p>
						</div>
						<div class="col-sm-2 feed-date">
							<p><?php echo $log['newlogtime']; ?></p>
						</div>
					  </div>
					  <div class="col-sm-12 feed-banners bgfeed<?php echo $log['proposal_id']; ?>">
						<div class="feed-banners-col">
							<?php if(!empty($log['logo_url'])) { ?>
								<i><img width="150" src="<?php echo base_url(); ?>uploads/business/logo/150/<?php echo $log['logo_url']; ?>" alt=""></i>
							<?php } else { ?>
								<i><img width="150" src="<?php echo base_url(); ?>images/demo-logo150x150.jpg" alt=""></i>
							<?php } ?>
							<h3><?php echo anchor('Proposal/ProposalDetail/'.$log['proposal_id'],$log['title'],array('style'=>'color:#1aaeca')); ?></h3>
						  <p><?php echo checkSubStr($log['description']).'.....'; ?></p>
						</div>
					  </div>
					  <div class="col-sm-12 feed-btn">
						<p class="slider-btn-row"> 
							<a href="javascript:void(0)" class="slider-btns btn feed-just-lunch btndis<?php echo $log['proposal_id']; ?>" current-ceo-id="<?php echo $userid; ?>" prop-ceo-id="<?php echo $log['proposal_ceo']; ?>" pro-id="<?php echo $log['proposal_id']; ?>" <?php if($log['proposal_ceo'] == $userid) { ?>disabled="disabled"<?php } ?>>
							<i class="Library"></i>
							<span>Just Lunch</span>
							</a> 
							<?php echo anchor('Proposal/ProposalDetail/'.$log['proposal_id'], '<i class="Library1"></i>MÁS INFO', 'class="slider-btns btn1"'); ?>
							<a href="javascript:void(0)" class="slider-btns btn followbtn_page" <?php if($log['proposal_ceo']==$userid) { ?>disabled="disabled"<?php } ?> rel="<?php echo $log['proposal_id']; ?>" prop-ceo="<?php echo $log['proposal_ceo']; ?>" current-ceo="<?php echo $userid; ?>"><i class="Library2"></i>SEGUIR</a> 
						</p>
						<div class="feed-rating-row">
							<span class="star-col"> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> </span>
							<p onmouseover="feedlunchpropshow(<?php echo $log['proposal_id']; ?>);" onmouseout="feedlunchprophide(<?php echo $log['proposal_id']; ?>);" class="popoverThis btn btn-large p_lunch" data-original-title="" title=""><i class="Library3"></i><?php echo $log['totallunches']; ?></p>
							<div id="lu<?php echo $log['proposal_id']; ?>" class="lu-pop">
							  <h4 class="popover-title">Just Lunch</h4>
							  <ul>
								<li>Pepe Ezquivel </li>
								<li>Carlos Bursich </li>
								<li>Marco Gutierrez.</li>
								<li>Hector Guyot</li>
							  </ul>
							</div>
							<p onmouseover="feedfollowpropshow(<?php echo $log['proposal_id']; ?>);" onmouseout="feedfollowprophide(<?php echo $log['proposal_id']; ?>);" class="popoverThis btn btn-large p_follows" data-original-title="" title=""><i class="Library4"></i><?php echo $log['totalfollows']; ?></p>
							<div id="fo<?php echo $log['proposal_id']; ?>" class="fo-pop">
								<h4 class="popover-title">Follows</h4>
								  <ul>
									<li>Pepe Ezquivel </li>
									<li>Carlos Bursich </li>
									<li>Marco Gutierrez .</li>
									<li>Hector Guyot</li>
								  </ul>
							</div>
						</div>
						</div>
					</div>
				<?php } ?>
				<!---------------------------Comment on Proposal------------------------------------->
			
				<?php if($log['log_parent_id'] == 8) { ?>
				
					<div class="row feed-row">
					<div class="col-sm-12">
					<div class="col-sm-10">
					<div class="feed-user comentario-pro">
					<i style="background:url('<?php if(!empty($log['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>');"></i> 
					<span><?php echo anchor('CompanyProfileUser?ci='.base64_encode($log['performed_by_ceo']).'&bs='.base64_encode($log['performed_by_ceo']),$log['commenter_nickname'],array('class' => 'spananchor'));?><font><?php echo $log['commenter_fname'] .' '.$log['commenter_lname']; ?></font></span> </div>
					<p class="feed-coment">Comentó en la propuesta de<font><?php echo $log['receiver_nickname']; ?> <?php echo anchor('Proposal/ProposalDetail/'.$log['proposal_id'],'"'. $log['title'] .'"');?><br></font></p>
					</div>
					<div class="col-sm-2 feed-date">
						<p><?php echo $log['newlogtime']; ?></p>
					</div>
					</div>
					<div class="col-sm-12 feed-text-col">
						<p><?php echo $log['message']; ?></p>
					</div>
					</div>
					
				<?php } ?>
				
				
				<!---------------------------Lunch Request------------------------------------->
				<?php if($log['log_parent_id'] == 11) { ?>
					<div class="row lunch-row loader-div" id="loader-div<?php echo $log['log_id'] ?>" style="<?php if(!empty($log['proposal_background'])) { ?>background:url('<?php echo base_url() ?>uploads/proposal/<?php echo $log['proposal_background'] ?>'); background-size:cover; background-position:center;<?php } ?>">
					<p class="feed-date"><?php echo $log['newlogtime']; ?></p>
					<div class="lunch-main">

					<div class="just-lunch-col-div">
					<span class="span-lunch-img"><i class="lunch-req-pic" style="background:url('<?php if(!empty($log['requester_ceo_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['requester_ceo_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>');"></i> </span>

					<p class="nc"><?php echo $log['requester_ceo_nickname']; ?><font><?php echo $log['business_name']; ?></font></p>
					<h3><i class="glyphicon glyphicon-ok-circle"></i>JUST LUNCH</h3>
					<a class="slider-btns2 btn lunchrequest" state=1 requester="<?php echo $log['performed_by_ceo']; ?>" task_id="<?php echo $log['task_id']; ?>" log_id="<?php echo $log['log_id']; ?>" business_id="<?php echo $log['business_id']; ?>" current_user="<?php echo $log['performed_to_ceo']; ?>"  lunch_on_proposal="<?php echo $log['proposal_title']; ?>" requester_nick="<?php echo $log['requester_ceo_nickname']; ?>"  proposal_id="<?php echo $log['lunch_proposal_id']; ?>" href="javascript:void(0)">Aceptar</a>
					<a class="slider-btns2 btn lunchrequest" state=0 requester="<?php echo $log['performed_by_ceo']; ?>" task_id="<?php echo $log['task_id']; ?>" log_id="<?php echo $log['log_id']; ?>" business_id="<?php echo $log['business_id']; ?>" current_user="<?php echo $log['performed_to_ceo']; ?>"  lunch_on_proposal="<?php echo $log['proposal_title']; ?>" requester_nick="<?php echo $log['requester_ceo_nickname']; ?>"  proposal_id="<?php echo $log['lunch_proposal_id']; ?>" href="javascript:void(0)">Declinar</a>
					</div>
					</div>
					<span class="lunch-loader"></span>
					</div>
				<?php } ?>
				
				
				<!---------------------------Lunch Request Accept------------------------------------->
				
				<?php if($log['log_parent_id'] == 12) { ?>
				
						<div class="row lunch-row" style="<?php if(!empty($log['proposal_background'])) { ?>background:url('<?php echo base_url() ?>uploads/proposal/<?php echo $log['proposal_background'] ?>'); background-size:cover; background-position:center;<?php } ?>">
						<p class="feed-date"><?php echo $log['newlogtime']; ?></p>
						<div class="lunch-main">
						<hr>
						<div class="lunch-user">
							
							<i class="feed-lunch-pic" style="background:url('<?php if(!empty($log['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>');"></i> 
							
							<!--<i><img src="<?php echo base_url(); ?>images/Foto-Alejandro-lunch.jpg" alt=""></i>-->
							
							<p><?php echo $log['proposal_ceo_nickname']; ?>
								<font><?php echo $log['proposal_ceo_fname'].' '.$log['proposal_ceo_lname']; ?></font>
							</p>
						</div>
						<div class="just-lunch-col feedlunchcol">
							<?php if(!empty($log['proposal_ceo_business_logo'])) { ?>
							<i><img width="100%" src="<?php echo base_url(); ?>uploads/business/logo/150/<?php echo $log['proposal_ceo_business_logo']; ?>" alt=""></i>
							<?php } else { ?>
							<i><img width="100%" src="<?php echo base_url(); ?>images/demo-logo150x150.jpg" alt=""></i>
							<?php } ?>
							<!--<i><img src="<?php echo base_url(); ?>images/san-logo.png" alt=""></i>-->
							
							<h3><i class="glyphicon glyphicon-ok-circle"></i>JUST LUNCH</h3>
							<p><?php echo $log['proposal_title']; ?></p>
						</div>
						<div class="lunch-user lunch-user-2">
							
							<i class="feed-lunch-pic" style="background:url('<?php if(!empty($log['requester_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['requester_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>');"></i> 
							
							<p><?php echo $log['requester_nick']; ?><font><?php echo $log['requester_fn'].' '.$log['requester_ln']; ?></font></p>
						</div>         
						</div>
						</div>  
				<?php } ?>
			<!-------------------------------Lunch Rating------------------------------------->	
			
			<?php if($log['log_parent_id'] == 14) { ?>
			
			<div class="row feed-row feed-bottom" style="<?php if(!empty($log['proposal_background'])) { ?>background:url('<?php echo base_url() ?>uploads/proposal/<?php echo $log['proposal_background'] ?>'); background-size:cover; background-position:center;<?php } ?>">
				<div class="col-sm-12">
				<div class="col-sm-12 feed-date">
				 	<p><?php echo $log['newlogtime']; ?></p>
				</div>
			  </div>
			  <div class="clearfix"></div>
			  <div class="feed-content1-col">
					  <div class="col-sm-12">
				  <div class="feed-user2 comentario-pro"><i style="background:url('<?php if(!empty($log['rater_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['rater_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>')"></i> <span><?php echo $log['rater_nick']; ?><font><?php echo $log['rater_fn']. ' '. $log['rater_ln']; ?></font></span> </div>
				  <p class="feed-coment1">Dejó una experiencia <font><?php echo $log['req_nick']; ?> "<?php echo anchor('Proposal/ProposalDetail/'.$log['lunch_proposal_id'], $log['proposal_title'], ''); ?>"</font></p>
				</div>
				<p><?php echo $log['requester_feedback']; ?>
				<span>
					<?php $i=1; while( $i <= 5 ) { ?>
						<i class="fa <?php if($log['requester_rating'] >= $i) { ?>fa-star fillstar<?php } else { ?>fa-star-o<?php } ?>"></i>
					<?php $i++; } ?>
				</span>
				</p>
			  </div>
			 </div>
			
			<?php } ?>
				
			<!---------------------------Follow Proposal------------------------------------->
			
				<?php if($log['log_parent_id'] == 15) { ?>
				
					<div class="row feed-row">
					<div class="col-sm-12">
					<div class="col-sm-10">
					<div class="feed-user comentario-pro">
					<i style="background:url('<?php if(!empty($log['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>');"></i> 
					<span><?php echo anchor('CompanyProfileUser?ci='.base64_encode($log['performed_by_ceo']).'&bs='.base64_encode($log['performed_by_ceo']),$log['first_name'] .' '. $log['last_name'],array('class' => 'spananchor'));?></span> </div>
					<p class="feed-coment">Start follow proposal "<font> <?php echo anchor('Proposal/ProposalDetail/'.$log['proposal_id'],'"'. $log['title'] .'"');?><br></font></p>
					</div>
					<div class="col-sm-2 feed-date">
						<p><?php echo $log['newlogtime']; ?></p>
					</div>
					</div>
					</div>
					
				<?php } ?>	
				
			
			<!---------------------------Connection Profile Update------------------------------------->
			
			<?php if($log['log_parent_id'] == 20) { ?>
				
				<div class="row feed-row">
				  <div class="col-sm-12">
					<div class="col-sm-10">
					  <div class="feed-user comentario-pro"> 
						  <i style="background:url('<?php if(!empty($log['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/150/<?php echo $log['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user64x64.jpg<?php } ?>');"></i> 
						  <span><?php echo anchor('CompanyProfileUser?ci='.base64_encode($log['updater_ceo_id']).'&bs='.base64_encode($log['updater_business_id']),$log['nickname']);?><font><?php echo $log['business_name']; ?></font></span> 
					  </div>
					  <p class="feed-coment"><font><?php echo $log['nickname'] ?></font> actualizó su perfil</p>
					</div>
					<div class="col-sm-2 feed-date">
						<p><?php echo $log['newlogtime']; ?></p>
					</div>
				  </div>
				</div>
				
			<?php } ?>
	
		<?php } ?>
		
	<?php } else { ?> 
		<div class="row feed-row"><p class="noprop">No Feeds Yet!</p></div>
   <?php  } ?> 
   </div>
	</div>
	
</section>


<?php 

	function checkSubStr($string){
		
		$line	=	$string;
		if (preg_match('/^.{1,200}\b/s', $string, $match))
		{
			$line=$match[0];
		}
		return $line;
	}
?>