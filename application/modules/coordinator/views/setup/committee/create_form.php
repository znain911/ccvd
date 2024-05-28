<div class="form-cntnt" style="display:none">
	<h2 class="frm-title-ms">Create New</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'createData');
		echo form_open('#', $attr);
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
				<input type="text" name="position" class="form-control" placeholder="Enter Position Number" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Full Name</label>
			<div class="col-md-4">
				<input type="text" name="full_name" placeholder="Enter Full Name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Designation</label>
			<div class="col-md-4">
				<input type="text" name="designation" placeholder="Enter Designation" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Recent Photo</label>
			<div class="col-md-4">
				<input type="file" name="recent_photo">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Show at Landing Page</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="show_at_landing" value="1" checked />&nbsp;&nbsp;Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="show_at_landing" value="0" />&nbsp;&nbsp;No</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" checked />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Create</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New</button>
</div>