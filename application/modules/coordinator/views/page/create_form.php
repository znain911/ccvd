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
			<label class="col-md-8 control-label">Title</label>
			<div class="col-md-4">
				<input type="text" name="title" placeholder="Enter Title" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-6 control-label">Short Description</label>
			<div class="col-md-6">
				<textarea name="short_description" class="form-control" rows="5"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Location</label>
			<div class="col-md-4">
				<select name="location" class="form-control">
					<option value="">Select Page Location</option>
					<option value="1">Header</option>
					<option value="2">Footer</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-12 control-label">Description</label>
			<div class="col-md-12">
				<textarea name="details" class="textarea form-control ckeditor" rows="15" data-height="350"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" checked />&nbsp;&nbsp;Published</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />&nbsp;&nbsp;Unpublished</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit" onclick="document.getElementById('createData').value=CKEDITOR.instances.details.getData();CKEDITOR.instances.details.destroy()">Create</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New</button>
</div>