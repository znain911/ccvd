<?php 
	$schedule_info = $this->Workshop_model->get_centerschedule_info($schedule_id);
?>
<div class="form-cntnt lesson-form-number-<?php echo $schedule_id; ?>">
	<h2 class="frm-title-ms">Edit Schedule</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'updateCenterData');
		$hidden = array('schedule_id' => $schedule_id, 'parent_schedule_id' => $schedule_info['centerschdl_parentschdl_id']);
		echo form_open('#', $attr, $hidden);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule Title</label>
			<div class="col-md-4">
				<input type="text" class="form-control" value="<?php echo $this->Workshop_model->get_schedule_title($schedule_info['centerschdl_parentschdl_id']); ?>" disabled />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Center</label>
			<div class="col-md-4">
				<select name="center_id" class="form-control">
					<option value="">Select Center</option>
					<?php 
						$center_lists = $this->Workshop_model->get_center_lists();
						foreach($center_lists as $center):
					?>
						<option value="<?php echo $center['center_id']; ?>" <?php echo ($schedule_info['centerschdl_center_id'] == $center['center_id'])? 'selected' : null; ?>><?php echo $center['center_location']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Date</label>
			<div class="col-md-4">
				<input type="text" name="to_date" value="<?php echo $schedule_info['centerschdl_to_date']; ?>" class="custominp daterange-singledate" />
				<span style="color: #f00;display: block;font-size: 12px;">Note : Please select date within <?php echo booking_schedule_range($schedule_id, 'WORKSHOP'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Time</label>
			<div class="col-md-4">
				<input type="text" name="to_time" value="<?php echo $schedule_info['centerschdl_to_time']; ?>" class="custominp datetimepicker2" placeholder="Time"  />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Maximum Sit</label>
			<div class="col-md-4">
				<input type="text" name="max_sit" value="<?php echo $schedule_info['centerschdl_maximum_sit']; ?>" class="custominp" placeholder="50" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Booking Close Date & Time</label>
			<div class="col-md-4">
				<?php 
					$booking_close = explode(' ', $schedule_info['centerschdl_last_bookingtime']);
				?>
				<input type="text" name="close_date" value="<?php echo $booking_close[0]; ?>" class="custominp daterange-singledate" placeholder="Date" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="close_time" value="<?php echo $booking_close[1]; ?>" class="custominp datetimepicker2" placeholder="Time" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($schedule_info['centerschdl_status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($schedule_info['centerschdl_status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update Schedule</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn" style="display:none">
	<button class="btn btn-purple m-b-5 return-create-lesson" data-schedule="<?php  echo $schedule_info['centerschdl_parentschdl_id']; ?>" type="button">Create New Schedule</button>
	<button class="btn btn-purple m-b-5 back-to-modules" type="button">Back To Schedules</button>
</div>