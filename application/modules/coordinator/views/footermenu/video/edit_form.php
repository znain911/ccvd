<?php 
	$row_info = $this->Footermenu_menu_model->get_info($id);
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
			<label class="col-md-8 control-label">Title</label>
			<div class="col-md-4">
				<input type="text" name="title" placeholder="Enter Title" class="form-control" value="<?php echo $row_info['title']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Video Link</label>
			<div class="col-md-4">
				<input type="text" name="link" placeholder="Enter Embedded Link" class="form-control" value="<?php echo $row_info['link']; ?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Ordering</label>
			<div class="col-md-4">
				<input type="text" name="ordering" placeholder="Enter Ordering" class="form-control" value="<?php echo $row_info['ordering']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($row_info['status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit" onclick="document.getElementById('updateData')">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>