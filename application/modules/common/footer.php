    <?php 
		if($active_student !== NULL && $studentLogin === TRUE)
		{
			
			echo null;
			
		}elseif($active_teacher !== NULL && $teacherLogin === TRUE){
			
			echo null;
			
		}else{
	?>
	<div class="footer-container">
		<div class="container">
			<div class="">
				<div class="footer-box">
					<div class="row">
						<div class="col-lg-5">
							<?php 
								$get_contactinfo = $this->Common_model->get_footerinfo();
							?>
							<div class="footer-left">
								<p style="text-transform:uppercase;">&copy; copyright 2019</p>
								<h2><?php echo $get_contactinfo['title']; ?><br><span style="color:#ffffff; font-size: 15px;">A Center for Cardio Vascular, Neuroscience & Organ Transplant Units</span></h2>
								<p><?php echo $get_contactinfo['config_address']; ?>
								</p>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="footer-middle">
								<h2>Follow Us On</h2>
								<div class="social-buttin">
									
									<?php 
										$get_sociallink = $this->Common_model->get_footersociallink();
									?>

									<?php foreach ($get_sociallink as $slink){?>	
									
									<a href="<?php echo $slink->link;?>" target="_blank" class="hb-xs-margin"><span class="hb hb-xs hb-<?php echo $slink->title;?>"><i class="fa fa-<?php echo $slink->title;?>"></i></span></a>
									<?php }?>
									
								</div>
								<p>
									Join us our channels to get updates and latest news about programme.
								</p>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="footer-right">
								<div class="footer-page-link">
									<ul class="left-pages">
										<?php 
											$get_menulink = $this->Common_model->get_footermenulink();
											?>

											<?php foreach ($get_menulink as $fmenu) {?>	
											<li><a href="<?php echo $fmenu->link;?>"><?php echo $fmenu->title;?></a></li>
										<?php }?>
										<!-- <li><a href="<?php echo site_url(); ?>">home</a></li>
										<li><a href="#landingFaqs" class="enable-scroll">faq</a></li>
										<li><a href="">sitemap</a></li>
										<li><a href="<?php echo base_url('contact'); ?>">contact us</a></li> -->
									</ul>
									<ul class="right-pages">
										<?php 
											$get_link = $this->Common_model->get_implink();
											?>
										<?php foreach ($get_link as $impl) {?>	
											<li><a href="<?php echo $impl->link;?>"><?php echo $impl->title;?></a></li>
										<?php }?>		

										<?php 
											$get_footer_pages = $this->Common_model->get_pages($location=2);
											foreach($get_footer_pages as $page):
										?>
										<!-- <li><a href="<?php echo base_url('page/'.$page['page_slug']); ?>"><?php echo $page['page_title']; ?></a></li> -->
										<?php endforeach; ?>
									</ul>
								</div>
								<div class="copyright">
									<h3>Powered by ct vulcan</h3>
									<h2><span>ct</span> health ltd</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php	} ?>
	
	<!-- ms-site-container -->
    <div class="ms-slidebar sb-slidebar sb-left sb-style-overlay" id="ms-slidebar">
      <div class="sb-slidebar-container">
        <ul class="ms-slidebar-menu" id="slidebar-menu" role="tablist" aria-multiselectable="true">
          <li class="card" role="tab" id="sch1">
            <a class="collapsed" role="button" href="<?php echo site_url(); ?>">
              <i class="zmdi zmdi-home"></i> Home </a>
          </li>
          <li class="card" role="tab" id="sch2">
            <a class="collapsed" role="button" data-target="#myModal7" data-toggle="modal" href="javascript:void(0)">
              <i class="zmdi zmdi-account-circle"></i> Register For Account </a>
          </li>
          <li class="card" role="tab" id="sch4">
            <a class="collapsed enable-scroll" role="button" href="#landingFaqs">
              <i class="zmdi zmdi-help"></i> Faq </a>
          </li>
          <li class="card" role="tab" id="sch5">
            <a class="collapsed" role="button" href="<?php echo base_url('contact'); ?>">
              <i class="zmdi zmdi-email"></i> Contact Us </a>
          </li>
          <li class="card" role="tab" id="sch6">
            <a class="collapsed" role="button" href="<?php echo base_url('support'); ?>">
              <i class="zmdi zmdi-email"></i> Support </a>
          </li>
        </ul>
      </div>
    </div>
	
	<div class="modal modal-info" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
		<div class="modal-dialog animated zoomIn animated-3x" role="document">
		  <?php 
			$attributes = array('id' => 'regType');
			echo form_open('javascript:void(0);', $attributes);
		  ?>
		  <div class="modal-content">
			<div class="modal-header">
			  <h3 class="modal-title" id="myModalLabel7">Registration</h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">
				  <i class="zmdi zmdi-close"></i>
				</span>
			  </button>
			</div>
			<div class="modal-body">
			  <div class="form-group row justify-content-end">
				<label class="col-lg-2 control-label"></label>
				<div class="col-lg-10">
				  <div class="radio radio-primary">
					<label>
					  <input type="radio" name="regfor" id="optionsRadios1" value="0" checked /> &nbsp; Register As Student 
					</label>
				  </div>
				  <!--<div class="radio radio-primary">
					<label>
					  <input type="radio" name="regfor" id="optionsRadios2" value="1" /> &nbsp; Register As Faculty 
					</label>
				  </div>-->
				</div>
			  </div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-info btn-raised" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn  btn-info btn-raised">Go to registration</button>
			</div>
		  </div>
		  </form>
		</div>
	</div>
	
	<div class="modal modal-info" id="myModalLoign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
		<div class="modal-dialog animated zoomIn animated-3x" role="document">
		  <?php 
			$attributes = array('id' => 'loginType');
			echo form_open('javascript:void(0);', $attributes);
		  ?>
		  <div class="modal-content">
			<div class="modal-header">
			  <h3 class="modal-title" id="myModalLabel7">Login</h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">
				  <i class="zmdi zmdi-close"></i>
				</span>
			  </button>
			</div>
			<div class="modal-body">
			  <div class="form-group row justify-content-end">
				<label class="col-lg-2 control-label"></label>
				<div class="col-lg-10">
				  <div class="radio radio-primary">
					<label>
					  <input type="radio" name="login_as" id="optionsRadios1" value="0" checked /> &nbsp; Login As Student 
					</label>
				  </div>
				  <div class="radio radio-primary">
					<label>
					  <input type="radio" name="login_as" id="optionsRadios2" value="1" /> &nbsp; Login As Faculty 
					</label>
				  </div>
				  <div class="radio radio-primary">
					<label>
					  <input type="radio" name="login_as" id="optionsRadios3" value="2" /> &nbsp; Login As Coordinator 
					</label>
				  </div>
				</div>
			  </div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-info btn-raised" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn  btn-info btn-raised">Go to Login</button>
			</div>
		  </div>
		  </form>
		</div>
	</div>
	
	<div class="modal modal-info" id="myModalDeposit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
		<div class="modal-dialog animated zoomIn animated-3x" role="document">
		  <?php 
			$attributes = array('id' => 'depositType');
			echo form_open('javascript:void(0);', $attributes);
		  ?>
		  <div class="modal-content">
			<div id="depositLoader" class="loader disable-select"><img alt="" class="disable-select" src="<?php echo base_url('frontend/tools/loader.gif'); ?>"></div>
			<div class="modal-header">
			  <h3 class="modal-title" id="myModalLabel7">Upload Deposit Slip</h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">
				  <i class="zmdi zmdi-close"></i>
				</span>
				<?php 
					if(isset($_GET['SID']) && $_GET['SID'] !== ''){
				?>
				<input type="hidden" name="portid" value="<?php echo $_GET['SID']; ?>" />
				<?php } ?>
			  </button>
			</div>
			<div class="modal-body">
			  <div id="errmsg" class="text-center"></div>
			  <div class="form-group row justify-content-end">
				<div class="col-lg-12">
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Bank Name</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="bank_name" placeholder="Enter Bank Name" />
					  </div>
					</div>
					
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Account Number</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="ac_number" placeholder="Enter Account Number" />
					  </div>
					</div>
					
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Branch Name</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="branch_name" placeholder="Enter Branch Name" />
					  </div>
					</div>
					
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Deposit Slip</label>
					  <div class="col-md-7">
							<input type="hidden" name="payment" value="Admission" />
							<input type="hidden" name="amount" value="<?php echo (isset($fee_info) && $fee_info['pconfig_course_fee'])? number_format($fee_info['pconfig_course_fee'],0) : null; ?>" />
							<input type="file" style="position:static !important;opacity:1 !important;" name="slip" />
					  </div>
					</div>
				</div>
			  </div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-info btn-raised" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn  btn-info btn-raised">Upload Slip</button>
			</div>
		  </div>
		  </form>
		</div>
	</div>
	
	<div class="modal modal-info" id="myModalUpMrks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
		<div class="modal-dialog animated zoomIn animated-3x" role="document">
		  <?php 
			$attributes = array('id' => 'upMrks');
			echo form_open('javascript:void(0);', $attributes);
		  ?>
		  <div class="modal-content">
			<div id="depositLoader" class="loader disable-select"><img alt="" class="disable-select" src="<?php echo base_url('frontend/tools/loader.gif'); ?>"></div>
			<div class="modal-header">
			  <h3 class="modal-title" id="myModalLabel7">Upload Marks</h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">
				  <i class="zmdi zmdi-close"></i>
				</span>
			  </button>
			</div>
			<div class="modal-body">
			  <div id="errmsg" class="text-center"></div>
			  <div class="form-group row justify-content-end">
				<div class="col-lg-12">
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Score</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="score" placeholder="Enter Score" />
					  </div>
					</div>
					
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Total Score</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="total_score" placeholder="Enter Total Score" />
					  </div>
					</div>
					
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Attendance</label>
					  <div class="col-md-7">
						<select name="attendance" class="form-control">
							<option value="1">Present</option>
							<option value="2">Absent</option>
						</select>
					  </div>
					</div>
				</div>
			  </div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-info btn-raised" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn  btn-info btn-raised">Submit Marks</button>
			</div>
		  </div>
		  </form>
		</div>
	</div>
	
	<div class="modal modal-info" id="sendOtp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
		<div class="modal-dialog animated zoomIn animated-3x" role="document">
		  <?php 
			$attributes = array('id' => 'sendOtpForm');
			echo form_open('javascript:void(0);', $attributes);
		  ?>
		  <div class="modal-content">
			<div class="modal-header">
			  <h3 class="modal-title" id="myModalLabel7">OTP</h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">
				  <i class="zmdi zmdi-close"></i>
				</span>
			  </button>
			</div>
			<div class="modal-body">
			  <p>We have sent you an otp via SMS....</p>
			  <p id="otpMessaging"></p>
			  <div class="form-group row justify-content-end">
				<label class="col-lg-2 control-label">OTP</label>
				<div class="col-lg-10">
				  <input type="text" class="form-control" name="otp" placeholder="Enter OTP" />
				</div>
			  </div>
			</div>
			<div class="modal-footer">
			  <input type="hidden" name="lesson" id="getLesson" />
			  <button type="button" class="btn btn-info btn-raised" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn  btn-info btn-raised">Download Lesson</button>
			</div>
		  </div>
		  </form>
		</div>
	</div>
	
	<div class="modal modal-info" id="viewCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
		<div class="modal-dialog animated zoomIn animated-3x" role="document">
		  <div class="modal-content" id="viewCourseContent"></div>
		</div>
	</div>
	
	<div class="modal modal-info" id="viewStudentRatings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
		<div class="modal-dialog animated zoomIn animated-3x" role="document">
		  <div class="modal-content" style="width: 715px !important;padding: 15px;">
			<div class="modal-header">
				  <h3 class="modal-title" id="myModalLabel7">Evaluation To Faculty</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
					  <i class="zmdi zmdi-close"></i>
					</span>
				  </button>
			</div>
			<div id="viewStudentRatingsContent"></div>
		  </div>
		</div>
	</div>
	
	<div class="modal modal-info" id="viewFacultyRatings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
		<div class="modal-dialog animated zoomIn animated-3x" role="document">
		  <div class="modal-content" style="width: 715px !important;padding: 15px;">
			<div class="modal-header">
				  <h3 class="modal-title" id="myModalLabel7">Evaluation To Student</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
					  <i class="zmdi zmdi-close"></i>
					</span>
				  </button>
			</div>
			<div id="viewFacultyRatingsContent"></div>
		  </div>
		</div>
	</div>
    
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.booking-now-bttun', function(){
				var get_for = $(this).attr('data-for');
				$('.indicator-'+get_for).show();
				$('.booking-frm-'+get_for).show();
			});
			
			$(document).on('change', '#sdtCenterDetails', function(){
				var cntr_id = $(this).val();
				$('#suggestBdetails').html('');
				$.ajax({
					type : "POST",
					url : baseUrl + "student/booking/cntrsdl_details",
					data : {cntr_id:cntr_id},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#suggestBdetails').html(data.content);
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
			});
			
			$(document).on('change', '#workshopCenterDetails', function(){
				var cntr_id = $(this).val();
				$('#suggestBdetails').html('');
				$.ajax({
					type : "POST",
					url : baseUrl + "student/booking/workshop_cntrsdl_details",
					data : {cntr_id:cntr_id},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#suggestBdetails').html(data.content);
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
			});
			
			$(document).on('change', '#eceCenterDetails', function(){
				var cntr_id = $(this).val();
				$('#suggestBdetails').html('');
				$.ajax({
					type : "POST",
					url : baseUrl + "student/booking/ece_cntrsdl_details",
					data : {cntr_id:cntr_id},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#suggestBdetails').html(data.content);
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
			});
			
			$("#sdtBooking").validate({
				rules:{
					center:{
						required: true,
					},
				},
				messages:{
					center:{
						required: null,
					},
				},
				submitHandler : function () {
					$('.scheduleLoader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "student/booking/sdt",
						data : $('#sdtBooking').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById("sdtBooking").reset();
								$('#bookingContent').html(data.details_content);
								$('.scheduleLoader').hide();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else if(data.status == "booked"){
								document.getElementById("sdtBooking").reset();
								$('#bookingMessaging').html(data.details_content);
								$('.scheduleLoader').hide();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else{
								//have end check.
							}
							return false;
						}
					});
				}
			});
			
			$("#workshopBooking").validate({
				rules:{
					center:{
						required: true,
					},
				},
				messages:{
					center:{
						required: null,
					},
				},
				submitHandler : function () {
					$('.scheduleLoader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "student/booking/workshop",
						data : $('#workshopBooking').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById("workshopBooking").reset();
								$('#bookingContent').html(data.details_content);
								$('.scheduleLoader').hide();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else if(data.status == "booked"){
								document.getElementById("workshopBooking").reset();
								$('#bookingMessaging').html(data.details_content);
								$('.scheduleLoader').hide();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else{
								//have end check.
							}
							return false;
						}
					});
				}
			});
			
			$("#eceExamBooking").validate({
				rules:{
					center:{
						required: true,
					},
				},
				messages:{
					center:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#scheduleLoader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "student/booking/eceexam",
						data : $('#eceExamBooking').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById("eceExamBooking").reset();
								$('#bookingContent').html(data.details_content);
								$('.scheduleLoader').hide();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else if(data.status == "booked"){
								document.getElementById("eceExamBooking").reset();
								$('#bookingMessaging').html(data.details_content);
								$('.scheduleLoader').hide();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else{
								//have end check.
							}
							return false;
						}
					});
				}
			});
			
			$(document).on('click', '.upspan-btn', function(){
				var check_completed = $(this).attr('data-completed');
				
				if(check_completed == '1')
				{
					var get_booking = $(this).attr('data-booking');
					var get_book_u = $(this).attr('data-u');
					var check_mrks_type = $(this).attr('data-mrks-type');
					if(check_mrks_type == 'SDT')
					{
						var sbm_url = baseUrl + "faculty/schedules/sdt_mrks_submit";
					}else if(check_mrks_type == 'WORKSHOP')
					{
						var sbm_url = baseUrl + "faculty/schedules/workshop_mrks_submit";
					}
					
					$('#myModalUpMrks').modal('show'); 
					$("#upMrks").validate({
						rules:{
							score:{
								required: true,
								number:true
							},
							total_score:{
								required: true,
								number:true
							},
							attendance:{
								required: true,
							},
						},
						submitHandler : function () {
							$('#depositLoader').show();
							// your function if, validate is success
							$.ajax({
								type : "POST",
								url : sbm_url,
								data : $('#upMrks').serialize()+'&booking='+get_booking+'&booking_std='+get_book_u,
								dataType : "json",
								success : function (data) {
									if(data.status == "ok")
									{
										document.getElementById("upMrks").reset();
										$('.change-to-score-'+get_booking).html(data.score);
										$('.change-to-totalscore-'+get_booking).html(data.total_score);
										$('.change-to-attedance-'+get_booking).html(data.attendance);
										$('.change-to-completed-'+get_booking).html(data.up_btn_dactve);
										$('#depositLoader').hide();
										$('#myModalUpMrks').modal('hide'); 
										$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
										sqtoken_hash=data._jwar_t_kn_;
										return false;
									}else{
										//have end check.
										return false;
									}
									return false;
								}
							});
						}
					});
				}
			});
		});
	</script>
	
	<script type="text/javascript">
		$("#evaluationSubmission").validate({
			rules:{
				faculty:{
					required: true,
				},
				title:{
					required: true,
				},
				description:{
					required: true,
				},
			},
			messages:{
				faculty:{
					required: null,
				},
				title:{
					required: null,
				},
				description:{
					required: null,
				},
			},
			submitHandler : function () {
				$('#scheduleLoader').show();
				// your function if, validate is success
				$.ajax({
					type : "POST",
					url : baseUrl + "student/evaluation/submitevaluation",
					data : $('#evaluationSubmission').serialize(),
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							document.getElementById("evaluationSubmission").reset();
							$('#alert').html(data.success);
							$('html, body').animate({
								scrollTop: $("body").offset().top
							 }, 1000);
							$('#scheduleLoader').hide();
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							return false;
						}else if(data.status == "error"){
							$('#alert').html(data.error);
							$('html, body').animate({
								scrollTop: $("body").offset().top
							 }, 1000);
							$('#scheduleLoader').hide();
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							return false;
						}else{
							//have end check.
						}
						return false;
					}
				});
			}
		});
		
		$("#evaluationSubmissionFaculty").validate({
			rules:{
				student:{
					required: true,
				},
				title:{
					required: true,
				},
				description:{
					required: true,
				},
			},
			messages:{
				student:{
					required: null,
				},
				title:{
					required: null,
				},
				description:{
					required: null,
				},
			},
			submitHandler : function () {
				$('#scheduleLoader').show();
				// your function if, validate is success
				$.ajax({
					type : "POST",
					url : baseUrl + "faculty/evaluation/submitevaluation",
					data : $('#evaluationSubmissionFaculty').serialize(),
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							document.getElementById("evaluationSubmissionFaculty").reset();
							$('#alert').html(data.success);
							$('html, body').animate({
								scrollTop: $("body").offset().top
							 }, 1000);
							$('#scheduleLoader').hide();
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							return false;
						}else if(data.status == "error"){
							$('#alert').html(data.error);
							$('html, body').animate({
								scrollTop: $("body").offset().top
							 }, 1000);
							$('#scheduleLoader').hide();
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							return false;
						}else{
							//have end check.
						}
						return false;
					}
				});
			}
		});
		
		$("#mainContactForm").validate({
			rules:{
				name:{
					required: true,
				},
				email:{
					required: true,
				},
				phone:{
					required: true,
					number: true,
				},
				subject:{
					required: true,
				},description:{
					required: true,
				},
			},
			messages:{
				name:{
					required: null,
				},
				email:{
					required: null,
				},
				phone:{
					required: null,
					number: null,
				},
				subject:{
					required: null,
				},description:{
					required: null,
				},
			},
			submitHandler : function () {
				$('#scheduleLoader').show();
				// your function if, validate is success
				$.ajax({
					type : "POST",
					url : baseUrl + "contact/send",
					data : $('#mainContactForm').serialize(),
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							document.getElementById("mainContactForm").reset();
							$('#alert').html(data.success);
							$('html, body').animate({
								scrollTop: $("body").offset().top
							 }, 1000);
							$('#scheduleLoader').hide();
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							return false;
						}else if(data.status == "error"){
							$('#alert').html(data.error);
							$('html, body').animate({
								scrollTop: $("body").offset().top
							 }, 1000);
							$('#scheduleLoader').hide();
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							return false;
						}else{
							//have end check.
						}
						return false;
					}
				});
			}
		});
	</script>
	<script type="text/javascript">
		function toggleIcon(e) {
			$(e.target)
				.prev('.panel-heading')
				.find(".more-less")
				.toggleClass('glyphicon-plus glyphicon-minus');
		}
		$('.panel-group').on('hidden.bs.collapse', toggleIcon);
		$('.panel-group').on('shown.bs.collapse', toggleIcon);
	</script>
	<script type="text/javascript">
		function displayMainPassword() {
		  var x = document.getElementById("mainPass");
		  if (x.type === "password") {
			x.type = "text";
		  } else {
			x.type = "password";
		  }
		}
		function displayConfirmPassword() {
		  var x = document.getElementById("confirmPass");
		  if (x.type === "password") {
			x.type = "text";
		  } else {
			x.type = "password";
		  }
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
		  // Add smooth scrolling to all links
		  $("a.enable-scroll").on('click', function(event) {

			// Make sure this.hash has a value before overriding default behavior
			if (this.hash !== "") {
			  // Prevent default anchor click behavior
			  //event.preventDefault();

			  // Store hash
			  var hash = this.hash;

			  // Using jQuery's animate() method to add smooth page scroll
			  // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
			  $('html, body').animate({
				scrollTop: $(hash).offset().top
			  }, 800, function(){
		   
				// Add hash (#) to URL when done scrolling (default click behavior)
				window.location.hash = hash;
			  });
			} // End if
		  });
		});
	</script>
  </body>
</html>