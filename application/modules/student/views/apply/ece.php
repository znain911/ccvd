<?php 
	$sdt_schedule_info = $this->Course_model->get_ecescheulde_info($schdle_id);
?>
<div class="result-crtft-cgp-panel">
	<h4 class="rslt-cgp-title">APPLY FOR <?php echo $sdt_schedule_info['endmschedule_title']; ?></h4>
</div>
<div class="result-table">
	<div class="end-module-exam booking-frm-sdt">
		<div class="starter-module-exam-start">
			<?php 
				$attr = array('id' => 'eceExamBooking');
				echo form_open('', $attr);
			?>
			<div class="scheduleLoader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
			<div id="bookingMessaging"></div>
			<div class="form-group row">
				<label for="" class="col-lg-2 text-right">Center</label>
				<div class="col-lg-4">
					<select name="center" id="eceCenterDetails" class="form-control">
						<option value="">Select Center Location</option>
						<?php  
							$get_centerschedules = $this->Course_model->get_ece_centerschedules($sdt_schedule_info['endmschedule_id']);
							foreach($get_centerschedules as $center):
						?>
						<option value="<?php echo $center['centerschdl_id']; ?>"><?php echo $center['center_location']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-lg-6" style="position:relative">
					<div id="suggestBdetails"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12" class="centerDetails-sdt"></div>
			</div>
			<div class="form-group row">
				<div class="col-lg-12 text-left">
					<input type="hidden" name="schedule" value="<?php echo $sdt_schedule_info['endmschedule_id']; ?>" />
					<button type="submit" class="btn btn-raised btn-success" style="background: rgb(8, 237, 217) none repeat scroll 0% 0%; color: rgb(51, 51, 51) ! important; width: 250px;">Booking Now </button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<h2 class="course-page-title"><?php echo $sdt_schedule_info['endmschedule_title']; ?> BOOKING DETAILS</h2>
		<div class="result-table">
			<p class="result-tbl-head"><strong>Already Booked Session</strong></p>
			<table class="table">
				<thead>
					<tr>
						<th class="text-left">Session Title</th>
						<th class="text-center">Application ID</th>
						<th class="text-center">Center Location</th>
						<th class="text-center">Center Schedule</th>
						<th class="text-center">Booking Date</th>
					</tr>
				</thead>
				<tbody id="bookingContent">
					<?php require_once APPPATH.'modules/student/views/bookings/all_ece_bookings.php' ?>
				</tbody>
			</table>
		</div>
	</div>
</div>