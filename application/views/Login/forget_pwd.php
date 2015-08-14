<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$page_url=current_url();
$cur_url = $page_url.'?'.$_SERVER['QUERY_STRING'];
?>
<body><div class="site-wrapper login-Register-wrapper">
  <div class="site-wrapper-inner">
    <div class="cover-container">
      <div class="masthead clearfix">
        <div class="inner">
          <h3 class="masthead-brand"><a href="<?php echo base_url(); ?>">RONDAS</a><hr></h3>
        </div>
      </div>
      <div class="inner cover">
	   <!--ADD CASE-->
	   <?php if( !isset($_GET['e']) && empty($_GET['e'])) { ?>
      	<p class="lead">Bienvenido a</p>
        <h1 class="cover-heading">RONDAS</h1>
        <p class="lead">La red social para CEOs</p>
		<div class=""><?php if( isset( $updatemsg ) ) { echo "<h2 class='login_message'>".$updatemsg."</h2>"; } ?></div>
        <div class="warning <?php if( !empty( $login_mess ) ) { echo "newmessagefalse"; } ?>"><?php if( !empty( $login_mess ) ) { echo $login_mess; } ?></div>
       
		<div class="form-div">
		
         <?php 
			$attributes = array( 'class' => 'form-horizontal', 'id' => 'forget_password_form',  );
			echo form_open('Login/GetPassword', $attributes); 
		?>
			<label for="inputUserName" class="col-md-3 control-label">Email:</label>
			<input type="text" placeholder="Email" name="for_username" class="form-login-control forget_input" id="for_username" value="<?php echo set_value('for_username'); ?>">

		<p class="lead">
			<input type="submit" value="Submit" name="submit" id="forget-submit" class="btn btn-lg btn-default"/>
			<?php echo form_close(); ?>
       </p></div>
		<p class="note">Enter Your email or username. We will send recovery link on your mail.</p>
		
		<?php } else { ?>

		<!--EDIT CASE-->
		<p class="lead">Bienvenido a</p>
			<h1 class="cover-heading">RONDAS</h1>
			<p class="lead">La red social para CEOs</p>.
			<div class=""><?php if( isset( $updatemsg ) ) { echo "<h2 class='login_message'>".$updatemsg."</h2>"; } ?></div>
			<div class="form-div">
			<?php 
				$attributes = array( 'class' => 'form-horizontal', 'id' => 'forget_password_form',  );
				echo form_open('Login/UpdatePassword', $attributes); 
			?>
				<input type="hidden" name="email_id" value="<?php echo base64_decode($_GET['e']); ?>">
				<input type="hidden" name="email_str" value="<?php echo $_GET['es']; ?>">
				<input type="hidden" name="c_url" value="<?php echo $cur_url;?>">
				<label for="inputUserName" class="col-md-3 control-label">Enter New Password:</label>
				<input type="password" placeholder="Password" name="new_password" class="form-login-control forget_input" id="for_username" value="">

			<p class="lead">
				<input type="submit" value="Submit" name="submit" id="forget-submit" class="btn btn-lg btn-default"/>
				<?php echo form_close(); ?>
		   </p></div>
			<p class="note">Enter Your email or username. We will send recovery link on your mail.</p>
	   <?php } ?>
	  </div>
    </div>