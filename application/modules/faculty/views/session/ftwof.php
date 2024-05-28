<div class="f2f-booking-form">
<div class="endmodule-exm-title">Booking Now</div>
	<?php 
		$attr = array('id' => 'ftwofBooking');
		echo form_open('', $attr);
		$get_application_id = $this->Booking_model->get_total_ftwofapplications();
	?>
	<div id="scheduleLoader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
	<div class="form-group row">
		<label for="" class="col-lg-3 text-right">Application ID</label>
		<div class="col-lg-9 text-left">
			<strong style="display: block; margin: 15px 0px 0px; color: rgb(170, 0, 0); font-size: 17px;"><?php echo $get_application_id; ?></strong>
		</div>
		<input type="hidden" name="applicant_ID" value="<?php echo $get_application_id; ?>" />
		<input type="hidden" name="schedule" value="<?php echo $schedule_id; ?>" />
	</div>
	<div class="form-group row">
		<label for="" class="col-lg-3 text-right">Center</label>
		<div class="col-lg-9">
			<select name="center" class="form-control">
				<option value="">Select Center Location</option>
				<?php  
					$get_centerschedules = $this->Booking_model->get_ftwof_centerschedules($schedule_id);
					foreach($get_centerschedules as $center):
				?>
				<option value="<?php echo $center['centerschdl_id']; ?>"><?php echo $center['center_location']; ?>-Schedule: <?php echo date("d M Y", strtotime($center['centerschdl_to_date'])); ?> <?php echo $center['centerschdl_to_time']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="" class="col-lg-3"></label>
		<div class="col-lg-9 text-right">
			<input type="hidden" name="phase_level" value="<?php echo $phase_level; ?>" />
			<button type="submit" class="btn btn-raised btn-success" >Booking Now </button>
		</div>
	</div>
<?php echo form_close(); ?>
</div>