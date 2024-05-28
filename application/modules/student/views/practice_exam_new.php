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
		<link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/jquery.jdSlider.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/normalize.css">
        <link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/main.css">
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
			
			<div class="container-timing-bar">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 text-left">
							<div class="item-no">
								<strong>Total Questions : </strong><?php echo $limit; ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<strong>Time : </strong><?php echo $exam_time; ?> Minutes
							</div>
						</div>
						<div class="col-lg-6 text-right">
							<div class="timing-count-down" id="timeRemaining"></div>
						</div>
					</div>
				</div>
			</div>
			
			<?php 
				$attr = array('id' => 'examEndModule');
				echo form_open('', $attr);
			?>
			<div id="refreshArea">
				<?php require_once APPPATH.'modules/student/views/practice_question_new.php'; ?>
			</div>
			<?php echo form_close(); ?>
		</div>
        
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/jquery.jdSlider-latest.js"></script>
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/main.js"></script>
		
		<script type="text/javascript">
		<?php 
			$hour = $this->session->userdata('ex_hour');
			$minute = $this->session->userdata('ex_minute');
			$second = $this->session->userdata('ex_second');
			$get_default_time = $exam_time;
			if($hour !== null && $minute !== null && $second !== null):
		?>
		var countDownDate = <?php echo strtotime('+'.$hour.' hour '.$minute.' minute '.$second.' second') ?> * 1000;
		<?php else: ?>
		var countDownDate = <?php echo strtotime('+'.$get_default_time.' minute') ?> * 1000;
		<?php endif; ?>
		var now = <?php echo time() ?> * 1000;

		// Update the count down every 1 second
		var x = setInterval(function() {
			now = now + 1000;

			// Find the distance between now an the count down date
			var distance = countDownDate - now;

			// Time calculations for days, hours, minutes and seconds
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			
			if(minutes < 10){ 
				var formated_minutes = "0"+minutes;
			}else
			{
				var formated_minutes = minutes;
			}
			if(seconds < 10){ 
				var formated_seconds = "0"+seconds;
			}else
			{
				var formated_seconds = seconds;
			}
			
			if(document.getElementById("timeRemaining"))
			{
				// Output the result in an element with id="demo"
				document.getElementById("timeRemaining").innerHTML = "<strong>Time Remaining : </strong><strong style='font-weight:bold;color: #FFF;'>"+hours+":"+formated_minutes+ ":"+formated_seconds+"</strong>";

				// If the count down is over, write some text 
				if (distance < 0) {
					clearInterval(x);
					document.getElementById("timeRemaining").innerHTML = '<strong>Time Remaining : </strong><strong style="font-weight:bold;color: #a00;">Expired</strong>';
				}
				if(hours == '0' && minutes == '00' && seconds == '00')
				{
					$('#examEndModule').submit();
				}else
				{
					$.ajax({
					   type:"POST",
					   url: baseUrl + "student/exam/checktime",
					   data: {hour:hours, minute:minutes, second:seconds, _jwar_t_kn_:sqtoken_hash},
					   dataType: 'json',
					   cache: false,
					   success: function(data){
						   if(data.status == 'ok')
						   {
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
						   }else
						   {
							   //have error.
							   return false;
						   }
						   return false;
					   }
					});
				}
			}
			
		}, 1000);
		</script>
		
		<script type="text/javascript">
			$("#examEndModule").validate({
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "student/exam/practice_answersubmit",
						data : $('#examEndModule').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								if(data.end_of_exam == '1')
								{
									$('.container-timing-bar').remove();
								}
								$('#refreshArea').html(data.content);
								$('#loader').hide();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
				}
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '.btn-cncl', function(){
					if(confirm('Are you want to exit?'))
					{
						window.location.href=baseUrl+"student/course";
					}else
					{
						return false;
					}
				});
				
				$(document).on('click', '.btn-sbmt', function(){
					if(confirm('Are you want to submit?'))
					{
						return true;
					}else
					{
						return false;
					}
				});
			});
		</script>
		<script type="text/javascript">
			function remove_emptyli()
			{
				var get_ln = $('.last-li-q:last-child').children('div').length;
				if(get_ln == 0)
				{
					$('.last-li-q:last-child').remove();
				}
				
			}
		</script>
    </body>
</html>
