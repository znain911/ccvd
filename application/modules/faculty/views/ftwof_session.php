<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h2 class="course-page-title">F2F Session</h2>
					<div id="applyTiSession"></div>
					<div class="result-table">
						<div id="ftwofScheduleLoader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
						<p class="result-tbl-head"><strong>All Sessions</strong></p>
						<table class="table">
							<thead>
								<tr>
									<th class="text-left">Session Title</th>
									<th class="text-center">Phase Level</th>
									<th class="text-center">Schedule</th>
									<th class="text-center">Schedule Status</th>
									<th class="text-center">Booking</th>
								</tr>
							</thead>
							<tbody id="sessionContent">
								<?php require_once APPPATH.'modules/faculty/views/session/all_sessions.php' ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<h2 class="course-page-title">Booked F2F Session</h2>
					<div class="result-table">
						<p class="result-tbl-head"><strong>All Booked Sessions</strong></p>
						<table class="table">
							<thead>
								<tr>
									<th class="text-left">Session Title</th>
									<th class="text-center">Phase Level</th>
									<th class="text-center">Application ID</th>
									<th class="text-center">Center Location</th>
									<th class="text-center">Center Schedule</th>
									<th class="text-center">Booking Date</th>
								</tr>
							</thead>
							<tbody id="bookingContent">
								<?php require_once APPPATH.'modules/faculty/views/session/all_bookings.php' ?>
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
				var phase_level = $(this).attr('data-phase');
				$('#ftwofScheduleLoader').show();
				$.ajax({
					type : "POST",
					url : baseUrl + "faculty/booking/ftwof_frmsubmission",
					data : {schedule:get_schedule, phase_level:phase_level, _jwar_t_kn_:sqtoken_hash},
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
										url : baseUrl + "faculty/booking/ftwof",
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