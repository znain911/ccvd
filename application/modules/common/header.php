<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Certificate Course on cardiovascular disease (CCDV)</title>
    <meta name="description" content="Distance Learning Programme">
    <link rel="shortcut icon" href="<?php echo base_url('frontend/'); ?>assets/img/favicon30f4.png?v=3">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('frontend/'); ?>assets/css/hexagons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('frontend/'); ?>assets/css/preload.min.css">
    <link rel="stylesheet" href="<?php echo base_url('frontend/'); ?>assets/css/plugins.min.css">
    <link rel="stylesheet" href="<?php echo base_url('frontend/'); ?>assets/css/style.light-blue-500.min.css">
    <link rel="stylesheet" href="<?php echo base_url('frontend/'); ?>assets/css/width-boxed.min.css" id="ms-boxed" disabled="">
	<link rel="stylesheet" href="<?php echo base_url('frontend/assets/css/custom.css'); ?>" />
    <!--[if lt IE 9]>
        <script src="<?php echo base_url('frontend/'); ?>assets/js/html5shiv.min.js"></script>
        <script src="<?php echo base_url('frontend/'); ?>assets/js/respond.min.js"></script>
    <![endif]-->
	<script src="<?php echo base_url('frontend/'); ?>assets/js/plugins.min.js"></script>
	<script type="text/javascript">
		var baseUrl = "<?php echo base_url(); ?>";
		var gettoken = "<?php echo $this->security->get_csrf_token_name(); ?>"
		var gettoken_hash = "<?php echo $this->security->get_csrf_hash(); ?>"
		var sqtoken_hash = "<?php echo $this->security->get_csrf_hash(); ?>"
	</script>
	<script src="<?php echo base_url('frontend/'); ?>assets/js/app.min.js"></script>
    <script src="<?php echo base_url('frontend/'); ?>assets/js/configurator.min.js"></script>
    <script src="<?php echo base_url('frontend/'); ?>assets/js/jquery.validate.js"></script>
	<script src="<?php echo base_url('frontend/'); ?>assets/js/custom/regjs.js"></script>
	<script src="<?php echo base_url('frontend/'); ?>assets/js/custom/regstudent.js"></script>
    <script src="<?php echo base_url('frontend/'); ?>assets/js/custom/regfaculty.js"></script>
    <script src="<?php echo base_url('frontend/'); ?>assets/js/custom/studentlogin.js"></script>
    <script src="<?php echo base_url('frontend/'); ?>assets/js/custom/teacherlogin.js"></script>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-82197818-2"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-82197818-2');
	</script>
  </head>
  <body>
  <!-- Modal -->
  <?php 
	$active_student = $this->session->userdata('active_student');
	$studentLogin = $this->session->userdata('studentLogin');
	
	$active_teacher = $this->session->userdata('active_teacher');
	$teacherLogin = $this->session->userdata('teacherLogin');
	
	$activate_link = $this->uri->segment(2);
	
	if($active_student !== NULL && $studentLogin === TRUE)
	{
		
		require_once APPPATH.'modules/common/student_login_header.php';
		
	}elseif($active_teacher !== NULL && $teacherLogin === TRUE){
		
		require_once APPPATH.'modules/common/teacher_login_header.php';
		
	}else{
		
		require_once APPPATH.'modules/common/main_header.php';
		
	}
  ?>