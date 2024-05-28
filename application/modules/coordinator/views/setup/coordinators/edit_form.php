<?php 
	$row_info = $this->Coordinator_model->get_info($id);
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
			<label class="col-md-8 control-label">Full Name</label>
			<div class="col-md-4">
				<input type="text" name="full_name" value="<?php echo $row_info['owner_name']; ?>" placeholder="Enter Full Name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Email</label>
			<div class="col-md-4">
				<input type="text" name="email" value="<?php echo $row_info['owner_email']; ?>" placeholder="Enter Email" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Role</label>
			<div class="col-md-4">
				<select name="role_id" class="form-control">
					<option value="">Select Role</option>
					<?php 
						$get_roles = $this->Coordinator_model->get_roles();
						foreach($get_roles as $role):
					?>
						<option value="<?php echo $role['role_id']; ?>" <?php echo ($row_info['owner_role_id'] == $role['role_id'])? 'selected' : null; ?>><?php echo $role['role_title']; ?></option>
					<?php endforeach; ?>
				</select>
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
			<div class="col-md-offset-8 col-md-4 text-center">
				<div class="frm-legend"><span class="legend-label">Permission</span></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label"></label>
			<div class="col-md-4">
				<?php 
					$get_manages = $this->Coordinator_model->get_admin_manages();
					foreach($get_manages as $manage):
					$get_permissionby_adminid = $this->Coordinator_model->get_permissions_byid($row_info['owner_id'], $manage['manage_id']);
				?>
				<label><input type="checkbox" name="permission[]" value="<?php echo $manage['manage_id']; ?>" <?php echo ($get_permissionby_adminid['permission_permission_id'] === $manage['manage_id'])? 'checked' : null; ?> /> &nbsp;&nbsp;<?php echo $manage['mange_title']; ?> </label><br />
				<?php endforeach; ?>
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