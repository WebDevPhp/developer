<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo $this->router->fetch_method().' --- '.$this->router->fetch_class();
?>

<script>
$(function(){
	$('.company-profile-section').css({"background":"url('<?php echo base_url() ?>/uploads/business/background/original/<?php echo $info['personal'][0]['background_img_url']; ?>')",'background-size': 'cover', 'background-repeat': 'no-repeat'});
})
</script>

<section class="company-profile-section">
<div class="cmpnybg_layer">
	<div class="comviewbg">
		<div class="container">
			<div class="company-profile-banner">
				<?php if(!empty($info['personal'][0]['logo_url'])) { ?>
				<h1><img class="b-logo" src="<?php echo base_url() ?>uploads/business/logo/<?php echo $info['personal'][0]['logo_url'];?>"></h1>
				<?php } else { ?>
				<h1><img class="b-logo" src="<?php echo base_url() ?>images/demo-logo150x150.jpg"></h1>
				<?php } ?>
				<p><?php echo $info['personal'][0]['description']; ?><?php echo anchor($info['personal'][0]['website_url'],'', array('target'=>'_blank')) ?></p>
			</div>
		</div>
	</div>
</div>
</section>

<!--section start here-->
<section class="container-fluid detalle-container">
  <div class="container">
    <div class="main-titel">
      <h1>Propuestas</h1>
    </div>

	<?php if( !empty($info['propdetails']) ) { ?>
	<?php foreach($info['propdetails'] as $getProposal) : ?>
<script>
$(function(){
	$('#bg'+<?php echo $getProposal['id']; ?>).css({"background":"url('<?php echo base_url() ?>uploads/proposal/<?php echo $getProposal['background_img_url']; ?>')",'background-size': 'cover', 'background-repeat': 'no-repeat'});
})
</script>

    <div class="row commentarios-row">
      <div class="row feed-row">
      <div class="col-sm-12">
        <div class="col-sm-10">
          <div class="feed-user comentario-pro"> 
			<i style="background:url('<?php if(!empty($info['personal'][0]['ceo_profile_pic'])) { ?><?php echo base_url(); ?>uploads/profile/64/<?php echo $info['personal'][0]['ceo_profile_pic']; ?><?php } else { ?><?php echo base_url(); ?>images/user30x30.jpg<?php } ?>')"></i>
			<span><?php echo ucfirst($info['personal'][0]['nickname']);?><font><?php echo ucwords($info['personal'][0]['first_name'].' '.$info['personal'][0]['last_name'] );?></font></span> 
		  </div>
      </div>
	 
	  <div class="col-sm-2 feed-date">
			<?php
				$actual_date = date("dS M Y", strtotime($info['propdetails'][0]['created_on'])); 
				$propdate = $info['propdetails'][0]['created_on'];
				$currentdate = date("Y-m-d H:i:s");
				$t1 = StrToTime ( $currentdate );
				$t2 = StrToTime ( $propdate );
				$diff = $t1 - $t2;
				$hours = $diff / ( 60 * 60 );
				$date1 = new DateTime($propdate);
				$date2 = new DateTime($currentdate);
				$diff = $date2->diff($date1);
			?>
			<?php
			if($hours > 24 && $hours < 48) { ?>
			  <p><?php echo $diff->format('%a Day ago'); ?></p>
			<?php } ?> 
			<?php if($hours > 48 && $hours < 720) { ?>
			  <p><?php echo $diff->format('%a Days ago'); ?></p>
			<?php } ?> 
			<?php if($hours > 720) { ?>
			  <p><?php echo $diff->format('%m Month ago'); ?></p>
			<?php } ?> 
			<?php if($hours < 24) { ?>
			  <p><?php echo ceil($hours) .' Hours ago'; ?></p>
			<?php } ?>
		  </div>
      <div class="col-sm-12 feed-banners" id="bg<?php echo $getProposal['id']; ?>">
        <div class="feed-banners-col">
				<?php if(!empty($info['personal'][0]['logo_url'])) { ?>
					<img width="150" src="<?php echo base_url(); ?>uploads/business/logo/150/<?php echo $info['personal'][0]['logo_url']; ?>" alt="">
				<?php } else { ?>
					<img width="150" src="<?php echo base_url(); ?>images/demo-logo150x150.jpg" alt="">
				<?php } ?>
			
          <h3><?php echo $getProposal['title']; ?></h3>
          <p><?php echo checkSubStr($getProposal['description']).'.....'; ?></p>
        </div>
      </div>
	   <div class="col-sm-12 feed-btn">
      	<p class="slider-btn-row"> <a class="slider-btns btn" href="#"><i class="Library"></i>JUST LUNCH</a>
        <!-- <a class="slider-btns btn1" href="Proposal-Details.html"> <i class="Library1"></i>MÁS INFO</a> -->
        <?php echo anchor('Proposal/ProposalDetail/'.$getProposal['id'], '<i class="Library1"></i>MÁS INFO', 'class="slider-btns btn1"'); ?><i class="Library1"></i></p>
        <div class="feed-rating-row">
        	<span class="star-col"> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> </span>
            <p title="" data-original-title="" class="popoverThis btn btn-large" id="popoverId4"><i class="Library3"></i>0</p>
            <div class="hide" id="popoverContent4">
              <h4 class="popover-title">Just Lunch CON</h4>
              <ul>
                <li>Pepe Ezquivel </li>
                <li>Carlos Bursich </li>
                <li>Marco Gutierrez .</li>
                <li>Hector Guyot</li>
              </ul>
            </div>
            <p title="" data-original-title="" class="popoverThis btn btn-large" id="popoverId5"><i class="Library4"></i>0</p>
            <div class="hide" id="popoverContent5">
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
            </div>
        </div>
        </div>
    </div>
    </div>
	<?php endforeach; ?>
	<?php } else { ?> 
		<div class="row feed-row"><p class="noprop">No Proposals Yet!</p></div>
   <?php  } ?> 
   </div>
</section>

<section class="categories-row">
	 <div class="container">
     	<div class="Experiencias"><h1>Categorías de interés</h1></div>
        <div class="col-sm-12">
        <?php 
			if(!empty($info['businessdetails'])) : 
				foreach ($info['businessdetails'] as $ind) : ?>
				<div class="col-sm-3 categories-col">
					<p><?php echo $ind['name']; ?></p>
				</div>
			<?php endforeach; endif; ?>
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