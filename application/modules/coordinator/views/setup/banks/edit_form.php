<?php 
	$row_info = $this->Banks_model->get_info($id);
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
			<label class="col-md-8 control-label">Bank Name</label>
			<div class="col-md-4">
				<input type="text" name="bank_name" placeholder="Enter Bank Name" class="form-control" value="<?php echo $row_info['bank_name']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Branch Name</label>
			<div class="col-md-4">
				<input type="text" name="bank_branch_name" placeholder="Enter Branch Name" class="form-control" value="<?php echo $row_info['bank_branch_name']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Account Name</label>
			<div class="col-md-4">
				<input type="text" name="bank_account_name" placeholder="Enter Account Name" class="form-control" value="<?php echo $row_info['bank_account_name']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Account Number</label>
			<div class="col-md-4">
				<input type="text" name="bank_account_number" placeholder="Enter Account Number" class="form-control" value="<?php echo $row_info['bank_account_number']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Photo Icon</label>
			<div class="col-md-4">
				<?php $photo = attachment_url('banks/'.$row_info['bank_photo_icon']); ?>
				<div><img src="<?php echo $photo; ?>" width="40" alt="Photo"></div>
				<input type="file" name="bank_icon">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($row_info['bank_status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['bank_status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>