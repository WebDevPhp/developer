<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>
<div class="site-wrapper login-Register-wrapper">
  <div class="site-wrapper-inner">
    <div class="cover-container">
      <div class="masthead clearfix">
        <div class="inner">
          <h3 class="masthead-brand"><a href="<?php echo base_url(); ?>index.php/Feed">RONDAS</a> <hr></h3>
        </div>
      </div>
      <div class="inner cover">
      	<p class="lead">Bienvenido a</p>
        <h1 class="cover-heading">RONDAS</h1>
		<?php if( isset ( $message ) ) { echo "<h2 class='login_message'>".$message."</h2><h3 class='login_d'>".$message1."</h3>"; }; ?>
        <p class="lead">La red social para CEOs</p>
        <div class="warning <?php if( isset ( $logout_msg ) ) { echo "logoutmsg"; } ?>"><?php if( isset ( $logout_msg ) ) { echo $logout_msg; } ?></div>
		<?php if( isset ( $succ_msg ) ) { echo $succ_msg; } ?>
        <div class="form-div">
         <?php 		$attributes = array( 
							'class' 	=> 	"form-horizontal", 
							'name' 		=>	"login_form",
							'id' 		=>	"login_form",
						);
				echo form_open('Login/Feed', $attributes); ?>
				<input type="hidden" id="baseurl" value="<?php echo base_url(); ?>"/>
                <p class="input_main">
                    <label for="inputName" class="col-md-3 control-label">Email:</label>
                    <input type="text" name="username" id="Input_Login_Username"  placeholder="Email" class="form-login-control form-control"/>
				</p>
                <p class="input_main">
       				<label for="inputPassword" class="col-md-3 control-label">Password:</label>
       				<input type="password" id="Input_Login_Password" name="password" type="text" placeholder="password" class="form-login-control form-control" />
                </p>
        <p class="lead"><input type="submit" value="Sign in" name="submit" id="login-submit" class="btn btn-lg btn-default"/></p>
         <?php echo form_close(); ?>		 
         </div>
         <div>
			<?php echo anchor('Login/register', 'Register', 'class="btn"'); ?>
			<?php echo anchor('Login/ForgetPassword', 'Forget Password', 'class="btn"'); ?>
		 </div>
         
      </div>
    </div>