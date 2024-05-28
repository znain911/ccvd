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
							Notice for CCA-1 Exam
						</h4>
						<p class="cnt-para">
							<strong>IT IS IMPORTANT TO READ THE NOTICE BEFORE YOU PRESS “START”</strong> <br /><br />

							The <strong>CCA-1 EXAM</strong> is an <strong>ONLINE BASED EXAM</strong> that is <strong>TIME RESTRICTED</strong>. The TIME shall be restricted from <strong>4:00pm to 5:00pm</strong>. You must select Start Exam at the bottom of the screen to start the Online CCA-1 Exam. <br />
For students who enter late, the CCVD Course Administration is not liable for late entry. The Online CCA-1 Exam shall finish at 5:00pm.<br />
When answering the questions, please select Next to move to next question. If you feel the need to go back to previous question please select Previous. <br />
Please Do Not Refresh in the web browser during the Online CCA-1 Exam.<br /> 
Please Do Not Select Cancel because this will end Online CCA-1 Exam.<br /> 
Please select Submit after you attempt all questions. Please do not select Submit before you attempt all questions. If you select Submit, the Exam will end and you will not get another attempt.<br /> 
Once you select Start you will have till 5:00pm to finish the exam. At 5:00pm, the Exam shall end automatically.<br /> 
The Exam is total 50 marks. You are required to obtain 60% of the total marks to pass the exam.
You are required to pass the Online CCA-1 Exam in order to move to Chapter 2. <br /> 
At the end of the Online CCA-1 Exam you shall receive your exam results by SMS and Email. <br /> 
<br /> Good Luck!

						</p>
						<div class="start-exanchor text-center">
							<!-- <a href="<?php echo base_url('student/exam/index/PCA-1/Phase-A/START'); ?>" class="exstart-btn">Start Exam</a> -->
							<?php 
							$acdata = $this->Exam_model->getExamStatus();
if($acdata->mrkconfig_exam_active == 1){?>
<a href="<?php echo base_url('student/exam/index/PCA-1/Phase-A/START'); ?>" class="exstart-btn">Start Exam</a>
<?php }else{
	echo '<h2 style="color: red;">Exam will be start at 14-08-2020 04:00PM</h2>';
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
