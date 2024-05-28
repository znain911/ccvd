<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Distance Learning Programme (DLP)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/jquery.jdSlider.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/normalize.css" />
        <link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/main.css" />
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
		<script src="<?php echo base_url('frontend/exam/assets/js/jquery.validate.js'); ?>"></script>
		<script type="text/javascript">
			var baseUrl = "<?php echo base_url(); ?>";
			var sqtoken_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
		</script>
	</head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="exam-container">
			<div class="container-logo-bar">
				<div class="top-bar-with-logo container">
					<div class="row">
						<div class="col-lg-12">
							<div class="logo"><img src="<?php echo base_url('frontend/tools/dlp.png'); ?>" alt="Logo" /></div>
							<div class="org-title">Distance Learning Programme (DLP)</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="simple-content-goes">
			<div class="container">
				<div class="col-lg-12">
					<div class="content-text-goes">
						<h4 class="cnt-title">
							Notice for Practice-Based Study
						</h4>
						<p class="cnt-para">
							<strong>IT IS IMPORTANT TO READ THE NOTICE BEFORE YOU PRESS “START”</strong> <br /><br />
							The Practice-Based Study is supposed to prepare Participants of CCD Online for the Online PCA Exams and eventually for the ECE Exams. The Practice-Based studies are short TIME-BASED tests to help you evaluate your learning from the content provided in the relevant lesson. <br /><br />
							The <strong>TIME</strong> can be seen on the <strong>TOP RIGHT-HAND SIDE</strong> of the screen. <br /><br />
							After you press Start, your time shall start. You can end by selecting Submit button. If the time elapses before you Submit, then the Practice-Based Study shall end automatically. <br /><br />
							At the end of the Practice-Based Study, you shall be provided a review of the correct and incorrect answers online. The results of the Practice-Based Study shall be sent by Email and SMS. <br /><br />
							You can revisit and choose to do the Practice-Based Study again. If you revisit the Practice-Based Study, then you shall be able to view the results of your last attempt. 
							<br /><br />
							Questions can change at each of your attempts.
							<br />
							Good Luck!
						</p>
						<div class="start-exanchor text-center">
							<a href="<?php echo $strt_exam; ?>" class="exstart-btn">Start Exam</a>
						</div>
					</div>
				</div>
			</div>
		</div>
        
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/jquery.jdSlider-latest.js"></script>
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/main.js"></script>
    </body>
</html>
