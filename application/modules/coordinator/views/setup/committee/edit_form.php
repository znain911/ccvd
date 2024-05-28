<?php 
	$row_info = $this->Organogram_model->get_info($id);
?>
<div class="form-cntnt form-number-<?php echo $id; ?>">
	<h2 class="frm-title-ms">Edit</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'updateData');
		$hidden = array('id' => $id);
		echo form_open('#', $attr, $hidden);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Position</label>
			<div class="col-md-4">
				<input type="text" name="position" class="form-control" placeholder="Enter Position Number" value="<?php echo $row_info['owner_position']; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Full Name</label>
			<div class="col-md-4">
				<input type="text" name="full_name" value="<?php echo $row_info['owner_name']; ?>" placeholder="Enter Full Name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Designation</label>
			<div class="col-md-4">
				<input type="text" name="designation" value="<?php echo $row_info['owner_designation']; ?>" placeholder="Enter Designation" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Recent Photo</label>
			<div class="col-md-4">
				<?php if($row_info['owner_photo']): ?>
				<div class="old-photo">
					<img src="<?php echo attachment_url('coordinators/'.$row_info['owner_photo']); ?>" alt="Photo" />
				</div>
				<?php endif; ?>
				<input type="file" name="recent_photo">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Show at Landing Page</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="show_at_landing" value="1" <?php echo ($row_info['owner_show_at_landing'] == '1')? 'checked' : null; ?> />&nbsp;&nbsp;Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="show_at_landing" value="0" <?php echo ($row_info['owner_show_at_landing'] == '0')? 'checked' : null; ?> />&nbsp;&nbsp;No</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($row_info['owner_activate'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['owner_activate'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>