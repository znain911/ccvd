<?php 
	$module_info = $this->Course_model->get_module_info($module_id);
?>
<div class="form-cntnt module-form-number-<?php echo $module_id; ?>">
	<h2 class="frm-title-ms">Edit <?php echo $module_info['module_name']; ?></h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'upPhaseA');
		$hidden = array('phase_id' => $module_info['module_phase_id'], 'module_id' => $module_id);
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
				<input type="text" name="module_name" placeholder="Enter module name" class="form-control" value="<?php echo $module_info['module_name']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Module Title</label>
			<div class="col-md-4">
				<input type="text" name="module_title" placeholder="Enter book/module title" class="form-control" value="<?php echo $module_info['module_title']; ?>">
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update Module</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" data-phase="<?php echo $module_info['module_phase_id']; ?>" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>