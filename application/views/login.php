<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $this->config->item('app_abbr')?>::<?php echo $this->config->item('app_name').' '.$this->config->item('app_ver')?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="mmediadata.com">
<meta name="robots" content="noindex, nofollow">
<link href="<?php echo base_url()?>assets/css/login.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="shortcut icon" href="<?php echo base_url()?>assets/img/favicon.ico">

</head>

<body>

<!-- BODY -->
<div class="container">

  <header>
    <img src="<?php echo base_url()?>assets/img/logo.jpg" alt="Logo" width="310px" />
  </header>
  
  <?php if ($system_state==FALSE) :
	echo '<h5 class="warning">SISTEM OFFLINE</h5>';
	echo '<form><legend>'.$this->config->item('app_name').'</legend></form>';
	
	else:?>  

	<?php echo form_open(site_url('login/validate'), array('class'=>'form-horizontal', 'id'=>'form'))?>

	<legend><?php echo $this->config->item('app_name')?></legend>

  <div id="status"></div>
  <div id="loader"></div>

  <input type="text" name="usr" id="usr" placeholder="Username">
  <?php echo form_error('usr')?>

  <input type="password" name="pwd" id="pwd" placeholder="Password">
  <?php echo form_error('pwd')?>
  
  <input type="submit" class="btn" id="submit" value="Login">
  
	<?php echo form_close()?>
  
  <?php endif;?>
    
  <div class="require">
    <h5>Please use the browsers listed.</h5>
    <img src="<?php echo base_url('assets/img/browsers.png');?>" width="100" /><br />
    <span>Chrome, Firefox atau Opera.</span> 
  </div>

  <footer>
  	<hr>
    <small><?php 
    echo $this->config->item('app_name');
    echo ' - ';
    echo $this->config->item('app_abbr');
    echo ' ';
    echo $this->config->item('app_ver');
    ?></small>
  </footer>

</div><!-- /BODY -->

<script type="text/javascript">
document.getElementById("usr").focus();
</script>

</body>
</html>
