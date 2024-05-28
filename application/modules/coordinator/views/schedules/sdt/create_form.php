<div class="form-cntnt" style="display:none">
	<h2 class="frm-title-ms">Create New Schedule</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'createData', 'enctype' => 'multipart/form-data');
		echo form_open('#', $attr);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		<!--
		<div class="form-group">
			<label class="col-md-8 control-label">Select SDT Type</label>
			<div class="col-md-4">
				<select name="" class="form-control" disabled>
					<option value="SDT 1" <?php echo ($sdt_type == '1')? 'selected' : null; ?>>SDT 1</option>
					<option value="SDT 2" <?php echo ($sdt_type == '2')? 'selected' : null; ?>>SDT 2</option>
				</select>
			</div>
		</div>
		-->
		<input type="hidden" name="schedule_title" value="<?php echo ($sdt_type == '1')? 'SDT 1' : 'SDT 2'; ?>" />
		<input type="hidden" name="sdt_type" value="<?php echo $sdt_type; ?>" />
		<div class="form-group">
			<label class="col-md-8 control-label">Phase Level</label>
			<div class="col-md-4">
				<select name="phase_id" class="form-control">
					<?php 
						$get_phases = $this->Schedules_model->get_phases();
						foreach($get_phases as $phase):
						if($phase['phase_id'] == '1')
						{
							continue;
						}
					?>
						<option value="<?php echo $phase['phase_id']; ?>"><?php echo $phase['phase_name']; ?></option>
					<?php
						endforeach;
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule</label>
			<div class="col-md-4">
				<input type="text" name="from_date" class="custominp daterange-singledate" />&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;<input type="text" name="to_date" class="custominp daterange-singledate" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Upload Resource(Students)</label>
			<div class="col-md-4">
				<input type="file" name="students_resource" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Upload Resource(Faculties)</label>
			<div class="col-md-4">
				<input type="file" name="faculties_resource" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" checked />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Create New Schedule</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New Schedule</button>
</div>