<?php 
	$schedule_info = $this->F2fschedule_model->get_schedule_info($schedule_id);
?>
<div class="form-cntnt module-form-number-<?php echo $schedule_id; ?>">
	<h2 class="frm-title-ms">Edit Schedule</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'updateData');
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
				<input type="text" name="schedule_title" placeholder="Enter Schedule Title" class="form-control" value="<?php echo $schedule_info['endmschedule_title']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Phase Level</label>
			<div class="col-md-4">
				<select name="phase_id" class="form-control">
					<?php 
						$get_phases = $this->Schedules_model->get_phases();
						foreach($get_phases as $phase):
					?>
						<option value="<?php echo $phase['phase_id']; ?>" <?php echo ($schedule_info['endmschedule_phase_id'] == $phase['phase_id'])? 'selected' : null; ?>><?php echo $phase['phase_name']; ?></option>
					<?php
						endforeach;
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule</label>
			<div class="col-md-4">
				<input type="text" value="<?php echo $schedule_info['endmschedule_from_date']; ?>" name="from_date" class="custominp daterange-singledate" />&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;<input type="text" name="to_date" value="<?php echo $schedule_info['endmschedule_to_date']; ?>" class="custominp daterange-singledate" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($schedule_info['endmschedule_status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($schedule_info['endmschedule_status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update Schedule</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>