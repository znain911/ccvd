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
			<label class="col-md-8 control-label">Full Name</label>
			<div class="col-md-4">
				<input type="text" name="full_name" placeholder="Enter Full Name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Email</label>
			<div class="col-md-4">
				<input type="text" name="email" placeholder="Enter Email" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Password</label>
			<div class="col-md-4">
				<input type="password" name="password" placeholder="Enter Password" class="form-control">
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
						echo '<option value="'.$role['role_id'].'">'.$role['role_title'].'</option>';
						endforeach;
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Recent Photo</label>
			<div class="col-md-4">
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
				?>
				<label><input type="checkbox" name="permission[]" value="<?php echo $manage['manage_id']; ?>" /> &nbsp;&nbsp;<?php echo $manage['mange_title']; ?> </label><br />
				<?php endforeach; ?>
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