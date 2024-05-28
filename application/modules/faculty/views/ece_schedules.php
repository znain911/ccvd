<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9 myac-container">
					<div id="applyTiSession"></div>
					<div class="result-table">
						<div id="ftwofScheduleLoader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
						<p class="result-tbl-head"><strong>Available ECE Schedules</strong></p>
						<table class="table" style="font-size:12px;">
							<thead>
								<tr>
									<th class="text-left">Schedule Title</th>
									<th class="text-center">Schedule</th>
									<th class="text-center">Schedule Status</th>
									<th class="text-center">Booking</th>
								</tr>
							</thead>
							<tbody id="sessionContent">
								<?php require_once APPPATH.'modules/faculty/views/ece/all_sessions.php' ?>
							</tbody>
						</table>
					</div>
					
					<br />
					<div class="result-table">
						<p class="result-tbl-head"><strong>Applied ECE Schedules</strong></p>
						<table class="table" style="font-size:12px;">
							<thead>
								<tr>
									<th class="text-left">Application ID</th>
									<th class="text-center">Schedule Title</th>
									<th class="text-center">Center Location</th>
									<th class="text-center">Center Schedule</th>
									<th class="text-center">Applied Date</th>
									<th class="text-center">Status</th>
								</tr>
							</thead>
							<tbody id="bookingContent">
								<?php require_once APPPATH.'modules/faculty/views/ece/all_bookings.php' ?>
							</tbody>
						</table>
					</div>
					
					<br />
					<div class="result-table">
						<p class="result-tbl-head"><strong>My ECE Programmes</strong></p>
						<table class="table" style="font-size:12px;">
							<thead>
								<tr>
									<th class="text-left">Application ID</th>
									<th class="text-center">Schedule Title</th>
									<th class="text-center">Center Location</th>
									<th class="text-center">Center Schedule</th>
								</tr>
							</thead>
							<tbody>
								<?php require_once APPPATH.'modules/faculty/views/ece/my_programmes.php' ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.session-row', function(){
				var get_schedule = $(this).attr('data-schedule');
				$('#ftwofScheduleLoader').show();
				$.ajax({
					type : "POST",
					url : baseUrl + "faculty/booking/ece_frmsubmission",
					data : {schedule:get_schedule, _jwar_t_kn_:sqtoken_hash},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#applyTiSession').html(data.content);
							$('#ftwofScheduleLoader').hide();
							
							$("#ftwofBooking").validate({
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
										url : baseUrl + "faculty/booking/eceexam",
										data : $('#ftwofBooking').serialize(),
										dataType : "json",
										success : function (data) {
											if(data.status == "ok")
											{
												$('#scheduleLoader').hide();
												$('.f2f-booking-form').remove();
												
												$('#sessionContent').html(data.sessions);
												$('#bookingContent').html(data.bookings);
												
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
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>