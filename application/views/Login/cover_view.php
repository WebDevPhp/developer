<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>
<div class="site-wrapper login-Register-wrapper">
  <div class="site-wrapper-inner">
   <div class="cover-container">
      <div class="masthead clearfix">
        <div class="inner">
          <h3 class="masthead-brand"><?php echo anchor('','RONDAS',array('class'=>'')); ?>
<hr></h3>
        </div>
      </div>
      <div class="inner cover">
      	<p class="lead">Bienvenido a</p>
        <h1 class="cover-heading">RONDAS</h1>
        <p class="lead">La red social para CEOs</p>
        <p class="lead"> 
			<?php echo anchor('Login','Sign in',array('class'=>'btn btn-lg btn-default coverbtn')); ?>
			<?php echo anchor('Login/Register','Register',array('class'=>'btn btn-lg btn-default coverbtn')); ?>
		</p>
      </div>
    </div>