<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Coordinator</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,700" rel="stylesheet" id="fontFamilySrc" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/css/animate.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/css/style.min.css" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
    
	<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
	<script src="<?php echo base_url('backend/assets/js/vendor/jquery-3.2.1.min.js'); ?>"></script>
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!--[if lt IE 9]>
	    <script src="<?php echo base_url('backend/'); ?>assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
</head>
<body class="pace-top font-roboto">

	<!-- begin #page-container -->
	<div id="page-container" class="page-container">
	    <!-- begin login -->
		<div class="login">
		    <!-- begin login-brand -->
            <div class="login-brand bg-inverse text-white">
                <img src="<?php echo base_url('backend/'); ?>assets/img/logo-white.png" height="36" class="pull-right" alt="" /> Login Panel
            </div>
		    <!-- end login-brand -->
		    <!-- begin login-content -->
            <div class="login-content">
				<?php 
					$attr = array('class' => 'form-input-flat', 'id' => 'recoverform');
					echo form_open('', $attr);
				?>
                    <div class="form-group">
                        <input type="text" class="form-control input-lg" placeholder="Enter your account email address" />
                    </div>
                    <div class="row m-b-20">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-lime btn-lg btn-block">Send Reset Code</button>
                        </div>
                    </div>
                    <div class="text-center">
                        back to login? <a href="<?php echo base_url('coordinator/login'); ?>" class="text-muted">Click here.</a>
                    </div>
					<div class="text-center">
                        <a href="<?php echo site_url(); ?>" class="text-muted"><strong>Back To Website</strong></a>
                    </div>
                <?php echo form_close(); ?>
            </div>
		    <!-- end login-content -->
		</div>
		<!-- end login -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	
</body>
</html>