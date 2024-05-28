<div class="form-cntnt" style="display:none">
	<h2 class="frm-title-ms">Create Center Schedule</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'createCenterData');
		$hidden = array('schedule_id' => $schedule_id);
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
				<input type="text" class="form-control" value="<?php echo $this->F2fschedule_model->get_schedule_title($schedule_id); ?>" disabled />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Center</label>
			<div class="col-md-4">
				<select name="center_id" class="form-control">
					<option value="">Select Center</option>
					<?php 
						$center_lists = $this->F2fschedule_model->get_center_lists();
						foreach($center_lists as $center):
					?>
						<option value="<?php echo $center['center_id']; ?>"><?php echo $center['center_location']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Date</label>
			<div class="col-md-4">
				<input type="text" name="to_date" class="custominp daterange-singledate" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Time</label>
			<div class="col-md-4">
				<input type="text" name="to_time" class="custominp datetimepicker2" placeholder="Time"  />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Maximum Sit</label>
			<div class="col-md-4">
				<input type="text" name="max_sit" class="custominp" placeholder="50" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Booking Close Date & Time</label>
			<div class="col-md-4">
				<input type="text" name="close_date" class="custominp daterange-singledate" placeholder="Date" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="close_time" class="custominp datetimepicker2" placeholder="Time" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" checked />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Create schedule</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New Schedule</button>
	<button class="btn btn-purple m-b-5 back-to-modules" type="button">Back To Schedules</button>
</div>