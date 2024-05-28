<div class="form-cntnt" style="display:none">
	<h2 class="frm-title-ms">Create New Lesson (<?php echo $module_info['phase_name']; ?>, <?php echo $module_info['module_name']; ?>)</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'phaseAlession');
		$hidden = array('phase_id' => $phase_id, 'module_id' => $module_id);
		echo form_open('#', $attr, $hidden);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Section/Lesson Title</label>
			<div class="col-md-4">
				<input type="text" name="section_title" placeholder="Enter Section/Lesson title" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Lesson No</label>
			<div class="col-md-4" id="changePosition">
				<input type="text" name="position" class="form-control" value="<?php echo $this->Course_model->lesson_position($module_id); ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label"></label>
			<div class="col-md-4">
				<label class="write_cnt"><input type="radio" name="choose_opt" checked />&nbsp;&nbsp;Write Content</label>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label class="upload_cnt"><input type="radio" name="choose_opt" />&nbsp;&nbsp;Upload Content</label>
			</div>
		</div>
		
		<div class="form-group upload-content-area" style="display:none;">
			<label class="col-md-8 control-label">Upload Content (pdf, doc)</label>
			<div class="col-md-4">
				<input type="file" name="uploaded_lesson" />
			</div>
		</div>
		
		<div class="form-group write-content-area">
			<label class="col-md-12 control-label">Description</label>
			<div class="col-md-12">
				<textarea name="description" class="textarea form-control ckeditor" rows="15" data-height="350"></textarea>
			</div>
		</div>
		
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit" onclick="document.getElementById('phaseAlession').value=CKEDITOR.instances.description.getData();CKEDITOR.instances.description.destroy()">Create New Lesson</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button" onclick="document.getElementById('createData').value=CKEDITOR.instances.content.getData();CKEDITOR.instances.content.destroy()">Create New Lesson</button>
	<button class="btn btn-purple m-b-5 back-to-modules" data-phase="<?php echo $phase_id; ?>" type="button">Back To Modules</button>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.upload_cnt', function(){
			$('.write-content-area').hide();
			$('.upload-content-area').show();
		});
		$(document).on('click', '.write_cnt', function(){
			$('.write-content-area').show();
			$('.upload-content-area').hide();
		});
	});
</script>