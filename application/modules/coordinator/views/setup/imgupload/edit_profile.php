<?php 
	$row_info = $this->Organogram_model->get_info($id);
?>
<div class="form-cntnt form-number-<?php echo $id; ?>">
	<h2 class="frm-title-ms">Edit Profile</h2>
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
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<a style="margin-bottom: 5px; display: inline-block; width: auto; padding: 7px 0;" href="#modal-without-animation" data-id="<?php echo $this->session->userdata('active_user'); ?>" class="row-action-change-password btn btn-block btn-success btn-xs p-l-10 p-r-10" data-toggle="modal">Change Password</a>
		</div>
	<?php echo form_close(); ?>
</div>