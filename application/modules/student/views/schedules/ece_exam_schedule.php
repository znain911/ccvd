<?php 
	$check_eceexam_schedule = $this->Course_model->ece_available_schedule();
?>
<div class="row">
	<div class="col-lg-6">
		<div class="end-module-exam">
			<div class="starter-module-exam-start">
				<div class="endmodule-exm-title">Schedule</div>
				<?php 
					$now_date = strtotime(date("Y-m-d"));
					$boking_to_date = strtotime($check_eceexam_schedule['endmschedule_to_date']);
					$boking_from_date = strtotime($check_eceexam_schedule['endmschedule_from_date']);
					if($now_date >= $boking_from_date && $now_date <= $boking_to_date):
				?>
				<div class="schedule-available text-center">
					<div class="subschdle">
						<span>From</span> <?php echo date("d M Y", strtotime($check_eceexam_schedule['endmschedule_from_date'])); ?> <span>To</span> <?php echo date("d M Y", strtotime($check_eceexam_schedule['endmschedule_to_date'])); ?>
					</div>
				</div>
				<?php else: ?>
				<h2>The schedule is unavailable now.</h2>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="end-module-exam">
			<span class="arrow-sign-to-schedule"></span>
			<div class="starter-module-exam-start">
				<div class="endmodule-exm-title">ECE Examination (Regular)</div>
				<h2>The ECE Examination (Regular) will be available after scheduled by Coordinator</h2>
				<?php 
					$check_ecealr_booked = $this->Course_model->check_ece_alrbooked(date("Y-m-d", strtotime($check_eceexam_schedule['endmschedule_create_date'])), $check_eceexam_schedule['endmschedule_to_date']);
					if($check_ecealr_booked == true):
					$get_center_details = $this->Course_model->get_ececenter_location($check_ecealr_booked['booking_schedule_centerid']);
				?>
				<div id="appliedDetails">
					<button class="start-exm-btn book-details-btn-after">Booking Details</button>
					<div class="booking-details-after-applied">
						<p><strong>Application ID : </strong> <?php echo $check_ecealr_booked['booking_application_id']; ?></p>
						<p><strong>Center Location : </strong> <?php echo $get_center_details['center_location']; ?></p>
						<p><strong>Schedule Date & Time : </strong> <?php echo date("d M Y", strtotime($get_center_details['centerschdl_to_date'])); ?>, <?php echo $get_center_details['centerschdl_to_time']; ?></p>
						<p><strong>Booking Date : </strong> <?php echo date("d M Y", strtotime($check_ecealr_booked['booking_date'])); ?>, <?php echo date("g:i A", strtotime($check_ecealr_booked['booking_date'])); ?></p>
					</div>
				</div>
				<?php else: ?>
				<div id="appliedDetails">
					<?php if($now_date >= $boking_from_date && $now_date <= $boking_to_date): ?>
					<button class="start-exm-btn booking-now-bttun" data-for="phase">Booking Now</button>
					<span class="booking-indicator indicator-phase" style="display:none;"></span>
					<?php else: ?>
					<button class="start-exm-btn disbale-exm-btn" disabled>Booking Now</button>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php 
		if($check_ecealr_booked == false):
		if($now_date >= $boking_from_date && $now_date <= $boking_to_date): ?>
		<div class="end-module-exam booking-frm-phase" style="display:none;">
			<div class="starter-module-exam-start">
				<div class="endmodule-exm-title">Booking</div>
				<?php 
					$attr = array('id' => 'eceExamBooking');
					echo form_open('', $attr);
					$get_application_id = $this->Course_model->get_total_eceapplications();
				?>
				<div id="scheduleLoader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
				<div class="form-group row">
					<label for="" class="col-lg-4 text-left">Application ID</label>
					<div class="col-lg-8 text-left">
						<strong style="display: block; margin: 15px 0px 0px; color: rgb(170, 0, 0); font-size: 17px;"><?php echo $get_application_id; ?></strong>
					</div>
					<input type="hidden" name="applicant_ID" value="<?php echo $get_application_id; ?>" />
					<input type="hidden" name="schedule" value="<?php echo $check_eceexam_schedule['endmschedule_id']; ?>" />
				</div>
				<div class="form-group row">
					<label for="" class="col-lg-2">Center</label>
					<div class="col-lg-10">
						<select name="center" class="form-control">
							<option value="">Select Center Location</option>
							<?php  
								$get_centerschedules = $this->Course_model->get_ece_centerschedules($check_eceexam_schedule['endmschedule_id']);
								foreach($get_centerschedules as $center):
							?>
							<option value="<?php echo $center['centerschdl_id']; ?>"><?php echo $center['center_location']; ?>-Schedule: <?php echo date("d M Y", strtotime($center['centerschdl_to_date'])); ?> <?php echo $center['centerschdl_to_time']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-12" id="centerDetails"></div>
				</div>
				<div class="form-group row">
					<label for="" class="col-lg-3"></label>
					<div class="col-lg-9 text-right">
						<button type="submit" class="btn btn-raised btn-success" >Booking Now </button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
		<?php endif; ?> 
		<?php endif; ?>
	</div>
</div>