<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Certificate Course on Cardiovascular Disease (CCVD)</title>
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
							<div class="org-title">Certificate Course on Cardiovascular Disease (CCVD)</div>
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
							Notice for ECE Exams
						</h4>
						<p class="cnt-para">
                            <strong>IT IS IMPORTANT TO READ THE NOTICE BEFORE YOU PRESS “START”</strong> <br /><br />
                            The <strong>ECE EXAM</strong> is an <strong>ONLINE BASED EXAM</strong> that is <strong>TIME RESTRICTED</strong>. The <strong>TIME</strong> can be seen on the <strong>TOP RIGHT-HAND SIDE</strong> of the screen. Once you press Start, the countdown shall begin. You can end the exam if you press Submit. If the Time elapses before you Submit, then the Online ECE Exam shall end automatically.</br>
                            <strong>Please attempt the exam carefully because you will have 1 attempt to take the exam. After you submit or when the exam time finishes you will be directed to dashboard.</strong>
                            If for any reason you there is power outage or loss of internet coverage, then you shall be required to redo the ECE Exam.
                            <br />
                            Good Luck!
                        </p>
						<!-- <div class="start-exanchor text-center">
							<a href="<?php echo base_url('student/exam/index/ECE/Phase-D/START'); ?>" class="exstart-btn">Start Exam</a>
						</div> -->
						<div class="start-exanchor text-center">
						<?php $acdata = $this->Exam_model->getExamStatus();
								if($acdata->mrkconfig_exam_active == 1){?>
															<a href="<?php echo base_url('student/exam/index/ECE/Phase-D/START'); ?>" class="exstart-btn">Start Exam</a>
															<?php }else{
									echo '<h2 style="color: red;">Exam will be start at 04:00PM</h2>';
								}?>
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
