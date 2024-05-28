<div class="form-cntnt" style="display:none">
	<h2 class="frm-title-ms">Create New Module</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'phaseA');
		$hidden = array('phase_id' => $phase_id);
		echo form_open('#', $attr, $hidden);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Module Name</label>
			<div class="col-md-4">
				<input type="text" name="module_name" placeholder="Enter module name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Module Title</label>
			<div class="col-md-4">
				<input type="text" name="module_title" placeholder="Enter book/module title" class="form-control">
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Create New Module</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New Module</button>
</div>